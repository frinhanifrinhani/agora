<template>
    <div> 
        <div v-if="loading" class="d-flex justify-content-center align-items-center vh-100">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>
        
        <div v-if="event">
            <!--Seção breadcrumbs-->
            <div class="breadcrumbs-background">
                <div class="row justify-content-center m-2 p-2">
                    <section>
                        <h1>
                            {{ event.title }}
                        </h1>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Ágora Fiocruz</a></li>
                                <li class="breadcrumb-item"><a href="#">2030 Agenda</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ event.title }}</li>
                            </ol>
                        </nav>
                    </section>
                </div>
            </div>
            <!--Seção notícia-->
            <div class="container justify-content-center">
                <div class="row no-gutters mt-5">
                    <div class="col-9">
                        <p class="card-text" v-html="event.body"></p>

                        <!-- <img src="@/assets/images/estrategia-fiocruz-para-a-agenda-2030.png" class="w-75" alt="Imagem com o texto soluções estratégicas para a agenda 2030" >

                        <h3 class="mt-5 color-green">Agência Fiocruz de Notícias</h3>

                        <p>
                            A Fiocruz co-organizou e participou, nesta terça-feira (18/7), de dois eventos paralelos sobre implementação da Agenda 2030 no Fórum Político de Alto Nível da ONU sobre Desenvolvimento Sustentável, em Nova York. Segundo os painelistas da mesa da manhã, um dos trunfos dos eventos foi a união, no debate, da sociedade civil e do governo, um símbolo de como o tema da Agenda 2030 deve ser tratado. Além de destacarem a necessidade de fortalecer a implementação dos Objetivos de Desenvolvimento Sustentável (ODS), as falas trataram de como o Brasil está se reestruturando para retomar essa Agenda e as medidas para acelerar e atingir as metas de desenvolvimento.
                        </p>

                        <figure  class="figure">
                            <img src="@/assets/images/onudentro.jpg" alt="imagem ">
                            <figcaption class="figure-caption">
                                Segundo o representante permanente do Brasil na ONU, Sergio França Danese, apenas 20% dos objetivos estão no ‘caminho certo’. Ele destacou que ‘as lacunas de implementação são imensas, além de o mundo ter retrocedido em diversos objetivos, com crescimento da pobreza’ (Foto: reprodução da internet)
                            </figcaption>
                        </figure>
                                        
                        <p v-html="event"></p>

                        <figure class="figure">
                            <img src="@/assets/images/onugadelha.jpg" alt="segunda imagem">
                            <figcaption class="figure-caption">
                                O coordenador da Estratégia Fiocruz para a Agenda 2030 (EFA 2030), Paulo Gadelha, participou do evento e apresentou as ações da Fundação (Foto: reprodução da internet) 
                            </figcaption>
                        </figure>

                        <p>
                            Gadelha afirmou ser fundamental disseminar o conhecimento e internalizar os valores, objetivos e instrumentos de implementação da Agenda 2030. Além disso, ele destacou que se deve priorizar o enfrentamento das desigualdades sociais e o apoio a programas de recuperação econômica e proteção social, além de garantir políticas e financiamento para os ODS. 
                        </p>

                        <p>
                            “O Brasil, sob a liderança do presidente Lula, demonstra um compromisso renovado com a Agenda 2030, enfatizando a equidade e a solidariedade para os mais vulneráveis, com o objetivo de ‘não deixar ninguém para trás’. Na Paris Summit for Global Finance, ele disse, em alto e bom som: ‘(…) Já temos uma bússola acordada multilateralmente: a Agenda 2030’”, concluiu Gadelha.
                        </p>
                        <h4 class="mt-4 color-green">Reconstrução</h4>

                        <p>
                            Representando o Secretária-Geral da Presidência da República, o assessor especial Flávio Schuch ressaltou que a pasta retoma um papel que era seu no passado, o de permitir e garantir a participação da sociedade civil no governo e, por isso, está reconstruindo espaços. “Neste processo de reconstrução, queremos que o tecido social da participação política das organizações da sociedade civil sejam fortalecidos”, destacou.
                        </p>

                        <p>
                            Do Governo Federal participaram também a secretária de Povos e Comunidades Tradicionais e Desenvolvimento Rural Sustentável, Edel Moraes, que falou sobre o desenvolvimento sustentável nas cidades amazônicas; a subsecretária de Desenvolvimento Econômico Sustentável, Cristina Reis, que comentou sobre o Plano de Transformação Ecológica; e o embaixador Antonio da Costa e Silva, assessor especial do Ministério das Cidades. Entre os representantes da sociedade civil estavam o diretor-presidente do Instituto Cidades Sustentáveis, Jorge Abrahão, que apresentou um instrumento de monitoramento dos ODS nas cidades brasileiras, e a co-fundadora e coordenadora-geral da Gestos e co-facilitadora do GT Agenda 2030, Alessandra Nilo, que falou sobre como o Spotlight Report pode ser um  instrumento de monitoramento da Agenda 2030 pela sociedade civil. 
                        </p>
                        <h4 class="mt-4 color-green">Experiência da América Latina</h4>

                        <p>
                            Às 19h30, ocorreu o segundo evento paralelo organizado pelo governo e com co-realização da Fiocruz. No evento da noite, o foco se virou para a experiência da América Latina na implementação da Agenda 2030, reunindo representantes governamentais de países da região. O pesquisador da Fiocruz Romulo Paes de Souza representou o Brasil no debate.
                        </p> -->
                    </div>

                    <div class="col-3">
                        <nav class="navbar navbar-light bg-light">
                            <form class="form-search">
                                <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar">
                                <button class="btn btn-outline-success btn-sm custom-button-border" type="submit">BUSCAR</button>
                            </form>
                        </nav>

                        <div>
                            <h5 class="mt-5 color-green">POSTS RECENTES</h5>
                            <hr/>
                            <button type="button" class="custom-button-tags">
                                <small>Da ideia ao produto, Feira fomenta soluções em saúde digital</small>
                            </button>
                        </div>

                        <div>
                            <h5 class="mt-5 color-green">TAGS</h5>
                            <hr/>
                            <button type="button" class=" btn btn-outline-success custom-button-tags custom-button-border">
                                TAGS
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="container justify-content-center mb-5">
                <section class="col-md-10">
                    <div class="mb-3">
                        <i class="fa-solid fa-calendar-days color-green"></i>
                        <span class="ms-2 color-grey">
                            <FormattedDate :date="event.publication_date" />
                        </span>
                    </div>

                    <div>
                        <span class="color-grey">Compartilhar</span>
                        <i class="fa-brands fa-facebook icons-share color-green"></i>
                        <i class="fa-brands fa-instagram icons-share color-green"></i>
                        <i class="fa-solid fa-envelope icons-share color-green"></i>
                        <i class="fa-brands fa-linkedin icons-share color-green"></i>
                    </div>
                </section>
            </section>
        </div>        
    </div>
</template>

<script>
import EventService from '../../service/EventService';
import FormattedDate from '../FormattedDate.vue';

export default {
    name: "EventShow",
    components: {
        FormattedDate,
    },
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
    return {
        event: null,
        loading: false
    };
  },
  created() {
    this.EventService = new EventService();
    this.fetchEventDetails();
  },
  methods: {
    async fetchEventDetails() {

        this.loading = true;
        try {
            const response = await this.EventService.getShowEvent(this.id);

            if (response && response.data) {
                this.event = response.data;
            } else {
                console.error('Evento não encontrado.');
            }
            
        } catch (error) {
            console.error('Erro ao buscar o evento:', error);
        } finally {
            this.loading = false;
        }

        this.loading = false;
    }
  }
};
</script>
