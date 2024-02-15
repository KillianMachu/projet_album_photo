@extends('app')

@section('content')
    <div id="home_video">
        <video autoplay muted loop id="background_video">
            <source src="/videos/background first page.mp4" type="video/mp4">
        </video>
        <div>
            <h1>Nature en Pixels</h1>
            <h2>Partagez la Beauté de la Terre à travers Vos Yeux</h2>
            <h3>Explorez des albums photo inspirants, capturant la diversité étonnante de notre planète. De la douce brise dans les prairies aux sommets enneigés des montagnes, chaque image raconte une histoire personnelle.</h3>
            <a href="#home_content">Découvrir</a>
        </div>
    </div>
    <div id="home_content">
        <div class="discover">
            <div class="container">
                <h2>Découvre les albums !</h2>
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
                                    <div>
                                        <a href="{{route("albumShow", $albums[$i]->id)}}" class="button visit"><span>Parcourir l'album</span></a>
                                    </div>
                                </div>
                            </div>
                        @endfor 
                    @else
                        <p class="empty">Oups, il semblerait qu'aucun album n'ait était créé. Soit le premier à en créer un !</p>
                        <img class="empty" src="/images/vectors/empty.svg" alt="empty">
                    @endif
                </div>
                <div><a href="{{route("albumIndex")}}"><span>Voir tous les albums</span></a></div>
            </div>
        </div>
        <div class="create">
            <div class="container">
                <h2>Crée ton propre album !</h2>
                <div>
                    <div class="create_content">
                        <h3>Votre Vision, Votre Histoire, Votre Album</h3>
                        <h4>Capturez les moments spéciaux avec la nature et construisez votre album photo personnel. Exprimez votre passion pour la nature à travers des images qui racontent votre histoire unique. Rejoignez notre communauté et découvrez la richesse visuelle de la nature.</h4>
                        <a href="{{route("albumCreate")}}"><span>Créer mon album</span></a>
                    </div>
                    <div class="create_img">
                        <img src="/images/albumCreate.jpg" alt="albumCreate">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
