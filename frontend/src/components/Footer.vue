<template>

    <div class="row justify-content-center py-5" style="background-image: linear-gradient(360deg, #575860 0%, #3a3a3a 100%);">
        <div class="col-md-10 d-flex flex-wrap pb-5 ">
            <div class="justify-content-md-center col-12 col-md-3 py-4 px-4 flex-container">
                <div>
                    <p class="h5 text" style="color: #FFFFFF; font-size: 15px; font-weight: 600;">
                        <strong>SOBRE O ÁGORA</strong>
                    </p>
                    <p style="color: #FFFFFF; line-height: 1.42857143; font-size: 14px; font-weight: 400;" class="text">
                        Ciência, Tecnologia e Educação Abertas para a Saúde.
                    </p>
                    <div>
                        <div class="row justify-content-md-center g-2 div-center">
                            <div class="col-auto">
                                <img src="@/assets/images/facebook.png" class="img-fluid" alt="Logo facebook">
                            </div>
                            <div class="col-auto">
                                <img src="@/assets/images/instagram.png" class="img-fluid" alt="Logo Instagram">
                            </div>
                            <div class="col-auto">
                                <img src="@/assets/images/linkedin.png" class="img-fluid" alt="Logo Linkedin">
                            </div>
                            <div class="col-auto">
                                <img src="@/assets/images/x.png" class="img-fluid" alt="Logo X">
                            </div>
                            <div class="col-auto">
                                <img src="@/assets/images/youtube.png" class="img-fluid" alt="Logo Youtube">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="justify-content-md-center col-12 col-md-2 py-4 px-4">
                <div>
                    <p class="h5 text" style="color: #FFFFFF; font-size: 15px; font-weight: 600;"><strong>MAPA DO SITE</strong></p>
                    <p>
                    <ul style="color: #FFFFFF; line-height: 1.42857143; font-size: 14px; font-weight: 400;" class="text list-markers">
                        <li><a href="/" class="text-reset text-decoration-none"> Início</a></li>
                        <li><a href="https://redes.agora.fiocruz.br/" class="text-reset text-decoration-none"> Redes</a></li>
                        <li><a href="/agenda-2030 " class="text-reset text-decoration-none"> Ágora 2030</a></li>
                        <li><a href="/evento " class="text-reset text-decoration-none"> Eventos</a></li>
                        <li><a href="/sobre " class="text-reset text-decoration-none"> Sobre</a></li>
                    </ul>
                    </p>
                </div>
            </div>
            <div class="justify-content-md-center  col-12 col-md-7 py-4 px-4">
                <div>
                    <p class="h5 text" style="color: #FFFFFF; font-size: 15px; font-weight: bolder;">
                        REALIZAÇÃO
                    </p>
                    <div class="d-flex flex-wrap align-items-center div-center">
                        <img src="@/assets/images/efas-rodape.png" alt="Logo estratégia Fiocruz Agenda 2030" class="px-2 pt-2">
                        <img src="@/assets/images/logo-fiocruz-rodape.png" alt="Imagem Fiocruz" class="px-2 pt-2">
                        <img src="@/assets/images/logo-ms-rodape.png" alt="Logo Ministério da Saúde" class="px-2 pt-2">
                        <img src="@/assets/images/logo-gov-rodape.png" alt="Logo Governo Federal" class="px-2 pt-2">
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
  name: 'Footer',
};
</script>

<style scoped>
@media (max-width: 765px){
  .text{
    text-align: center;
  }

  .div-center{
    justify-content: center;
    align-items: center;
  }

  .list-markers{
    list-style: none;
  }
}
</style>