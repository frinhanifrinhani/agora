<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .navbar .container .navbar-collapse {
            padding: 0.6rem 0 0 2rem !important;
        }

        .navbar .container a:hover {
            color: #4C9F47;
        }

        .navbar-nav .nav-link.active,
        .navbar-nav .show>.nav-link {
            color:  #4C9F47;
        }

        body {
            font-family: 'Montserrat', sans-serif;
        }

        .background-container {
            position: relative;
            background-image: url('http://localhost:8000/images/background-home-1.jpg');
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 600px;
            display: flex;
            align-items: center;
        }

        .foreground-image {
            max-width: 100%;
            height: auto;
        }

        .image-container {
            position: relative;
        }

        .centered-button {
            position: absolute;
            top: 65%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <div>
        <nav class="navbar navbar-expand bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="http://localhost:8000/images/logo_AgoraFiocruz.png" alt="Bootstrap" width="275" height="46">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">EFA 2030</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Soluções para Saúde</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Notícias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Redes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ifuturo</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Aplicativos Ágora
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Ágora Meeting</a></li>
                                <li><a class="dropdown-item" href="#">Ágora Class</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sobre</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

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
        <div class="row justify-content-center py-5" style="background-image: linear-gradient(360deg, #575860 0%, #3a3a3a 100%);">
            <div class="col-md-10 d-flex justify-content-between align-items-start pb-5">
                <div class="col-3 py-4 px-2 align-items-start">
                    <div>
                        <p class="h5" style="color: #FFFFFF; font-size: 15px; font-weight: 600;">
                            <strong>SOBRE O ÁGORA</strong>
                        </p>
                        <p style="color: #FFFFFF; line-height: 1.42857143; font-size: 14px; font-weight: 400;">
                            Ciência, Tecnologia e Educação Abertas para a Saúde.
                        </p>
                        <p style="color: #FFFFFF; line-height: 1.42857143; font-size: 14px; font-weight: 400;">
                            contato.agora@fiocruz.br
                        </p>
                    </div>
                </div>
                <div class="col-2 py-4 px-2 align-items-start">
                    <div>
                        <p class="h5" style="color: #FFFFFF; font-size: 15px; font-weight: 600;"><strong>MAPA DO SITE</strong></p>
                        <p>
                        <ul style="color: #FFFFFF; line-height: 1.42857143; font-size: 14px; font-weight: 400;">
                            <li>Início</li>
                            <li>Redes</li>
                            <li>Ágora 2030</li>
                            <li>Eventos</li>
                            <li>Sobre</li>
                            <li>Ajuda</li>
                        </ul>
                        </p>
                    </div>
                </div>
                <div class="col-7 py-4 px-2 align-items-start">
                    <div>
                        <p class="h5" style="color: #FFFFFF; font-size: 15px; font-weight: 600;">
                            <strong>REALIZAÇÃO</strong>
                        </p>
                        <div class="d-flex align-items-center">
                            <img src="http://localhost:8000/images/footer-estrategia2030.png" width="133" height="48" alt="" style="padding-right: 16px !important;">
                            <img src="http://localhost:8000/images/footer-ms-fiocruz.png" alt="">
                            <img src="http://localhost:8000/images/footer-ms.png" alt="">
                            <img src="http://localhost:8000/images/footer-govbr.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </div>
</body>

</html>
