
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
    <title>Cadastro de Startup</title>
    <link rel="stylesheet" href="cadastrostartup.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <header>
        <h1>Mapa de Inovação - Sul Catarinense</h1>
        <nav>
            <ul>
            <li><a href="indexlogado.php">Início</a></li>
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
        <section id="registro-startup">
            <h2>Preencha os dados da sua Startup</h2>
            <form action="registrar_startup.php" method="post">
                <label for="nomeDaStartup">Nome da Startup:</label>
                <input type="text" id="nomeDaStartup" name="nomeDaStartup" required>

                <label for="fundadores">Fundadores:</label>
                <input type="text" id="fundadores" name="fundadores" required>

                <label for="dataDeFundacao">Data de Fundação:</label>
                <input type="date" id="dataDeFundacao" name="dataDeFundacao" required>

                <label for="areaDeAtuacao">Área de Atuação:</label>
                <input type="text" id="areaDeAtuacao" name="areaDeAtuacao" required>

                <label for="descricao">Descrição da Startup:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>

                <label for="endereco">Endereço de Criação da Ideia:</label>
                <input type="text" id="endereco" name="endereco" required>

                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" required>

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" required>

                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" required>

                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" maxlength="8" placeholder="Digite o CEP" required>

                <label for="site">Site da Startup:</label>
                <input type="url" id="site" name="site">
                <form id="startupForm">
                <label for="email">E-mail de Contato:</label>
                <input type="email" id="email" name="email" placeholder="Digite o e-mail" required>
                <label for="whatsapp">WhatsApp de Contato:</label>
                <input type="text" id="whatsapp" name="whatsapp" maxlength="13" placeholder="Ex.: 5541999999999" required>

                <label for="inovacao">Inovação:</label>
                <textarea id="inovacao" name="inovacao" rows="3" placeholder="Descreva a inovação da sua startup" required></textarea>

                <label for="modeloNegocio">Modelo de Negócio:</label>
                <textarea id="modelo_negocio" name="modelo_negocio" rows="3" placeholder="Explique o modelo de negócio" required></textarea>

                <label for="mercadoAlvo">Mercado-Alvo:</label>
                <textarea id="mercado_alvo" name="mercado_alvo" rows="3" placeholder="Descreva o mercado-alvo da startup" required></textarea>
                

                    <!-- Campos do formulário -->
                     
                    <button type="submit">Registrar</button>
                </form>
            </form>
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