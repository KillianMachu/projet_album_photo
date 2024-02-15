<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/svg+xml" href="{{asset('images/vectors/NP.svg')}}" />
    <title>Album Photo</title>
</head>
<body>
    
    <header>
        <nav class="navigation container">
            <div class="left">
                <div>
                    <a href="{{route("albumIndex")}}" class="{{ Route::currentRouteName() === "albumIndex" ? 'active-page' : '' }}">Albums</a>
                    <a href="{{route("tagIndex")}}" class="{{ Route::currentRouteName() === "tagIndex" ? 'active-page' : '' }}">Tags</a>
                    @auth
                        <a href="{{route("albumCreate")}}" class="{{ Route::currentRouteName() === "albumCreate" ? 'active-page' : '' }}">Créer un album</a>
                    @endauth
                </div>
            </div>
            <a href="{{route("home")}}" class="home">NaPicture</a>
            <div class="right">
                @auth
                    <a href="{{route("logout")}}"
                    onclick="document.getElementById('logout').submit(); return false;" class="log"><i class='bx bx-log-out' ></i>Se déconnecter</a>
                    <form id="logout" action="{{route("logout")}}" method="post">
                        @csrf
                    </form>
                @else
                    <a href="{{route("login")}}" class="log"><i class='bx bxs-lock-alt'></i>Connexion</a>
                @endauth
            </div>
        </nav>
    </header>
    <main>
        @if (session('info_crea'))
            <div class="alert alert-success alert-crea" id="info">
                <div>
                    <h4>{{session('info_crea')}}</h4>
                    <i class='bx bx-x' id='close_info'></i>
                </div>
            </div>
        @endif
    
        @if (session('info_del'))
            <div class="alert alert-success alert-del" id="info">
                <div>
                    <h4>{{session('info_del')}}</h4>
                    <i class='bx bx-x' id='close_info'></i>
                </div>
            </div>
        @endif
    @yield('content')
    </main>
    <footer>
        <div class="container">
            <div class="left">
                <a href="{{route("home")}}" class="home title_part_footer">NaPicture</a>
                <h4>16 Rue de l'Université</h4>
                <h4>62307 Lens</h4>
            </div>
            <div class="right">
                <div>
                    <h4>Menu</h4>
                    <a href="{{route("albumIndex")}}">Albums</a>
                    <a href="{{route("tagIndex")}}">Tags</a>
                    @auth
                        <a href="{{route("albumCreate")}}">Créer un album</a>
                    @endauth
                </div>
                <div>
                    <h4>Me suivre</h4>
                    <div>
                        <p>Killian Machu</p>
                        <div>
                            <a href="https://www.linkedin.com/in/killian-machu/" target="_blank"><i class='bx bxl-linkedin-square'></i></a>
                            <a href="https://github.com/KillianMachu" target="_blank"><i class='bx bxl-github'></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>ⓒ2023, Killian Machu. Tous droits réservés</p>
    </footer>
</body>
</html>
