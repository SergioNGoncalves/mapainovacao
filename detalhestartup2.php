<?php
// Conectar ao banco de dados

$host = 'localhost:3307';
$dbname = 'mapa_inovacao'; // Substitua pelo nome do seu banco
$user = 'root';    // Substitua pelo seu usuário do banco
$password = '';  // Substitua pela sua senha

session_start(); // Inicia a sessão para acessar os dados do usuário logado

// Verifica se o usuário está logado
if (isset($_SESSION['user_name'])) {
    $nome_usuario = $_SESSION['user_name']; // Obtém o nome do usuário logado
} else {
    $nome_usuario = null; // Se não estiver logado, não exibe nada
}

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Buscar as startups registradas
$sql = "SELECT * FROM startups";
$result = $conn->query($sql);

$startups = [];
if ($result->num_rows > 0) {
    // Armazenar as startups em um array
    while ($row = $result->fetch_assoc()) {
        $startups[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startups Cadastradas</title>
    <link rel="stylesheet" href="detalhestartup.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Mapa de Inovação - Sul Catarinense</h1>
        <nav>
            <ul>
            <li><a href="index.html">Início</a></li>
                <li>
                    <a href="#startups">Startups</a>
                    <ul class="submenu">
                        <li><a href="detalhestartup2.php">Ver</a></li>
                        <li><a href="mapeamentostartup2.php">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#empresas">Empresas de Tecnologia</a>
                    <ul class="submenu">
                        <li><a href="#ver-empresas">Ver</a></li>
                        <li><a href="#mapeamento-empresas">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#laboratorios">Laboratórios de Inovação</a>
                    <ul class="submenu">
                        <li><a href="#ver-laboratorios">Ver</a></li>
                        <li><a href="#mapeamento-laboratorios">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#incubadoras">Incubadoras</a>
                    <ul class="submenu">
                        <li><a href="#ver-incubadoras">Ver</a></li>
                        <li><a href="#mapeamento-incubadoras">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#coworkings">Coworkings</a>
                    <ul class="submenu">
                        <li><a href="#ver-coworkings">Ver</a></li>
                        <li><a href="#mapeamento-coworkings">Mapeamento</a></li>
                    </ul>
                </li>
                <li>
                <a href="#instituicoes">Instituições de Ensino</a>
                    <ul class="submenu">
                        <li><a href="#ver-instituicoes">Ver</a></li>
                        <li><a href="#mapeamento-instituicoes">Mapeamento</a></li>
                    </ul>
                    <li><a href="login.php">Login</a></li>
            </li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="startups-cadastradas">
            <h2>Startups Cadastradas</h2>
            <input type="text" id="searchBar" placeholder="Pesquisar startups..." onkeyup="searchStartups()">
            
            <?php if (empty($startups)): ?>
                <p>Nenhuma startup cadastrada ainda.</p>
            <?php else: ?>
                <?php foreach ($startups as $startup): ?>
                    <div class="registro" data-name="<?php echo htmlspecialchars($startup['nomeDaStartup']); ?>" onclick="window.location.href='infostartup.php?id=<?php echo $startup['id']; ?>'">
                       <h3>Nome da Startup: <?php echo htmlspecialchars($startup['nomeDaStartup']); ?></h3>
                        <p><strong>Fundadores:</strong> <?php echo htmlspecialchars($startup['fundadores']); ?></p>
                        <!-- <p><strong>Data de Fundação:</strong> <?php echo htmlspecialchars($startup['dataDeFundacao']); ?></p> -->
                        <p><strong>Área de Atuação:</strong> <?php echo htmlspecialchars($startup['areaDeAtuacao']); ?></p>
                        <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($startup['descricao'])); ?></p>
                        <!-- <p><strong>Endereço:</strong> <?php echo htmlspecialchars($startup['endereco']); ?></p> -->
                        <p><strong>Cidade:</strong> <?php echo htmlspecialchars($startup['cidade']); ?></p>
                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($startup['estado']); ?></p>
                        <p><strong>País:</strong> <?php echo htmlspecialchars($startup['pais']); ?></p>
                        <!-- <p><strong>CEP:</strong> <?php echo htmlspecialchars($startup['cep']); ?></p> -->
                        <p><strong>Site:</strong> <a href="<?php echo htmlspecialchars($startup['site']); ?>" target="_blank"><?php echo htmlspecialchars($startup['site']); ?></a></p>
                        <!-- <p><strong>Avaliação:</strong> <?php echo htmlspecialchars($startup['avaliacao']); ?></p> -->
                        </p>
    <p><strong>WhatsApp:</strong> 
    <a href="https://wa.me/<?php echo htmlspecialchars($startup['whatsapp']); ?>" target="_blank">
        <i class="fab fa-whatsapp"></i> <?php echo htmlspecialchars($startup['whatsapp']); ?>
    </a>
    </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Mapa de Inovação - Sul Catarinense</p>
    </footer>
    <script>
        function searchStartups() {
            const input = document.getElementById('searchBar').value.toLowerCase();
            const registros = document.querySelectorAll('.registro');

            registros.forEach(registro => {
                const name = registro.getAttribute('data-name').toLowerCase();
                if (name.includes(input)) {
                    registro.style.display = '';
                } else {
                    registro.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
