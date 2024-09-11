<template>
  
  <div>
    <div class="row justify-content-center">
      <div class="col-md-12 position-relative image-container pb-5">
          <img src="@/assets/images/banner.png" class="img-fluid" alt="">
          <div class="centered-button">
            <a class="btn mt-5" style="background-color:#fff; color:#888888; border: 1px solid #d3d3d3; border-radius: 20px; font-size: 14px;  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);" href="/sobre">
                <span class="me-2">Leia Mais</span>
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
      </div>
    </div>
    <!--Notícias-->
    <div class="col-md-12 bg-light">
        <div class="row justify-content-center">
            <div class="col-md-8 align-items-center">
                <div class="p-4 row">
                    <div class="col-10">
                        <p class="h2 titles"><strong>Notícias</strong></p>
                        <p class="d-flex justify-content-start">
                            Confira o que foi notícia no Blog Ágora, aqui você encontra um conteúdo variado que buscou divulgar ciência e promover saúde junto à sociedade, contribuir para a formação de pesquisadores, trabalhadores e gestores da saúde, e consolidar o Sistema Único Saúde, de forma transparente e em diálogo com os diversos públicos.
                        </p>
                    </div>
                    
                    <div class="col-12 col-md-2 mt-3 mt-md-0">
                        <a class="btn btn-success buttons" href="/noticias">
                            <span class="me-2">Leia Mais</span>
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 d-flex flex-wrap justify-content-between align-items-center">
                <div class="p-4 col-12 col-md-4">
                    <img src="@/assets/images/cx01-396x275.png" class="img-fluid rounded" alt="">

                    <div class="py-3">
                        <img src="@/assets/images/cxfeira-300x300.png" alt="" class="img-size rounded-circle">

                        <span class="news-legend-name px-1">
                            <small>Feira de Soluções</small>
                        </span>
                        
                        <i class="fa fa-circle p-1" style="font-size: 4px; color: #444;"></i>   

                        <span class="news-legend-date"><small>18 Jan 2022</small></span>
                    </div>

                    <small>
                    <p class="fw-bolder lh-sm">Da ideia ao produto, Feira fomenta soluções em saúde digital</p>
                    </small>
                </div>
                <div class="p-4 col-12 col-md-4">
                    <img src="@/assets/images/cx02-396x275.png" class="img-fluid rounded" alt="">

                    <div class="py-3">
                        <img src="@/assets/images/cxfeira-300x300.png" alt="" class="img-size rounded-circle">

                        <span class="news-legend-name px-1">
                            <small>Feira de Soluções</small>
                        </span>
                        
                        <i class="fa fa-circle p-1" style="font-size: 4px; color: #444;"></i>   

                        <span class="news-legend-date"><small>18 Jan 2022</small></span>
                    </div>

                    <small>
                    <p class="fw-bolder lh-sm">Vigilância popular atuando de forma estruturada com o SUS</p>
                    </small>
                </div>
                <div class="p-4 col-12 col-md-4">
                    <img src="@/assets/images/cx03-396x275.png" class="img-fluid rounded" alt="">

                    <div class="py-3">
                        <img src="@/assets/images/cxfeira-300x300.png" alt="" class="img-size rounded-circle">

                        <span class="news-legend-name px-1">
                            <small>Feira de Soluções</small>
                        </span>
                        
                        <i class="fa fa-circle p-1" style="font-size: 4px; color: #444;"></i>   

                        <span class="news-legend-date"><small>18 Jan 2022</small></span>
                    </div>

                    <small>
                    <p class="fw-bolder lh-sm">A inteligência artificial e seus dilemas</p>
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!--Redes-->
    <div class="row justify-content-center pb-5">
        <div class="col-md-12 background-container">
            <div class="row w-100">
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <img src="@/assets/images/cxredes.png" class="foreground-image img-fluid" width="400" height="400" alt="">
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

    <!--Eventos-->
    <div class="eventos-background">
        <div class="row justify-content-center">
            <div class="col-md-8 align-items-center">
                <div class="p-4 text-center">
                    <p class="h2 titles"><strong>Eventos</strong></p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-md-12 d-flex flex-column justify-content-center">
                    <div class="p-4">
                        <div class="card h-100 pb-4 news-card shadow border-0">
                            <div class="d-flex h-100">
                                <img src="@/assets/images/cxplanejamento-urbano.jpeg" class="img-fluid me-3 h-100 news-img align-self-center" alt="">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title">
                                        <a href="https://agora.fiocruz.br/blog/event/planejamento-urbano-e-seguranca-hidrica/"
                                            target="_blank" rel="noopener noreferrer">
                                            <p class="responsive-title">
                                                <strong>
                                                    Planejamento Urbano e Segurança Hídrica
                                                </strong>
                                                <span style="float: right; color: #414B5A;"><i class="fas fa-bookmark"></i></span>  
                                            </p>
                                                                
                                        </a>
                                    </h5>
                                
                                    <div class="card-info-area">
                                        <div class="card-info">
                                            <span class="badge text-bg-success">PALESTRA</span>
                                            <small>11/02/2020</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="card h-100 news-card shadow border-0">
                            <div class="d-flex h-100">
                                <img src="@/assets/images/cxlogos.jpg" class="img-fluid me-3 h-100 news-img align-self-center" alt="">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title">
                                        <a href="https://agora.fiocruz.br/blog/event/3o-ciclo-de-debates-manaus/"
                                            target="_blank" rel="noopener noreferrer">
                                            <p class="responsive-title">
                                                <strong>
                                                    3º Ciclo de Debates – Manaus
                                                </strong>
                                                <span style="float: right; color: #414B5A;"><i class="fas fa-bookmark"></i></span> 
                                            </p>
                                            
                                        </a>
                                    </h5>
                                    <div>
                                        <p class="card-text d-none d-md-block" style="font-size: 12px; line-height: 1.42857143;">
                                            A Vice-Presidência de Ambiente, Atenção e Promoção da Saúde convida para o 3° Ciclo de Debates em Saúde, Ambiente e Sustentabilidade. Alinhado com a missão institucional e dialogando com as teses aprovadas no VIII Congresso Interno da FIOCRUZ, a VPAAPS dá continuidade ao Ciclo de Debates de Saúde, Ambiente e Sustentabilidade com o objetivo...
                                        </p>
                                    </div>

                                    <div class="card-info-area">
                                        <div class="card-info">
                                            <span class="badge text-bg-success">ENCONTRO</span>
                                            <small>02/09/2019</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="card h-100 news-card shadow border-0">
                            <div class="d-flex h-100">
                                <img src="@/assets/images/cxexperiencias-ciencia.jpg" class="img-fluid me-3 h-100 news-img align-self-center" alt="">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title">
                                        <a href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                                            target="_blank" rel="noopener noreferrer">
                                            <p class="responsive-title">
                                                <strong>
                                                    Experiências de Ciência Cidadã para Biodiversidade e Saúde
                                                </strong>
                                                <span style="float: right; color: #414B5A;"><i class="fas fa-bookmark"></i></span> 
                                            </p>
                                        </a>
                                    </h5>
                                    
                                    <div>
                                        <p class="card-text d-none d-md-block" style="font-size: 12px; line-height: 1.42857143;">
                                            Descrição O seminário visa abordar oportunidades e desafios em projetos de ciência cidadã. Serão apresentados exemplos práticos de projetos que tenham relação com esta temática. O enfoque será dado tanto em projetos voltados para vigilância em saúde quanto à conservação da biodiversidade, e ainda em resultados de pesquisas com dados advindos desta prática. Para se...
                                        </p>
                                    </div>

                                    <div class="card-info-area">
                                        <div class="card-info d-flex flex-column flex-md-row">
                                            <span class="badge text-bg-success">SEMINÁRIO</span>
                                            <small>30/11/2018</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <a class="btn btn-success buttons" href="/evento">
                            <span class="me-2">Mais eventos</span>
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
  </div>
  </template>
  
  <style scoped>
  .item {
    margin-top: 2rem;
    display: flex;
    position: relative;
  }
  
  .details {
    flex: 1;
    margin-left: 1rem;
  }

  .titles {
    color: #3F7E44;
    text-transform: uppercase;
  }

  .buttons {
    border-radius: 64px !important; 
  }

  .text{
    color: #666666;
    font-weight: 400;
  }

  .news-card {
    width: 100% !important;
    max-height: 250px !important;
  }

  .news-img{
    margin: 0 auto; 
    width: 30%; 
    height: auto;
  }

  .img-size{
    width: 25px;
    height: 25px;
  }
  
  .news-legend-name {
    color: #3F7E44;
    font-weight: lighter;
  }

  .news-legend-date{
    color: #404040;
    font-weight: lighter;
  }

  .eventos-background {
    background: url('@/assets/images/fundo-eventos.png') repeat-x top center;
    background-repeat: repeat-y; 
    position: relative;
    width: 100%;
    background-size: 100%; 
    
}

/* .events-title{
    color: #222222; 
    text-decoration: none; 
    font-size: 19px; 
    line-height: 1.4; 
    font-weight: 700;
} */

  i {
    display: flex;
    place-items: center;
    place-content: center;
    width: 32px;
    height: 32px;
    color: var(--color-text);
  }
  
  h3 {
    font-size: 1.2rem;
    font-weight: 500;
    margin-bottom: 0.4rem;
    color: var(--color-heading);
  }
  
  @media (min-width: 1024px) {
    .item {
      margin-top: 0;
      padding: 0.4rem 0 1rem calc(var(--section-gap) / 2);
    }
  
    i {
      top: calc(50% - 25px);
      left: -26px;
      position: absolute;
      border: 1px solid var(--color-border);
      background: var(--color-background);
      border-radius: 8px;
      width: 50px;
      height: 50px;
    }
  
    .item:before {
      content: ' ';
      border-left: 1px solid var(--color-border);
      position: absolute;
      left: 0;
      bottom: calc(50% + 25px);
      height: calc(50% - 25px);
    }
  
    .item:after {
      content: ' ';
      border-left: 1px solid var(--color-border);
      position: absolute;
      left: 0;
      top: calc(50% + 25px);
      height: calc(50% - 25px);
    }
  
    .item:first-of-type:before {
      display: none;
    }
  
    .item:last-of-type:after {
      display: none;
    }
  }

  @media (max-width: 768px) {
    .responsive-title {
            font-size: 14px;
            line-height: 1.2;
        }
    }

</style>
  
<script>
export default {
  name: 'Main',
};
</script>