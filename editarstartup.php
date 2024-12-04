<link rel="stylesheet" href="editarstartup.css">
<?php
session_start(); // Inicia a sessão para acessar os dados do usuário logado

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para editar uma startup.");
}

// Conectar ao banco de dados
$host = 'localhost:3307';
$dbname = 'mapa_inovacao';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Buscar a startup pelo ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario_id = $_SESSION['user_id']; // Obtém o ID do usuário logado

    // Verifica se a startup pertence ao usuário logado
    $sql = "SELECT usuario_id, nomeDaStartup, fundadores, dataDeFundacao, areaDeAtuacao, descricao, endereco, cidade, estado, pais, cep, email, whatsapp, inovacao, modelo_negocio, mercado_alvo, site FROM startups WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $startup = $result->fetch_assoc();

    if (!$startup) {
        die("Startup não encontrada.");
    }

    // Se o usuário logado não for o dono da startup
    if ($usuario_id != $startup['usuario_id']) {
        echo "<script>alert('Você não tem permissão para editar esta startup.');</script>";
    exit();
    }
} else {
    die("ID não fornecido.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizar os dados da startup
    $nome = $_POST['nome'];
    $fundadores = $_POST['fundadores'];
    $dataDeFundacao = $_POST['dataDeFundacao'];
    $areaDeAtuacao = $_POST['areaDeAtuacao'];
    $descricao = $_POST['descricao'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $pais = $_POST['pais'];
    $cep = $_POST['cep'];
    $site = $_POST['site'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];
    $inovacao = $_POST['inovacao'];
    $modelo_negocio = $_POST['modelo_negocio'];
    $mercado_alvo = $_POST['mercado_alvo'];

    // Atualiza a startup no banco de dados
    $sql = "UPDATE startups SET nomeDaStartup = ?, fundadores = ?, dataDeFundacao = ?, areaDeAtuacao = ?, descricao = ?, endereco = ?, cidade = ?, estado = ?, pais = ?, cep = ?, site = ?, email = ?, whatsapp = ?, inovacao = ?, modelo_negocio = ?, mercado_alvo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssi", $nome, $fundadores, $dataDeFundacao, $areaDeAtuacao, $descricao, $endereco, $cidade, $estado, $pais, $cep, $site,$email, $whatsapp, $inovacao, $modelo_negocio, $mercado_alvo, $id);

    if ($stmt->execute()) {
        echo "Startup atualizada com sucesso!";
        header('Location: detalhestartup.php'); // Redireciona após sucesso
        exit();
    } else {
        echo "Erro ao atualizar startup: " . $stmt->error;
    }
}

$conn->close();
?>

<!-- Formulário de edição -->
<h2 class="startup-title">Editar Startup: <?php echo htmlspecialchars($startup['nomeDaStartup']); ?></h2>
<form action="" method="post">
    <label for="nome">Nome da Startup</label>
    <input type="text" name="nome" value="<?php echo htmlspecialchars($startup['nomeDaStartup']); ?>" required><br>

    <label for="fundadores">Fundadores</label>
    <input type="text" name="fundadores" value="<?php echo htmlspecialchars($startup['fundadores']); ?>"><br>

    <label for="dataDeFundacao">Data de Fundação</label>
    <input type="date" name="dataDeFundacao" value="<?php echo htmlspecialchars($startup['dataDeFundacao']); ?>"><br>

    <label for="areaDeAtuacao">Área de Atuação</label>
    <input type="text" name="areaDeAtuacao" value="<?php echo htmlspecialchars($startup['areaDeAtuacao']); ?>"><br>

    <label for="descricao">Descrição</label>
    <textarea name="descricao"><?php echo htmlspecialchars($startup['descricao']); ?></textarea><br>

    <label for="endereco">Endereço</label>
    <input type="text" name="endereco" value="<?php echo htmlspecialchars($startup['endereco']); ?>"><br>

    <label for="cidade">Cidade</label>
    <input type="text" name="cidade" value="<?php echo htmlspecialchars($startup['cidade']); ?>"><br>

    <label for="estado">Estado</label>
    <input type="text" name="estado" value="<?php echo htmlspecialchars($startup['estado']); ?>"><br>

    <label for="pais">País</label>
    <input type="text" name="pais" value="<?php echo htmlspecialchars($startup['pais']); ?>"><br>

    <label for="cep">CEP</label>
    <input type="text" name="cep" value="<?php echo htmlspecialchars($startup['cep']); ?>"><br>

    <label for="site">Site</label>
    <input type="url" name="site" value="<?php echo htmlspecialchars($startup['site']); ?>"><br>

    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($startup['email']); ?>"><br>

    <label for="whatsapp">WhatsApp</label>
    <input type="text" name="whatsapp" value="<?php echo htmlspecialchars($startup['whatsapp']); ?>"><br>

    <label for="inovacao">Inovação</label>
    <textarea name="inovacao"><?php echo htmlspecialchars($startup['inovacao']); ?></textarea><br>

    <label for="modelo_negocio">Modelo de Negócio</label>
    <textarea name="modelo_negocio"><?php echo htmlspecialchars($startup['modelo_negocio']); ?></textarea><br>

    <label for="mercado_alvo">Mercado Alvo</label>
    <textarea name="mercado_alvo"><?php echo htmlspecialchars($startup['mercado_alvo']); ?></textarea><br>

    <input type="submit" value="Atualizar">
    <!-- Botão Cancelar -->
    <a href="detalhestartup.php?id=<?php echo $id; ?>" class="cancelar-btn">Cancelar</a>
</form>

