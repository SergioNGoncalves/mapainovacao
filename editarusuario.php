<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

$host = 'localhost:3307';
$dbname = 'mapa_inovacao';
$user = 'root';
$password = '';

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Buscar os dados do usuário
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar os dados
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Se a senha for fornecida, criptografá-la
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql_update = "UPDATE usuarios SET nome = ?, email = ?, username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ssssi", $nome, $email, $username, $hashed_password, $user_id);
    } else {
        // Caso contrário, apenas atualizar os dados sem alterar a senha
        $sql_update = "UPDATE usuarios SET nome = ?, email = ?, username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("sssi", $nome, $email, $username, $user_id);
    }

    if ($stmt->execute()) {
        echo "Dados atualizados com sucesso!";
        header('Location: login.php'); // Redireciona para o perfil do usuário
        exit();
    } else {
        echo "Erro ao atualizar os dados: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="editarusuario.css">
</head>
<body>
    <div class="edit-container">
        <h1>Editar Dados do Usuário</h1>
        <form action="editarusuario.php" method="POST">
            <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" placeholder="Nome Completo" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="E-mail" required>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" placeholder="Nome de Usuário" required>
            <input type="password" name="password" placeholder="Nova Senha (Deixe em branco para manter a atual)">
            <button type="submit">Atualizar</button>
            <a href="indexlogado.php" class="cancel-button">Cancelar</a>
        </form>
    </div>
</body>
</html>