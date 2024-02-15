@extends('app')

@section('content')

<div class="container albumCreate">
    <h2>Créer un nouvel album</h2>
    <form action="{{route('albumStore')}}" method="post" id="add" enctype="multipart/form-data">
        @csrf
        <div class="create-container">
            <div class="input-fields">
                <input type="text" name="titre" id="titre" placeholder="Titre de votre album" required>
            </div>
            <button id="add-photo">Ajouter une photo</button>
            @include("partials.errors")
            <input type="submit" value="Suivant">
        </div>
    </form>
</div>

@endsection