@extends('layouts.app')

@section('title', 'Destaque')

@section('content')
<div class="row">

    <div class="col-md-12">
        <div class="position-relative image-container pb-5">
            <img src="http://localhost:8000/images/breadcrumbs-bg.jpg" class="img-fluid" alt="">
        </div>
    </div>

    <div class="col-md-8 d-flex justify-content-center align-items-center">
        <div class="p-4">

            <img src="http://localhost:8000/images/nt-ideia-produto.jpg" class="rounded mx-auto d-block" alt="">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="https://agora.fiocruz.br/blog/event/planejamento-urbano-e-seguranca-hidrica/"
                        target="_blank" rel="noopener noreferrer"
                        style="color: #222222;
                            text-decoration: none;
                            font-size: 19px;
                            line-height: 1.4;
                            font-weight: 700;">
                    </a>
                </h5>
                <p class="card-text" style="font-size: 14px; line-height: 1.42857143;">
                    O anúncio dos 15 projetos ganhadores do Prêmio Transformação Digital na Saúde 2023 e das 10 equipes
                    classificadas para a próxima etapa da Hackatona SUS Digital marcou o encerramento da 6ª Feira de
                    Soluções para a Saúde, realizada pela primeira vez em Brasília (DF), de 27 a 29 de novembro,
                    no Millennium Convention Center. O...
                </p>
                <div>
                    <i class="fas fa-calendar-alt pb-3" style="color: #48773E;"></i><small> 30/11/2018</small>
                    <small><i class="fas fa-comment" style="color: #48773E;"></i></i> 0 Comentário</small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
