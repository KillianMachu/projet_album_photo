<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $order = $request->input("order") == "titre" || $request->input("order") == "creation" ? $request->input("order") : "titre";
        $by = $request->input("by")== "asc" || $request->input("by")== "desc" ? $request->input("by") : "asc";

        if($request->has("search")){
            $albums = Album::where('titre', 'like', "%".$request->input('search')."%")->orderBy($order,$by)->get();
        }else{
            $albums = Album::orderBy($order,$by)->get();
        }
        
        $photos = [];
        foreach ($albums as $album){
            $photos[] = Photo::whereRaw('LOWER(album_id) = ?', $album->id)->inRandomOrder()->first();
        }

        return view('pages.album.index', compact("albums", "photos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.album.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "titre" => "required",
            "titre-photo.*" => "required",
            "image.*" => "required | file | mimes:jpg,png",
            "note.*" => "required | integer | max:5",
            "tags.*" => "required",
        ]);

        $album = new Album();
        $album->titre = $request->input('titre');
        $album->creation = date('Y-m-d');
        $album->user_id = auth()->user()->id;
        $album->save();

        if($request->input("titre-photo")){
            for($i=0;$i<count($request->input("titre-photo"));$i++) {
                $tags = explode(' ', $request->input('tags')[$i]);

                if($request->file("image")[$i]->isValid()) {
                    $f = $request->file("image")[$i]->hashName();
                    $request->file("image")[$i]->storeAs("public/upload", $f);
                    $image = "/storage/upload/$f";
                }

                $photo = new Photo();
                $photo->titre = $request->input("titre-photo")[$i];
                $photo->url = $image;
                $photo->note = $request->input("note")[$i];
                $photo->album_id = $album->id;
                $photo->save();
                foreach($tags as $t){
                    $select = Tag::whereRaw('LOWER(nom) = ?', strtolower($t))->first();
                    if($select){
                        $photo->tags()->attach($select->id);
                    }
                    else{
                        $tag = new Tag();
                        $tag->nom = $t;
                        $tag->save();
                        $photo->tags()->attach($tag->id);
                    }
                }
            }
        }

        return redirect(route("albumShow", $album->id))->with("info_crea", "L'album a bien été créé !");
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        return view('pages.album.show', ["album" => $album]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {

        foreach($album->photos as $photo){
            foreach($photo->tags as $tag){
                $select = $tag->pivot->where('tag_id', strtolower($tag->pivot->tag_id))->count();
                if($select==1){
                    $tag->delete();
                }
            }
            $photo->tags()->detach();
            $url = $photo->url;
            $f = "public/".substr($url, strlen("/storage/"));
            if(Storage::exists($f)){
                Storage::delete($f);
            }
            $photo->delete();
        }
        $album->delete();
        return redirect(route("albumIndex"))->with("info_del", "L'album a bien été supprimé !");
    }

    public function sort(Request $request){
        if($request->has("search")){
            $albums = Album::where('titre', 'like', "%".$request->input('search')."%")->get();
        }

        $photos = [];

        foreach ($albums as $album){
            $photos[] = Photo::whereRaw('LOWER(album_id) = ?', $album->id)->inRandomOrder()->first();
        }

        return view('pages.album.index', compact("albums", "photos"));
    }

    public function filterPhotos(Request $request, $id){
        $order = $request->input("order") == "titre" || $request->input("order") == "note" ? $request->input("order") : "titre";
        $by = $request->input("order") == "asc" || $request->input("by") == "desc" ? $request->input("by") : "asc";

        $tag = $request->input('tag');
        $titre = $request->input('titre');
        $album = Album::findOrFail($id);
        $query = Photo::query();

        if($tag){
            $query->whereHas('tags', function ($query) use ($tag){
                $query->where('nom', $tag);
            })->where("album_id", $id);
        }

        if($titre){
            $query->where('titre', 'LIKE', "%".$titre."%")->where("album_id", $id);
        }

        else{
            $query->where("album_id", $id);
        }

        $photoFilter = $query->orderBy($order,$by)->get();

        return view('pages.album.show', compact('photoFilter','album'));
    }
}
