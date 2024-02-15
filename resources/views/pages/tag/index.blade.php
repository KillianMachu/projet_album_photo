@extends('app')

@section('content')

<div class="container tagsIndex">
    <h1 class="titre">Certaines catégories de photos t'intéressent ?</h1>
    <h2>Naviguez à travers les tags pour découvrir votre coin de nature préféré</h2>
    <div class="tags">
        @foreach($tags as $t)
        <a href="{{route("tagShow",$t->id)}}">{{$t->nom}}<i class='bx bx-search' ></i></a>
        @endforeach
    </div>
</div>

@endsection