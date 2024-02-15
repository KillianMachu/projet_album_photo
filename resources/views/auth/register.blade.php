@extends('app')

@section('content')

<div class="auth register">
    <div>
        <img src="/images/login.jpg" alt="login">
    </div>
    <div>
        <div>
            <h3>Inscris-toi pour commencer à partager</h3>
            <form action="{{route("register")}}" method="post">
                @csrf
                <input type="text" name="name" required placeholder="Nom" value="{{old('name')}}" />
                <input type="email" name="email" required placeholder="Email" />
                <input type="password" name="password" required placeholder="Mot de passe" />
                <input type="password" name="password_confirmation" required placeholder="Confirmation du mot de passe" />
                @include('partials.errors')
                <input type="submit" id="bouton"/>
            </form>
            <p><span>OU</span></p>
            <h3>Déjà un compte  ? Connecte-toi</h3>
            <a href="{{route("login")}}">Connectez vous !</a>
        </div>
    </div>
</div>
@endsection
