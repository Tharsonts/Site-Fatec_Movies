<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
    <title>Fatec Movies - Filmes e Séries Online</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="../image/icone-site/logoteste2a.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .conteudo-flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .topo-logo img {
            max-width: 100%;
            height: auto;
        }
        .profile-menu {
            display: none;
            position: absolute;
            background-color: #FF69B4;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .profile-menu a {
            padding: 12px 16px;
            display: block;
            text-align: left;
        }
        .profile-menu a:hover {
            background-color: #ffcbdb;
        }
    </style>
    <script>
        function toggleMenu() {
            var menu = document.getElementById("profileMenu");
            if (menu.style.display === "none" || menu.style.display === "") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (!event.target.matches('.profile img')) {
                var dropdowns = document.getElementsByClassName("profile-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }
    </script>
</head>

<body>
    <div class="topo conteudo-flex">
        <div class="topo-esquerdo conteudo-flex">
            <div class="topo-logo">
                <img src="../image/logoteste2a.png" alt="Imagem logotipo do site" title="Imagem logotipo do site">
            </div>
        </div>

        <div class="topo-centro conteudo-flex">
            <nav>
                <ul class="topo-menu conteudo-flex">
                    <li><a href="#">Início</a></li>
                    <li><a href="../html/series.html">Séries</a></li>
                    <li><a href="../html/filmes.html">Filmes</a></li>
                    <li><a href="../html/categorias.html">Categorias</a></li>
                    <li><a href="../html/assinaturas.html">Assinaturas</a></li>
                </ul>
            </nav>
            <div class="topo-pesquisa">
                <div class="conteudo-pesquisa">
                    <form class="conteudo-flex" method="post">
                        <fieldset class="bar-pesquisa">
                            <input type="text" placeholder="Pesquisar um filme ou série..." alt="Digite aqui um filme ou série para pesquisar">
                        </fieldset>
                        <fieldset class="btn-pesquisar conteudo-flex">
                            <button type="button" title="Pesquisar">
                                <span class="fas fa-search"></span>
                            </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <div class="topo-direito">
            <div class="sublogin">
                <?php if(isset($_SESSION['username'])): ?>
                    <div class="profile">
                        <img src="../image/icone-perfil.png" alt="Ícone de Perfil" onclick="toggleMenu()">
                        <span><?php echo htmlspecialchars(ucwords(strtolower($_SESSION['username']))); ?></span>
                        <div id="profileMenu" class="profile-menu">
                            <a href="cadastrar_filmes.php">Cadastrar Filmes</a>
                            <a href="filmes_cadastrados.php">Filmes Cadastrados</a>
                            <a href="configuracoes.php">Configurações</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="login-signup">
                        <a href="login.php">Login</a>
                        <a href="signup.php">Sign Up</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="conteudo-principal">
        <div class="primeiro-h1">
            <h1>O melhor site de filmes e séries online</h1>
        </div>

        <div class="elementos conteudo-flex">
            <div class="capa">
                <a href="../html/01-filme.html"><img src="../image/homem-formiga-capa.jpg" alt="imagem modelo capa de filme" title="imagem modelo capa de filme" style="width: 310px; height: 442px;"></a>
            </div>
            <div class="capa">
                <a href="../html/04-filme.html"><img src="../image/X-men-fenix-capa.jpg" alt="imagem modelo capa de série" title="imagem modelo capa de série" style="width: 310px; height: 442px;"></a>
            </div>
            <div class="capa">
                <a href="../html/02-filme.html"><img src="../image/capita-marvel-capa.jpg" alt="imagem modelo capa de filme" title="imagem modelo capa de filme" style="width: 310px; height: 442px;"></a>
            </div>
            <div class="capa">
                <a href="../html/05-filme.html"><img src="../image/quantumania-capa.jpg" alt="imagem modelo capa de série" title="imagem modelo capa de série" style="width: 310px; height: 442px;"></a>
            </div>
            <div class="capa">
                <a href="../html/03-filme.html"><img src="../image/thor-ragnarok-capa.jpg" alt="imagem modelo capa de filme" title="imagem modelo capa de filme" style="width: 310px; height: 442px;"></a>
            </div>
            <div class="capa">
                <a href="../html/06-filme.html"><img src="../image/vingadores-guerra-infinita-capa.jpg" alt="imagem modelo capa de série" title="imagem modelo capa de série" style="width: 310px; height: 442px;"></a>
            </div>
        </div>
    </div>

    <footer>
        <div class="site-map conteudo-flex">
            <div class="site-map-conteudo">
                <ul>
                    <li><a href="#">Sobre nós</a></li>
                    <li><a href="#">Carreiras</a></li>
                    <li><a href="#">Perguntas frequentes</a></li>
                    <li><a href="#">Imprensa</a></li>
                </ul>
            </div>
            <div class="site-map-conteudo">
                <ul>
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Política de Segurança</a></li>
                    <li><a href="#">Termo de Uso</a></li>
                    <li><a href="#">Avisos Legais</a></li>
                </ul>
            </div>
            <div class="site-map-conteudo">
                <ul>
                    <li><a href="#">Conta</a></li>
                    <li><a href="../html/contato.html">Contato</a></li>
                    <li><a href="#">Centro de Ajuda</a></li>
                    <li><a href="#">Teste de Velocidade</a></li>
                </ul>
            </div>
        </div>
        <div>
            <img src="../image/logoteste2a.png" alt="Imagem logotipo do site" title="Imagem logotipo do site">
        </div>
    </footer>
</body>
</html>