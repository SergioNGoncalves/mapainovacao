<?php
session_start(); // Inicia a sessão para acessar os dados do usuário logado

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para excluir uma startup.");
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

// Excluir a startup pelo ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario_id = $_SESSION['user_id']; // Obtém o ID do usuário logado

    // Verifica se a startup pertence ao usuário logado
    $sql = "SELECT usuario_id FROM startups WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Se a startup foi encontrada, verifica se o usuário é o dono
        $stmt->bind_result($startup_usuario_id);
        $stmt->fetch();

        if ($usuario_id == $startup_usuario_id) {
            // Se o usuário logado é o dono da startup, procede com a exclusão
            $sql_delete = "DELETE FROM startups WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id);
            if ($stmt_delete->execute()) {
                echo "Startup excluída com sucesso!";
            } else {
                echo "Erro ao excluir a startup: " . $stmt_delete->error;
            }
        } else {
            echo "Você não tem permissão para excluir esta startup.";
        }
    } else {
        echo "Startup não encontrada.";
    }
} else {
    die("ID não fornecido.");
}

header('Location: detalhestartup.php');
exit();

$conn->close();
?>