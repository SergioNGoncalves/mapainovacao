<?php
// Configurações do banco de dados
$host = 'localhost:3307';
$dbname = 'mapa_inovacao';
$user = 'root';
$password = '';

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se os dados foram enviados pelo formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar e sanitizar os dados
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    
   
$password = $_POST['password'];
    
    
$confirm_password = $_POST['confirm_password'];

    // Verificar se a senha e a confirmação coincidem
    if ($password !== $confirm_password) {
        
     
echo "As senhas não coincidem.";
        
       
exit;
    }

    
 
// Criptografar a senha
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    

   
// Verificar se o e-mail ou nome de usuário já está em uso
    
   
$sql_check = "SELECT * FROM usuarios WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    

  
if ($result->num_rows > 0) {
        
        
echo "E-mail ou nome de usuário já está em uso.";
        
       
exit;
    }

    
 
// Inserir o novo usuário no banco de dados
    
  
$sql_insert = "INSERT INTO usuarios (nome, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssss", $nome, $email, $username, $hashed_password);

    if ($stmt->execute()) {
        
        
echo "Cadastro realizado com sucesso!";
        
        
header('Location: login.php'); // Redireciona para a página de login
        
        
exit;
    } else {
        
       
echo "Erro ao cadastrar usuário: " . $stmt->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="cadastrousuario.css">
</head>
<body>
    <div class="register-container">
        <h1>Cadastro de Usuário</h1>
        <form action="cadastrousuario.php" method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="username" placeholder="Nome de Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <input type="password" name="confirm_password" placeholder="Confirme a Senha" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>