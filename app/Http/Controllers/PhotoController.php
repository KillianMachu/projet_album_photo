<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "titre-photo.*" => "required",
            "image.*" => "required | file | mimes:jpg,png",
            "note.*" => "required | integer | max:5",
            "tags.*" => "required",
        ]);

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
            $photo->album_id = $request->input("album_id");
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

        return redirect(route("albumShow", $request->input("album_id")))->with("info_crea", "La photo a bien été ajoutée à l'album !");
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        foreach($photo->tags as $tag){
            $select = $tag->pivot->where('tag_id', strtolower($tag->pivot->tag_id))->count();
            if($select===1){
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
        return redirect(url()->previous())->with("info_del", "La photo a bien été supprimée !");
    }
}