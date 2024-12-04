<?php
session_start(); // Inicia a sessão para acessar os dados do usuário logado

// Verifica se o usuário está logado
if (isset($_SESSION['user_name'])) {
    $nome_usuario = $_SESSION['user_name']; // Obtém o nome do usuário logado
} else {
    $nome_usuario = null; // Se não estiver logado, não exibe nada
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Inovação - Sul Catarinense</title>
    <link rel="stylesheet" href="indexlogado.css">
</head>
<body>
    <header>
        <h1>Mapa de Inovação - Sul Catarinense</h1>
        <nav>
            <ul>
                <li>
                    <a href="#startups">Startups</a>
                    <ul class="submenu">
                        <li><a href="detalhestartup.php">Ver</a></li>
                        <li><a href="cadastrostartup.php">Cadastro</a></li>
                        <li><a href="mapeamentostartups.php">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#empresas">Empresas de Tecnologia</a>
                    <ul class="submenu">
                        <li><a href="#ver-empresas">Ver</a></li>
                        <li><a href="#cadastro-empresas">Cadastro</a></li>
                        <li><a href="#mapeamento-empresas">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#laboratorios">Laboratórios de Inovação</a>
                    <ul class="submenu">
                        <li><a href="#ver-laboratorios">Ver</a></li>
                        <li><a href="#cadastro-laboratorios">Cadastro</a></li>
                        <li><a href="#mapeamento-laboratorios">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#incubadoras">Incubadoras</a>
                    <ul class="submenu">
                        <li><a href="#ver-incubadoras">Ver</a></li>
                        <li><a href="#cadastro-incubadoras">Cadastro</a></li>
                        <li><a href="#mapeamento-incubadoras">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#coworkings">Coworkings</a>
                    <ul class="submenu">
                        <li><a href="#ver-coworkings">Ver</a></li>
                        <li><a href="#cadastro-coworkings">Cadastro</a></li>
                        <li><a href="#mapeamento-coworkings">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                <a href="#instituicoes">Instituições de Ensino</a>
                    <ul class="submenu">
                        <li><a href="#ver-instituicoes">Ver</a></li>
                        <li><a href="#cadastro-instituicoes">Cadastro</a></li>
                        <li><a href="#mapeamento-instituicoes">Mapeamento</a></li>
                        </ul>
                    </li>
                    <li>
                    <?php if ($nome_usuario): ?>
                    <div class="menu-usuario">
                        <a href="#" id="usuarioMenu">Olá, <?php echo htmlspecialchars($nome_usuario); ?></a>
                        <ul class="submenu-usuario" id="submenuUsuario">
                            <li><a href="editarusuario.php">Configurações</a></li>
                            <li><a href="index.html">Sair</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="sobre">
            <div class="explicacao">
                <h2>O que é o Mapa de Inovação?</h2>
                <p>O <strong>Mapa de Inovação - Sul Catarinense</strong> é uma plataforma digital que tem como objetivo registrar, mapear e conectar as diversas iniciativas de inovação no Sul de Santa Catarina. Nossa missão é fornecer uma visão clara e abrangente do ecossistema de startups, coworkings, empresas de tecnologia, laboratórios de inovação e instituições de ensino. Com isso, o site facilita o processo de criação e desenvolvimento de novas startups, conectando empreendedores, investidores, instituições de ensino e governo.</p>
                <p>Além disso, a plataforma facilita a visualização de dados sobre a localização das startups e outras iniciativas, o que possibilita aos órgãos governamentais identificar regiões com maior potencial de crescimento e, assim, direcionar recursos financeiros e políticas públicas para apoiar o empreendedorismo local. Dessa forma, buscamos incentivar ainda mais a criação de startups e promover o desenvolvimento regional sustentável e inovador.</p>
            </div>
        </section>

        <section id="startups">
            <div class="explicacao">
                <h2>O que é uma Startup?</h2>
                <p>Uma <strong>startup</strong> é uma empresa jovem, geralmente de base tecnológica, que busca desenvolver um modelo de negócios escalável e inovador, com grande potencial de crescimento no mercado. Essas empresas se caracterizam pela busca constante de soluções disruptivas e pela flexibilidade em sua estrutura e processos, o que permite que elas se adaptem rapidamente às mudanças do mercado e às necessidades dos consumidores.</p>
                <p>O crescimento das startups é essencial para o desenvolvimento econômico, pois elas geram novos empregos, atraem investimentos e contribuem para a transformação digital e a inovação em diversas áreas. Em uma região como o Sul Catarinense, a criação e o incentivo às startups pode ser uma estratégia chave para fomentar a economia local e atrair mais investimentos para a região.</p>
            </div>
            </section>

        <section id="empresas">
            <div class="explicacao">
                <h2>Empresas de Tecnologia</h2>
                <p>As empresas de tecnologia desempenham um papel fundamental no ecossistema de inovação, ao aplicar novas tecnologias para resolver problemas antigos ou criar soluções mais eficientes. Nosso site também reúne informações sobre essas empresas, ajudando a mapear aquelas que estão mais focadas em áreas como inteligência artificial, automação, e-commerce e soluções para a indústria 4.0, fortalecendo a conexão entre startups e empresas já estabelecidas no mercado.</p>
            </div>
            </section>

        <section id="laboratorios">
            <div class="explicacao">
                <h2>Laboratórios de Inovação</h2>
            <p>Os laboratórios de inovação são espaços dedicados ao desenvolvimento de novos produtos e soluções. Eles oferecem infraestrutura, recursos e know-how para empresas em estágio inicial ou em processo de pesquisa e desenvolvimento. A presença desses laboratórios é fundamental para criar um ambiente propício para o surgimento de startups e a inovação tecnológica.</p>
        </div>
        </section>

        <section id="incubadoras">
            <div class="explicacao">
                <h2>Incubadoras</h2>
            <p>As <strong>incubadoras</strong> são organizações que auxiliam no desenvolvimento de empresas em fase inicial, oferecendo suporte com mentoria, treinamento, recursos financeiros e acesso a redes de contatos. Elas desempenham um papel crucial para startups, proporcionando um ambiente estruturado que ajuda na transformação de ideias inovadoras em negócios de sucesso. A incubação oferece às empresas iniciantes as ferramentas necessárias para se estabelecer no mercado de forma mais eficaz.</p>
        </div>
        </section>

        <section id="coworkings">
            <div class="explicacao">
                <h2>Coworkings</h2>
            <p>Os <strong>coworkings</strong> são espaços compartilhados onde profissionais independentes, freelancers e pequenas empresas podem trabalhar em um ambiente colaborativo. Esses espaços são essenciais para startups, pois oferecem infraestrutura de escritório a baixo custo, promovem o networking e a troca de experiências entre empreendedores de diferentes áreas. Ao escolher um coworking, startups podem reduzir custos operacionais enquanto se concentram em seu crescimento e desenvolvimento.</p>
       </div>
        </section>

        <section id="instituicoes">
            <div class="explicacao">
                <h2>Instituições de Ensino</h2>
                <p>As <strong>instituições de ensino</strong> desempenham um papel vital na formação de novos talentos e na pesquisa acadêmica que impulsiona a inovação. Elas são responsáveis por preparar os futuros profissionais para o mercado de trabalho e, muitas vezes, oferecem programas de aceleração ou incubação de startups. O vínculo entre o setor acadêmico e as empresas de tecnologia é essencial para a criação de soluções inovadoras, e o fortalecimento dessas instituições pode acelerar o crescimento do ecossistema de startups.</p>
        </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Mapa de Inovação - Sul Catarinense</p>
    </footer>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const usuarioMenu = document.getElementById("usuarioMenu");
    const submenuUsuario = document.getElementById("submenuUsuario");

    usuarioMenu.addEventListener("click", function (event) {
        event.preventDefault();
        submenuUsuario.style.display = 
            submenuUsuario.style.display === "block" ? "none" : "block";
    });

    // Fecha o menu ao clicar fora dele
    document.addEventListener("click", function (event) {
        if (!usuarioMenu.contains(event.target) && 
            !submenuUsuario.contains(event.target)) {
            submenuUsuario.style.display = "none";
        }
    });
});
</script>