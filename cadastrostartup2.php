
<?php
$host = 'localhost:3307';
$dbname = 'mapa_inovacao';
$user = 'root';
$password = '';

session_start();
if (isset($_SESSION['user_name'])) {
    $nome_usuario = $_SESSION['user_name'];
} else {
    $nome_usuario = null;
}

$connection = new mysqli($host, $user, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Recebe o ID da startup
$startup_id = $_GET['id'];

// Busca os detalhes da startup na tabela detalhes_startup
$sql = "SELECT * FROM detalhes_startup WHERE startup_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $startup_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $detalhes = $result->fetch_assoc();
} else {
    // Se não encontrar detalhes, inicializa com valores padrão
    $detalhes = [
        'inovacao' => '',
        'escalabilidade' => '',
        'repetibilidade' => '',
        'modelo_negocio' => '',
        'equipe_fundadora' => '',
        'mercado_alvo' => '',
        'estagio_desenvolvimento' => '',
        'tracao' => '',
        'riscos' => '',
        'nps' => '',
        'cash_burn_rate' => '',
        'seguranca_informacao' => '',
        'cac' => ''
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Detalhes - Startup</title>
    <link rel="stylesheet" href="cadastrostartup.css">
</head>
<body>
    <header>
        <h1>Cadastro de Detalhes da Startup</h1>
    </header>

    <main>
        <form action="atualizardetalhes.php" method="POST">
            <input type="hidden" name="startup_id" value="<?php echo htmlspecialchars($startup_id); ?>">
            <div class="form-group">
                <label for="inovacao">Inovação:</label>
                <textarea id="inovacao" name="inovacao"><?php echo htmlspecialchars($detalhes['inovacao']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="escalabilidade">Escalabilidade:</label>
                <textarea id="escalabilidade" name="escalabilidade"><?php echo htmlspecialchars($detalhes['escalabilidade']); ?></textarea>
            </div>
            <!-- Repetir para todos os campos... -->
            <div class="form-group">
                <label for="nps">NPS:</label>
                <input type="number" id="nps" name="nps" step="0.1" value="<?php echo htmlspecialchars($detalhes['nps']); ?>">
            </div>
            <div class="form-group">
                <label for="cash_burn_rate">Cash Burn Rate:</label>
                <input type="number" id="cash_burn_rate" name="cash_burn_rate" step="0.01" value="<?php echo htmlspecialchars($detalhes['cash_burn_rate']); ?>">
            </div>
            <button type="submit">Salvar Detalhes</button>
        </form>
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