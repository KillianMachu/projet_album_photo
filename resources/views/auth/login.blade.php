@extends('app')

@section('content')

<div class="auth">
    <div>
        <img src="/images/login.jpg" alt="login">
    </div>
    <div>
        <div>
            <h3>Connectez-vous pour créer !</h3>
            <form action="{{route("login")}}" method="post">
                @csrf
                <input type="email" name="email" required placeholder="Email" value="{{old('email')}}" />
                <input type="password" name="password" required placeholder="Mot de passe" />
                <div class="remember">
                    <input type="checkbox" name="remember" id="case"/>
                    <p>Se souvenir de moi</p>
                </div>
                @include("partials.errors")
                <input type="submit" id="bouton" value="Connexion"/>
            </form>
            <p><span>OU</span></p>
            <h3>Inscrivez vous</h3>
            <a href="{{route("register")}}">S'inscrire</a>
        </div>
    </div>
</div>

@endsection
