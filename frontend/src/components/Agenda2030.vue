<template>
<div>
    <div class="row justify-content-center">
        <section class="col-md-10">  
            <div class="container text-center">
                <h1 class="h1 green-title mt-5">Agenda 2030</h1>
            </div>

            <HorizontalLine icon="info" class="mb-4"/>
            
            <div class="row">
                <div class="col-md-8 text-responsive"> 
                    <p>
                        Em 1º de janeiro de 2016 foi lançada oficialmente a Agenda 2030 para o desenvolvimento sustentável e os seus 17 Objetivos de Desenvolvimento Sustentável (ODS) – adotada pelos líderes mundiais em Setembro de 2015 durante a cimeira do desenvolvimento sustentável realizada durante a Assembleia Geral da ONU. Nos próximos doze anos, os países irão mobilizar esforços para contribuir na implementação dessa Agenda que é uma aspiração de alcançar os cinco Ps do desenvolvimento sustentável: Parcerias para ter um Planeta sustentável, Próspero, em Paz, e justo com as Pessoas.
                    </p>
                    
                    <p>
                        <a href="https://brasil.un.org/pt-br" class="link-success link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">Clique aqui</a> e aprenda mais sobre a Agenda 2030 e os seus 17 objetivos que nos nortearão para transformar “o mundo naquele que queremos”.
                    </p>
                </div>
                <div class="col-md-4">
                    <img src="@/assets/images/desenvolvimento-sustentavel-agenda-2030.png" alt="" class="image-responsive">
                </div>
            </div>
        </section>

        <section class="col-md-10 mt-5">
            <div class="row">
                <div class="col-md-4">
                    <img src="@/assets/images/saude-bem-estar-agenda-2030.png" alt="" class="image-responsive">
                </div>
                <div class="col-md-8 text-responsive"> 
                    <h2 class="h2 green-title">Rede Agenda 2030</h2>
                    <p>
                        Rede destinada a promover conversas e decisões em torno da Agenda 2030 no Brasil, no contexto Estratégia Fiocruz para a Agenda 2030.
                    </p>
                    <p>
                        O trabalho enfoca o Objetivo de Desenvolvimento Sustentável 3: Saúde e Bem Estar, de forma articulada com os demais 16 ODSs.
                    </p>

                    <button class="btn btn-outline-success" href="#">
                        Participar
                    </button>
                </div>
            </div>
        </section>

        <section class="col-md-10 mt-5">
            <div class="container text-center">
                <h2 class="h2 ">O que é a Estratégia Fiocruz para a <span class="green-title">Agenda 2030?</span></h2>

                <HorizontalLine icon="info" class="mb-4"/>

                <img src="@/assets/images/estrategia-fiocruz-para-a-agenda-2030.png" alt="">
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <p>
                        Em 2017, a presidência da Fiocruz instituiu a “Estratégia Fiocruz para a Agenda 2030”, considerando a análise histórica, de conjuntura e prospecção de futuro da instituição. A estratégia incorpora o documento das Nações Unidas ao desenvolvimento estratégico e ao programa de trabalho da Fiocruz em médio e longo prazos, com um entendimento que parte da determinação social da saúde e de temas conexos, dos estudos sociais de ciências, da ecologia de saberes e da teoria crítica sobre inovação e de modelos de desenvolvimento.
                    </p>
                </div>

                <div class="col-md-6">
                    <p>
                        A matriz histórica da Fiocruz assenta-se em uma forte correlação entre saúde, desenvolvimento e sustentabilidade. Neste sentido, a Agenda das Nações Unidas e a da Fiocruz caminham juntas: em ambos os casos, o que se busca é a integração de direitos humanos, políticas sociais, sustentabilidade, inovação e desenvolvimento de modo que, como diz o lema do documento internacional, não seja Ninguém deixado para trás.
                    </p>
                </div>
            </div>

            <button class="btn btn-outline-success d-block mx-auto" > 
                <a href="https://portal.fiocruz.br/estrategia-fiocruz-para-agenda-2030" class="text-reset text-decoration-none">Saiba Mais<strong> > </strong>
                </a>
            </button>
        </section>
        
        <section class="col-md-10 mt-5">
            <div class="container text-center"> 
                <h2 class="h2">Notícas 
                    <span class="green-title">#Ágora2030</span>
                </h2>

                <HorizontalLine icon="wifi" class="mb-4"/>

                <p>
                    Notícias, textos autorais e tutoriais fresquinhos para apoiar a inteligência cooperativa
                </p>
            </div>

        </section>

        <!-- Seção Flip Card !-->
        <section class="col-md-10 mt-5 mb-5">
            <div class="content text-center">
                <h2 class="h2">Agenda 2030 <span class="green-title">na Fiocruz</span></h2>

                <HorizontalLine icon="info" class="mb-4"/>
            </div>
            <div class="row card-responsive flip-card-container">
                <div class="col-md-4">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img src="@/assets/images/solucoes-saude-flip-card.png" alt="">
                            </div>

                            <div class="flip-card-back">
                                <h3 class="h3">Feira de Soluções para a Saúde</h3>
                                <p>
                                    Estruturada em três grandes eixos: Soluções de serviços; Soluções sociais, e; Soluções industriais, as feiras pretendem reunir profissionais e gestores da saúde em prol do alcance das metas da Agenda 2030.
                                </p>
                                <button class="btn btn-outline-success d-block mx-auto">
                                    <a class="text-reset text-decoration-none" href="https://solucoes.agora.fiocruz.br/" target="blank">Acesse</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img src="@/assets/images/radar-ods-flip-card.png" alt="">
                            </div>
                            <div class="flip-card-back">
                                <h3 class="h3">Radar ODS</h3>
                                <p>
                                    O RADAR ODS é uma iniciativa que tem como função disseminar informações primárias e secundárias sobre os ODS e a Agenda 2030.
                                </p>
                                <button class="btn btn-outline-success d-block mx-auto">
                                    <a  class="text-reset text-decoration-none" href="https://cee.fiocruz.br/" target="blank">Acesse</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img src="@/assets/images/saude-amanha-flip-card.png" alt="" >
                            </div>

                            <div class="flip-card-back">
                                <h3 class="h3">Saúde Amanhã</h3>
                                <p>
                                    O projeto Brasil Saúde Amanhã é uma rede multidisciplinar de pesquisa que investiga e propõe caminhos para o país e o setor Saúde no horizonte dos próximos 20 anos.
                                </p>
                                <button class="btn btn-outline-success">
                                    <a  class="text-reset text-decoration-none" href="https://saudeamanha.fiocruz.br/" target="blank">Acesse</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</template>

<script>
import HorizontalLine from "../components/icons/HorizontalLine.vue"
export default {
    name: "Agenda2030",
    components: {
        HorizontalLine,
    },
};
</script>
