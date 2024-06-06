@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<div>

    <div class="row justify-content-center">
        <div class="col-md-12 position-relative image-container pb-5">
            <img src="http://localhost:8000/images/banner.jpg" class="img-fluid" alt="">
            <div class="centered-button">
                <!-- <div class="position-absolute top-50 start-50 translate-middle-y"> -->
                <a class="btn" style="background-color:#fff; color:#888888; border-radius: 20px; font-size: 14px;" href="#">
                    Leia Mais <strong>></strong>
                </a>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-between align-items-center">
            <div class="p-4 text-end">
                <p class="h3" style="color: #34AB44;"><strong>SAÚDE</strong></p>
                <p style="color: #333; line-height: 1.42857143; font-size: 14px;">A Ágora fomenta a inteligência cooperativa na saúde, por meio da conexão entre Saúde, Ciência, Tecnologia e Sociedade.</p>
            </div>
            <div class="p-4">
                <img src="http://localhost:8000/images/banner2.jpg" class="img-fluid" alt="">
            </div>
            <div class="p-4">
                <p class="h3" style="color: #34AB44;"><strong>C&T</strong></p>
                <p style="color: #333; line-height: 1.42857143; font-size: 14px;">Nossa metodologia objetiva fornecer ferramentas e métodos para estimular as Redes de Inteligência Cooperativa, potencializando ações e debates.</p>
            </div>
        </div>
        <div class="col-md-10">
            <div class="text-center ">
                <a class="btn" style="background-color:#789bbc; color:#ffffff; border-radius: 20px;" href="#">
                    Leia Mais <strong>></strong>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <img src="http://localhost:8000/images/banner3.jpg" alt="">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 align-items-center">
            <div class="p-4 text-center">
                <p class="h2" style="color: #34AB44;"><strong>Notícias</strong></p>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-between align-items-center">
            <div class="p-4">
                <img src="http://localhost:8000/images/cx01-350x350.jpg" class="img-fluid" alt="">
            </div>
            <div class="p-4">
                <img src="http://localhost:8000/images/cx02-350x350.jpg" class="img-fluid" alt="">
            </div>
            <div class="p-4">
                <img src="http://localhost:8000/images/cx03-350x350.jpg" class="img-fluid" alt="">
            </div>
        </div>
        <div class="col-md-8 pb-5">
            <div class="text-center">
                <a class="btn" style="border-color: #34AB44; border-radius: 20px; color: #34AB44;" href="#">
                    Mais postagens <strong>+</strong>
                </a>
            </div>
        </div>
    </div>
    <div class="row pb-5">
        <img src="http://localhost:8000/images/banner04.png" alt="">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 d-flex justify-content-between align-items-start">
            <div class="p-4 text-center">
                <div class="pb-4"><img src="http://localhost:8000/images/cxredes.png" width="150" height="150" alt=""></div>
                <div>
                    <p class="h5" style="color: #34AB44;"><strong>APLICATIVOS</strong></p>
                    <p style="color: #888888;">Catálogo de aplicativos para melhoria do teletrabalho e conexões entre
                        as pessoas e a sociedade.</p>
                </div>
            </div>
            <div class="p-4 text-center">
                <div class="pb-4"><img src="http://localhost:8000/images/cxfeira-300x300.png" width="150" height="150" alt=""></div>
                <div>
                    <p class="h5" style="color: #34AB44;"><strong>FEIRA DE SOLUÇÕES</strong></p>
                    <p style="color: #888888; line-height: 1.42857143; font-size: 14px;">As Feiras de Soluções para a Saúde possuem um
                        formato inovador de apresentar soluções industriais,
                        sociais e de serviços para a saúde.</p>
                </div>
            </div>
            <div class="p-4 text-center">
                <div class="pb-4"><img src="http://localhost:8000/images/cxnoticias-300x300.png" width="150" height="150" alt=""></div>
                <div>
                    <p class="h5" style="color: #34AB44;"><strong>NOTÍCIAS</strong></p>
                    <p style="color: #888888; line-height: 1.42857143; font-size: 14px;">No Blog Ágora você encontra notícias, textos autorais, entrevistas, artigos,
                        tutoriais e links sobre saúde, ciência, tecnologia e a Agenda 2030.</p>
                </div>
            </div>
            <div class="p-4 text-center">
                <div class="pb-4"><img src="http://localhost:8000/images/cxeventos-300x300.png" width="150" height="150" alt=""></div>
                <div>
                    <p class="h5" style="color: #34AB44;"><strong>EVENTOS</strong></p>
                    <p style="color: #888888; line-height: 1.42857143; font-size: 14px;">Eventos são importantes para fomentar o debate e as trocas de experiência.
                        Fique por dentro da agenda de eventos da saúde.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pb-5">
        <div class="col-md-8 background-container">
            <div class="row w-100">
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <img src="http://localhost:8000/images/cxredes.png" class="foreground-image" width="400" height="400" alt="">
                </div>
                <div class="col-md-4 d-flex flex-column justify-content-center">
                    <div class="py-4 pr-4 text-start">
                        <p class="h2" style="color: #789bbc;">REDES</p>
                        <p style="line-height: 1.42857143; font-size: 14px;">As Redes da Ágora apoiam o trabalho cooperativo.
                            Elas permitem criar um ambiente de comunicação único e facilitar a tomada de decisões.</p>
                        <p><strong>Destaques</strong></p>
                        <ul style="color: #48773e; line-height: 1.42857143; font-size: 14px;">
                            <li>Planejamento Integrado Fiocruz</li>
                            <li>Saúde, Ambiente e Sustentabilidade – SAS</li>
                            <li>Estrutural Saudável e Sustentável</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pb-5" style="background-color: #fcb900;">
        <div class="col-md-8 align-items-center">
            <div class="p-4 text-center">
                <p class="h2" style="color: #9b51e0;">EVENTOS</p>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pb-5" style="background-color: #fcb900;">
        <div class="col-md-8 pb-5">
            <div class="text-center">
                <a class="btn" style="border-color: #34AB44; border-radius: 20px; color: #34AB44;" href="#">
                    TODOS
                </a>
                <a class="btn" style="border-color: #fff; border-radius: 20px; color: #34AB44; background-color: #34AB44;" href="#">
                    <span class="text-white">2030 AGENDA</span>
                </a>
                <a class="btn" style="border-color: #fff; border-radius: 20px; color: #34AB44; background-color: #34AB44;" href="#">
                    <span class="text-white">ENCONTRO</span>

                </a>
                <a class="btn" style="border-color: #fff; border-radius: 20px; color: #34AB44; background-color: #34AB44;" href="#">
                    <span class="text-white">FEIRA</span>

                </a>
                <a class="btn" style="border-color: #fff; border-radius: 20px; color: #34AB44; background-color: #34AB44;" href="#">
                    <span class="text-white">OFICINA</span>

                </a>
                <a class="btn" style="border-color: #fff; border-radius: 20px; color: #34AB44; background-color: #34AB44;" href="#">
                    <span class="text-white">MAIS</span>

                </a>
            </div>
        </div>
        <div class="col-md-8 d-flex justify-content-between align-items-center">
            <div class="p-2">
                <img src="http://localhost:8000/images/cxplanejamento-urbano.jpeg" width="320" height="184" alt="">
            </div>
            <div class="p-2">
                <img src="http://localhost:8000/images/cxplanejamento-urbano.jpeg" width="320" height="184" alt="">
            </div>
            <div class="p-2">
                <img src="http://localhost:8000/images/cxplanejamento-urbano.jpeg" width="320" height="184" alt="">
            </div>
        </div>
    </div>

</div>
@endsection
