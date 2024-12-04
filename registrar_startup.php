<?php
session_start(); // Inicia a sessão para acessar os dados do usuário logado

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para cadastrar uma startup.");
}

// Obtém o nome do usuário logado (supondo que você tenha armazenado o nome do usuário na sessão)
$nome_usuario = $_SESSION['user_name'] ?? 'Usuário';

// Configuração do banco de dados
$host = 'localhost:3307';
$dbname = 'mapa_inovacao'; // Substitua pelo nome do seu banco
$user = 'root';    // Substitua pelo seu usuário do banco
$password = '';  // Substitua pela sua senha
session_start(); // Inicia a sessão para acessar os dados do usuário logado

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para cadastrar uma startup.");
}

// Obtém o nome do usuário logado (supondo que você tenha armazenado o nome do usuário na sessão)
$nome_usuario = $_SESSION['user_name'] ?? 'Usuário';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nomeDaStartup = $_POST['nomeDaStartup'] ?? '';
    $fundadores = $_POST['fundadores'] ?? '';
    $dataDeFundacao = $_POST['dataDeFundacao'] ?? '';
    $areaDeAtuacao = $_POST['areaDeAtuacao'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $site = $_POST['site'] ?? null;
    $cep = $_POST['cep'] ?? '';
    $email = $_POST['email'] ?? ''; // Novo campo para e-mail
    $whatsapp = $_POST['whatsapp'] ?? ''; // Novo campo para WhatsApp
    $inovacao = $_POST['inovacao'] ?? ''; // Novo campo: inovação
    $modelo_negocio = $_POST['modelo_negocio'] ?? ''; // Novo campo: modelo de negócio
    $mercado_alvo = $_POST['mercado_alvo'] ?? ''; // Novo campo: mercado-alvo


    // Validação: Verifica se o CEP foi preenchido e possui 8 caracteres
    if (empty($cep) || strlen($cep) != 8) {
        echo "O campo CEP é obrigatório e deve conter 8 caracteres.";
        exit;
    }

    // Validação simples
    if (
        empty($nomeDaStartup) || empty($fundadores) || empty($dataDeFundacao) ||
        empty($areaDeAtuacao) || empty($descricao) || empty($endereco) ||
        empty($cidade) || empty($estado) || empty($pais) || empty($cep) || empty($email) || empty($whatsapp) || empty($inovacao) || 
        empty($modelo_negocio) || empty($mercado_alvo)
    ) {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
        exit;
    }

    // Obtém o ID do usuário logado da sessão
    $usuario_id = $_SESSION['user_id'];

    // Insere os dados no banco de dados, incluindo o usuario_id
    $sql = "INSERT INTO startups (nomeDaStartup, fundadores, dataDeFundacao, areaDeAtuacao, descricao, endereco, cidade, estado, pais, cep, site, email, whatsapp,inovacao, modelo_negocio, mercado_alvo, usuario_id)
            VALUES (:nomeDaStartup, :fundadores, :dataDeFundacao, :areaDeAtuacao, :descricao, :endereco, :cidade, :estado, :pais, :cep, :site, :email, :whatsapp, :inovacao, :modelo_negocio, :mercado_alvo, :usuario_id)";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nomeDaStartup' => $nomeDaStartup,
            ':fundadores' => $fundadores,
            ':dataDeFundacao' => $dataDeFundacao,
            ':areaDeAtuacao' => $areaDeAtuacao,
            ':descricao' => $descricao,
            ':endereco' => $endereco,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':pais' => $pais,
            ':site' => $site,
            ':cep' => $cep,
            ':email' => $email, // Adiciona o e-mail no banco
            ':whatsapp' => $whatsapp, // Adiciona o WhatsApp no banco
            ':inovacao' => $inovacao,
            ':modelo_negocio' => $modelo_negocio,
            ':mercado_alvo' => $mercado_alvo,
            ':usuario_id' => $usuario_id // Adiciona o ID do usuário logado
        ]);

        // Redireciona para a página de startups cadastradas
        header("Location: detalhestartup.php");
        exit; // Garante que o script será encerrado após o redirecionamento
    } catch (PDOException $e) {
        echo "Erro ao registrar a startup: " . $e->getMessage();
    }
    
}
?>