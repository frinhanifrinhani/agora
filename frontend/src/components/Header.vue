<template>
    <nav class="navbar navbar-expand bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="@/assets/images/logo_AgoraFiocruz.png" alt="Bootstrap" width="275" height="46">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">EFA 2030</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://solucoes.agora.fiocruz.br/" target="_blank">Soluções para Saúde</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/noticias">Notícias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://redes.agora.fiocruz.br/" target="_blank">Redes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://ifuturo.agora.fiocruz.br/" target="_blank">Ifuturo</a>
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
                        <a class="nav-link" href="/sobre">Sobre</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</template>

<script>
export default {
  name: 'Header',
  data() {
    return {
      baseUrl: import.meta.env.VITE_BASE_URL,
    };
  }
};
</script>