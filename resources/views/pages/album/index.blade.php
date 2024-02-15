@extends('app')

@section('content')
    <div class="albumIndex">
        <div class="discover">
            <div class="container">

                {{-- Si l'on effectue une recherche --}}

                @if (request()->input("search"))
                    @if (count($albums)==1)
                        <h2>Résultat de la recherche : "{{request()->input("search")}}"</h2>
                    @else
                        <h2>Résultats de la recherche : "{{request()->input("search")}}"</h2>
                    @endif
                @else
                    <h2>Découvre les albums !</h2>
                @endif

                {{-- Formulaire de recherche + tri --}}

                <div class="albumFilter">
                    <form action="{{route("albumSort")}}" method="GET" class="searchAlbum">
                        <input type="search" name="search" id="search" value="{{request()->get('search')}}" placeholder="Rechercher">
                        <a href="#" onclick="document.getElementById('submitSearchAlbum').click()"><i class='bx bx-search'></i></a>
                        <input type="submit" value="envoyer" class="albumSearchButton" id="submitSearchAlbum">
                    </form>
                    <form action="{{route("albumIndex")}}" method="GET" class="orderAlbum">
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{request()->get('search')}}">
                        @endif
                        <select name="order" id="order">
                            <option value="" disabled selected hidden>Trier selon ...</option>
                            <option value="titre" {{(request()->get('order')=="titre" ? "selected" : false)}}>Titre</option>
                            <option value="creation" {{(request()->get('order')=="creation" ? "selected" : false)}}>Date de création</option>
                        </select>
                        <select name="by" id="by">
                            <option value="" disabled selected hidden>Par ordre ...</option>
                            <option value="asc" {{(request()->get('by')=="asc" ? "selected" : false)}}>Croissant</option>
                            <option value="desc" {{(request()->get('by')=="desc" ? "selected" : false)}}>Décroissant</option> 
                        </select>
                        <input type="submit" value="Trier" class="orderSubmit">
                    </form>
                </div>

                {{-- Affichage des albums --}}

                <div class="albums">
                    @if (count($albums)>0)
                        @for ($i = 0; $i < count($albums); $i++)
                            <div>
                                <div class="img_alb_welcome">
                                    @if(isset($photos[$i]))
                                        <img src="{{$photos[$i]->url}}" alt="{{$photos[$i]->titre}}">
                                    @else
                                        <img style="object-fit: contain" src="/images/vectors/empty.svg" alt="empty">
                                    @endif
                                </div>
                                <div class="desc_alb_welcome">
                                    <h3>{{$albums[$i]->titre}}</h3>
                                    @if (isset($albums[$i]->user->name))
                                        <h4>Créé par <i>{{$albums[$i]->user->name}}</i>, le <i>{{date('j F Y', strtotime($albums[$i]->creation))}}</i></h4>
                                    @else
                                        <h4>Créé le <i>{{date('j F Y', strtotime($albums[$i]->creation))}}</i></h4>
                                    @endif
                                    <div class="buttons">
                                        <a href="{{route("albumShow", $albums[$i]->id)}}" class="button visit"><span>Parcourir l'album</span></a>
                                        {{-- Si l'on est connecté : bouton de suppression de l'album --}}
                                        @if (isset(Auth::user()->id) && Auth::user()->id == $albums[$i]->user_id)
                                            <form action="{{route("albumDestroy", $albums[$i]->id)}}" method="post">
                                                @csrf
                                                @method("delete")
                                                <a href="#" onclick="document.getElementById('alb_delete_welcome{{$albums[$i]->id}}').click()" class="button delete"><span><i class='bx bxs-trash' ></i>Supprimer l'album</span></a>
                                                <input type="submit" value="Supprimer l'album" id="alb_delete_welcome{{$albums[$i]->id}}" class="alb_delete_welcome">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endfor 
                    @else
                    {{-- Si il n'y a aucun album ou la recherche est nulle' --}}
                        <div class="empty-zone">
                            @if (request()->input("search"))
                                <p class="empty">Aucun album correspondant à la recherche</p>
                                <img class="empty" src="/images/vectors/empty.svg" alt="empty">
                            @else
                                <p class="empty">Oups, il semblerait qu'aucun album n'ait était créé. Sois le premier à en créer un !</p>
                                <img class="empty" src="/images/vectors/empty.svg" alt="empty">
                            @endif
                        </div>
                    @endif

                {{-- Si l'on est connecté : Bouton de création d'album --}}

                    @auth
                        <div>
                            <div class="img_alb_welcome">
                                <img style="object-fit: contain" src="/images/vectors/create.svg" alt="empty">
                            </div>
                            <div class="desc_alb_welcome">
                                <h3>Crée ton album</h3>
                                <div>
                                    <a href="{{route("albumCreate")}}" class="button visit"><span>Créer</span></a>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection