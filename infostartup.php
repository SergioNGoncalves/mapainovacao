<?php
session_start(); // Inicia a sessão para verificar se o usuário está logado

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para visualizar os detalhes das startups.");
}

// Configuração do banco de dados
$host = 'localhost:3307';
$dbname = 'mapa_inovacao'; // Substitua pelo nome do seu banco
$user = 'root';    // Substitua pelo seu usuário do banco
$password = '';  // Substitua pela sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Obtém o ID da startup a ser exibida via GET
$startupId = $_GET['id'] ?? null;

if (!$startupId) {
    die("Startup não especificada.");
}

// Busca os detalhes da startup no banco de dados
$sql = "SELECT * FROM startups WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $startupId]);
$startup = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$startup) {
    die("Startup não encontrada.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Startup</title>
    <link rel="stylesheet" href="infostartup.css">
</head>
<body>
    <header>
        <h1>Detalhes da Startup</h1>
    </header>
    <main>
        <section>
            <div class="startup-info">
                <h2><?php echo htmlspecialchars($startup['nomeDaStartup']); ?></h2>
            </div>

            <div class="details">
                <div class="detail-box">
                    <h3>Área de Atuação</h3>
                    <p><?php echo htmlspecialchars($startup['areaDeAtuacao']); ?></p>
                </div>
                <div class="detail-box">
                    <h3>Descrição</h3>
                    <p><?php echo htmlspecialchars($startup['descricao']); ?></p>
                </div>
                <div class="detail-box">
                    <h3>Inovação</h3>
                    <p><?php echo htmlspecialchars($startup['inovacao']); ?></p>
                </div>
                <div class="detail-box">
                    <h3>Modelo de Negócio</h3>
                    <p><?php echo htmlspecialchars($startup['modelo_negocio']); ?></p>
                </div>
                <div class="detail-box">
                    <h3>Mercado-Alvo</h3>
                    <p><?php echo htmlspecialchars($startup['mercado_alvo']); ?></p>
                </div>
                <div class="detail-box">
                    <h3>Outros Detalhes</h3>
                    <p><strong>Site:</strong> <a href="<?php echo htmlspecialchars($startup['site']); ?>" target="_blank"><?php echo htmlspecialchars($startup['site']); ?></a></p>
                    <p><strong>Fundadores:</strong> <?php echo htmlspecialchars($startup['fundadores']); ?></p>
                    <p><strong>Data de Fundação:</strong> <?php echo htmlspecialchars($startup['dataDeFundacao']); ?></p>
                </div>
            

            <div class="address-box">
                <h3>Endereço</h3>
                <p><strong>Endereço:</strong> <?php echo htmlspecialchars($startup['endereco']); ?></p>
                <p><strong>Cidade:</strong> <?php echo htmlspecialchars($startup['cidade']); ?></p>
                <p><strong>Estado:</strong> <?php echo htmlspecialchars($startup['estado']); ?></p>
                <p><strong>País:</strong> <?php echo htmlspecialchars($startup['pais']); ?></p>
                <p><strong>CEP:</strong> <?php echo htmlspecialchars($startup['cep']); ?></p>
            </div>

            <div class="contact-info">
                <h3>Contato</h3>
                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($startup['email']); ?></p>
                <p><strong>WhatsApp:</strong> <?php echo htmlspecialchars($startup['whatsapp']); ?></p>
            </div>
            </div>

            <a href="javascript:history.back()" class="back-button">Voltar</a>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Mapa de Inovação - Sul Catarinense</p>
    </footer>
</body>
</html>