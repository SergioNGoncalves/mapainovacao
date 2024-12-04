
<?php
// Conexão com o banco de dados
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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Consulta todas as startups com nome e CEP
$sql = "SELECT id, nomeDaStartup, cep FROM startups";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$startups = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Verificação para busca
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Se houver uma pesquisa, ajustar a consulta SQL
if ($searchQuery) {
    $sql = "SELECT id, nomeDaStartup, cep FROM startups WHERE nomeDaStartup LIKE :search LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':search' => "%$searchQuery%"]);
    $startups = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Caso contrário, pegar todas as startups
    $sql = "SELECT id, nomeDaStartup, cep FROM startups LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $startups = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Se a pesquisa for feita por AJAX, retorna as startups para o JavaScript
if (isset($_GET['ajax'])) {
    echo json_encode($startups);
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas de Tecnologia</title>
    <link rel="stylesheet" href="mapeamentostartups.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOLaRsX6_h7w-SKuJhwn1wEPguBHZ_Lv4&callback=initMap" async defer></script>
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
                </li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="map" style="height: 500px; width: 100%;"></div>
<!-- Barra de Pesquisa -->
<section id="search-section">
    <form action="" method="get">
        <input type="text" name="search" id="search-input" value="<?php echo htmlspecialchars($searchQuery); ?>" placeholder="Pesquisar startup..." />
        <input type="submit" value="Pesquisar" />
    </form>
    <!-- Div para exibir as sugestões de pesquisa -->
    <div id="suggestions" style="display: none;"></div>
</section>
        <!-- Lista das startups -->
        <section id="startups-lista">
            <h2>Startups Cadastradas</h2>
            <ul>
                <?php foreach ($startups as $startup): ?>
                    <li>
                    <a href="infostartup.php?id=<?php echo $startup['id']; ?>">
                        <strong><?php echo htmlspecialchars($startup['nomeDaStartup']); ?></strong><br>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Registro de Empresas de Tecnologia</p>
    </footer>

    <script>
        function initMap() {
            // Criação do mapa centralizado em um ponto genérico
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: -28.711076015687258, lng: -49.385085604782894 }  // Centro aproximado de Santa Catarina
            });
            // Dados das startups passados pelo PHP
            var startups = <?php echo json_encode($startups); ?>;

            var geocoder = new google.maps.Geocoder();

            // Loop para adicionar marcadores para todas as startups
            startups.forEach(function(startup) {
                var cep = startup.cep;
                var nome = startup.nomeDaStartup;

                // Fazendo a requisição à API do Google Geocoding
                geocoder.geocode({'address': cep}, function(results, status) {
                    if (status === 'OK') {
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            title: nome
                        });

                        // Opcional: Exibir um infowindow com o nome da startup
                        var infowindow = new google.maps.InfoWindow({
                            content: '<h3>' + nome + '</h3>'
                        });

                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });
                    } else {
                        console.log("Erro ao geocodificar o CEP " + cep + ": " + status);
                    }
                    
                });
            });
        }
        document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const suggestionsDiv = document.getElementById("suggestions");

    // Função para buscar as startups conforme o texto digitado
    searchInput.addEventListener("keyup", function () {
        const query = searchInput.value.trim();
        
        if (query.length > 0) {
            // Faz a requisição AJAX para buscar sugestões
            fetch(`?search=${query}&ajax=true`)
                .then(response => response.json())
                .then(data => {
                    suggestionsDiv.innerHTML = ''; // Limpa as sugestões anteriores

                    // Se houver sugestões, exibe-as
                    if (data.length > 0) {
                        suggestionsDiv.style.display = 'block';
                        data.forEach(startup => {
                            const suggestionItem = document.createElement("div");
                            suggestionItem.innerHTML = startup.nomeDaStartup;
                            suggestionItem.addEventListener("click", function () {
                                searchInput.value = startup.nomeDaStartup;
                                suggestionsDiv.style.display = 'none'; // Fecha a lista
                            });
                            suggestionsDiv.appendChild(suggestionItem);
                        });
                    } else {
                        suggestionsDiv.style.display = 'none';
                    }
                });
        } else {
            suggestionsDiv.style.display = 'none'; // Se o campo estiver vazio, fecha a lista
        }
    });

    // Fecha a lista de sugestões se clicar fora
    document.addEventListener("click", function (event) {
        if (!searchInput.contains(event.target) && !suggestionsDiv.contains(event.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });
});
    </script>

</body>
</html>