<template>
    <div>
      <div class="row justify-content-center">
        <div class="position-relative image-container">
          <div class="centered-title">
            <h1 style="color: #fff;
              border-color: #6dab3c;
              border-radius: 20px;
              line-height: 50px;
              font-weight: bolder;">
              SAÚDE & CTI PARA A AGENDA 2030
            </h1>
          </div>
          <div class="centered-button-emphasis">
            <a class="btn" style="color: #fff;
              border-color: #6dab3c;
              background-color: #6dab3c;
              border-radius: 20px;
              font-size: 14px;"
              href="/sobre">
              <i class="fa-solid fa-calendar-days"></i>
              <span class="ms-2"> 06 a 08 de novembro de 2017</span>
            </a>
          </div>
          <div class="centered-button">              
            <a class="btn" style="background-color:#fff; color:#888888; border-radius: 20px; font-size: 14px;" href="#">
              <span class="me-2">Detalhes</span>
              <i class="fa-solid fa-angle-right"></i>
            </a>              
          </div>
          <img src="@/assets/images/banner-obj-des-sustentavel.jpg" class="img-fluid" alt="">
          <div class="col-md-11 d-flex centered-form justify-content-center bg-white text-dark p-5">
            <div class="col-3 py-2 ms-5 ps-5 d-flex align-items-center justify-content-end">
              <i class="fa-solid fa-magnifying-glass-plus"></i>
              <h5 class="ms-2">Pesquisar Evento:</h5>
            </div>
            <div class="col-3 p-2">
              <input type="text" class="form-control" placeholder="Palavras-chave">
            </div>
            <div class="col-3 p-2">
              <select class="form-select" aria-label="Default select example">
                <option selected>Categoria</option>
                <option value="2030-agenda">2030 Agenda</option>
                <option value="curso">Curso</option>
                <option value="encontro">Encontro</option>
                <option value="feira">Feira</option>
                <option value="oficina">Oficina</option>
                <option value="palestra">Palestra</option>
                <option value="reuniao">Reunião</option>
                <option value="seminario">Seminário</option>
                <option value="workshop">Workshop</option>
              </select>
            </div>
            <div class="col-2 p-2">
              <select class="form-select" aria-label="Default select example">
                <option selected>Status</option>
                <option value="upcoming">Próximos</option>
                <option value="incoming">Em andamento</option>
                <option value="expired">Expirado</option>
              </select>
            </div>              
            <div class="col-3 p-2">
              <button type="submit" class="btn btn-success">Pesquisar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center pb-4">
        <div class="col-md-8 align-items-center">
          <div class="p-4 text-center">
            <p class="h2">Últimas Atualizações <span style="color: #48773E;"><strong>Eventos</strong></span></p>
            <hr class="text-muted">
            <small>Filtre os eventos por Tipo</small>
          </div>
        </div>
      </div>
      <div class="text-center pb-4">
        <a class="btn" style="background-color: #fff; border-color: #48773E; border-radius: 20px; color: #48773E;" href="#">
            TODOS
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">2030 AGENDA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
          <span class="text-white">CURSO</span>
      </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">ENCONTRO</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">FEIRA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">OFICINA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">PALESTRA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">REUNIÃO</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">MAIS</span>
        </a>
    </div>
      <div class="row justify-content-center">
        <div class="col-md-10 pb-5 d-flex  justify-content-center">          
          
          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <img
                src="@/assets/images/banner-obj-des-sustentavel.jpg"
                class="card-img-top"
                alt=""
              />
              <div class="card-body">
                <h5 class="card-title mb-0 pb-0">
                  <a
                    href="https://agora.fiocruz.br/blog/event/planejamento-urbano-e-seguranca-hidrica/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong>Health & STI for 2030 Agenda</strong>
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">2030 AGENDA</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 30/11/2018</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    BACKGROUND The holistic nature of 2030 Agenda and SDGs demands an
                    integrated and systematic approach while dealing with the specificities
                    of each of the 17 Sustainable Development Goals (SDGs). The relevance
                    of social and environmental determinants in health outcomes and the
                    strong role of the health sector in the productive and economic development,
                    make the...
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-comment"></i> Rio de Janeiro, Brasil </small>
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >IX Curso de Especialização em Direito Sanitário</strong
                    >
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    Capacitar o corpo discente com conhecimentos jurídico-político-sanitários
                    de forma a desenvolver expertise para compreensão e atuação nas questões
                    sanitárias contemporâneas.
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <img
                src="http://localhost:8000/images/nt-vigilancia.jpg"
                class="card-img-top"
                alt=""
              />
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >Curso de Especialização em Saúde Coletiva</strong
                    >
                  </a>
                </h5><div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                  O Programa de Especialização em Saúde Coletiva proposto pela Escola de Governo em
                  Saúde tem como objetivo proporcionar uma formação reflexiva e crítica sobre o
                  campo da Saúde Coletiva e o aprofundamento de estudos em uma das seguintes
                  áreas temáticas da Política de Saúde
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-10 pb-5 d-flex  justify-content-center">          
          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <div class="card-body">
                <h5 class="card-title mb-0 pb-0">
                  <a
                    href="https://agora.fiocruz.br/blog/event/planejamento-urbano-e-seguranca-hidrica/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong>Health & STI for 2030 Agenda</strong>
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">2030 AGENDA</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 30/11/2018</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    BACKGROUND The holistic nature of 2030 Agenda and SDGs demands an
                    integrated and systematic approach while dealing with the specificities
                    of each of the 17 Sustainable Development Goals (SDGs). The relevance
                    of social and environmental determinants in health outcomes and the
                    strong role of the health sector in the productive and economic development,
                    make the...
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-comment"></i> Rio de Janeiro, Brasil </small>
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >IX Curso de Especialização em Direito Sanitário</strong
                    >
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    Capacitar o corpo discente com conhecimentos jurídico-político-sanitários
                    de forma a desenvolver expertise para compreensão e atuação nas questões
                    sanitárias contemporâneas.
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <img
                src="http://localhost:8000/images/nt-vigilancia.jpg"
                class="card-img-top"
                alt=""
              />
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >Curso de Especialização em Saúde Coletiva</strong
                    >
                  </a>
                </h5><div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                  O Programa de Especialização em Saúde Coletiva proposto pela Escola de Governo em
                  Saúde tem como objetivo proporcionar uma formação reflexiva e crítica sobre o
                  campo da Saúde Coletiva e o aprofundamento de estudos em uma das seguintes
                  áreas temáticas da Política de Saúde
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-10 pb-5 d-flex  justify-content-center">          
          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <div class="card-body">
                <h5 class="card-title mb-0 pb-0">
                  <a
                    href="https://agora.fiocruz.br/blog/event/planejamento-urbano-e-seguranca-hidrica/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong>Health & STI for 2030 Agenda</strong>
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">2030 AGENDA</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 30/11/2018</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    BACKGROUND The holistic nature of 2030 Agenda and SDGs demands an
                    integrated and systematic approach while dealing with the specificities
                    of each of the 17 Sustainable Development Goals (SDGs). The relevance
                    of social and environmental determinants in health outcomes and the
                    strong role of the health sector in the productive and economic development,
                    make the...
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-comment"></i> Rio de Janeiro, Brasil </small>
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >IX Curso de Especialização em Direito Sanitário</strong
                    >
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    Capacitar o corpo discente com conhecimentos jurídico-político-sanitários
                    de forma a desenvolver expertise para compreensão e atuação nas questões
                    sanitárias contemporâneas.
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <img
                src="http://localhost:8000/images/nt-vigilancia.jpg"
                class="card-img-top"
                alt=""
              />
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >Curso de Especialização em Saúde Coletiva</strong
                    >
                  </a>
                </h5><div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                  O Programa de Especialização em Saúde Coletiva proposto pela Escola de Governo em
                  Saúde tem como objetivo proporcionar uma formação reflexiva e crítica sobre o
                  campo da Saúde Coletiva e o aprofundamento de estudos em uma das seguintes
                  áreas temáticas da Política de Saúde
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-10 pb-5 d-flex  justify-content-center">          
          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <div class="card-body">
                <h5 class="card-title mb-0 pb-0">
                  <a
                    href="https://agora.fiocruz.br/blog/event/planejamento-urbano-e-seguranca-hidrica/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong>Health & STI for 2030 Agenda</strong>
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">2030 AGENDA</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 30/11/2018</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    BACKGROUND The holistic nature of 2030 Agenda and SDGs demands an
                    integrated and systematic approach while dealing with the specificities
                    of each of the 17 Sustainable Development Goals (SDGs). The relevance
                    of social and environmental determinants in health outcomes and the
                    strong role of the health sector in the productive and economic development,
                    make the...
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-comment"></i> Rio de Janeiro, Brasil </small>
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >IX Curso de Especialização em Direito Sanitário</strong
                    >
                  </a>
                </h5>
                <div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                    Capacitar o corpo discente com conhecimentos jurídico-político-sanitários
                    de forma a desenvolver expertise para compreensão e atuação nas questões
                    sanitárias contemporâneas.
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>

          <div class="p-3">
            <div class="card" style="width: 24rem; height: auto !important;">
              <img
                src="http://localhost:8000/images/nt-vigilancia.jpg"
                class="card-img-top"
                alt=""
              />
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    href="https://agora.fiocruz.br/blog/event/experiencias-de-ciencia-cidada-para-biodiversidade-e-saude/"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    <strong
                      >Curso de Especialização em Saúde Coletiva</strong
                    >
                  </a>
                </h5><div class="card-info-area">
                  <div class="card-info">
                    <a class="btn btn-sm float-end" href="#">
                      <small class="text-white">CURSO</small>
                    </a>
                    <small> <i class="fas fa-calendar-alt"></i> 09/11/2017</small>
                  </div>                  
                </div>
                <p>
                  <span class="card-text">
                  O Programa de Especialização em Saúde Coletiva proposto pela Escola de Governo em
                  Saúde tem como objetivo proporcionar uma formação reflexiva e crítica sobre o
                  campo da Saúde Coletiva e o aprofundamento de estudos em uma das seguintes
                  áreas temáticas da Política de Saúde
                  </span>
                </p>
                <div class="card-info-area">
                  <div class="card-info">                    
                    <small><i class="fas fa-hourglass" style="color: #48773E;"></i> Expirado</small>
                  </div>                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">   
          <div class="col-md-12 p-5 d-flex justify-content-center">
            <a class="btn btn-secondary" style="background-color:#fff; color:#888888; font-size: 14px;" href="#">
              Todos os eventos
            </a>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "Event",
  };
  </script>
  