@extends('app')

@section('content')

<div class="container tagShow">
    <h2 class="titre">{{$tag->nom}}</h2>
    <div class="photos">
        @foreach($tag->photos as $p)
        <div>
            <div class="img_photo">
                <img src="{{$p->url}}" alt="{{$p->titre}}" >
            </div>
            <div class="desc_photo">
                <h3>Sur l'album : {{$p->album->titre}}</h3>
                <div class="buttons">
                    <a href="{{route('albumShow', $p->album->id)}}" class="button visit"><span>Parcourir l'album</span></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <a href="{{url()->previous()}}" class="return"><i class='bx bxs-chevron-left' ></i><span>Retour</span></a>
</div>

@endsection