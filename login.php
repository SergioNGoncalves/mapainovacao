<?php
session_start();

// Verifica se os dados de login foram enviados
if (isset($_POST['username']) && isset($_POST['password'])) {
    $host = 'localhost:3307';
    $dbname = 'mapa_inovacao';
    $user = 'root';
    $password = ''; // Senha do banco de dados

    // Conexão com o banco de dados
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password_input = $_POST['password']; // Senha fornecida pelo usuário

    // Consulta para verificar o usuário
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Previne injeção de SQL
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se o usuário for encontrado, armazene os dados na sessão
        $user = $result->fetch_assoc(); // Recupera os dados do usuário

        // Verificar se a senha fornecida corresponde à senha criptografada no banco
        if (password_verify($password_input, $user['password'])) {
            // Senha correta
            $_SESSION['user_id'] = $user['id']; // ID do usuário
            $_SESSION['user_name'] = $user['nome']; // Nome do usuário
            $_SESSION['username'] = $username; // Nome de usuário para exibição

            // Redireciona para a página inicial
            header("Location: indexlogado.php");
            exit();
        } else {
            // Senha incorreta
            $error = "Usuário ou senha inválidos!";
        }
    } else {
        // Usuário não encontrado
        $error = "Usuário ou senha inválidos!";
    }

    // Fecha a conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <p>Não tem uma conta? <a href="cadastrousuario.php" class="register-link">Cadastre-se</a></p>
    </div>
</body>
</html>