<?php
include("header.php");
session_start();

// Verifica se usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: index.php');
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$tipoUsuario = $_SESSION['tipoUsuario'];

// Só cliente pode acessar detalhes de compra
if ($tipoUsuario != 'cliente') {
    header('Location: index.php');
    exit();
}

// Verifica se o idCompra foi passado e é numérico
if (!isset($_GET['idCompra']) || !is_numeric($_GET['idCompra'])) {
    echo "<div class='container my-5'><div class='alert alert-danger'>ID da compra inválido!</div></div>";
    include("footer.php");
    exit();
}

$idCompra = (int) $_GET['idCompra'];

include("conexaoBD.php");

// Busca os dados da compra com os dados do carro
$sql = "
    SELECT 
        compras.idCompra,
        compras.dataCompra,
        compras.horaCompra,
        compras.valorCompra,
        carros.nomeCarro,
        carros.descricaoCarro,
        carros.fotoCarro,
        carros.marcaCarro,
        carros.modeloCarro,
        carros.anoCarro,
        carros.corCarro,
        carros.placaCarro
    FROM compras
    INNER JOIN carros ON compras.idCarro = carros.idCarro
    WHERE compras.idCompra = ? AND compras.idUsuario = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $idCompra, $idUsuario);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) == 1) {
    $registro = mysqli_fetch_assoc($result);

    $fotoCarro = htmlspecialchars($registro['fotoCarro']);
    $nomeCarro = htmlspecialchars($registro['nomeCarro']);
    $descricaoCarro = htmlspecialchars($registro['descricaoCarro']);
    $marcaCarro = htmlspecialchars($registro['marcaCarro']);
    $modeloCarro = htmlspecialchars($registro['modeloCarro']);
    $anoCarro = (int) $registro['anoCarro'];
    $corCarro = htmlspecialchars($registro['corCarro']);
    $placaCarro = htmlspecialchars($registro['placaCarro']);

    $dataCompra = date('d/m/Y', strtotime($registro['dataCompra']));
    $horaCompra = date('H:i', strtotime($registro['horaCompra']));
    $valorCompra = number_format($registro['valorCompra'], 2, ',', '.');
} else {
    echo "<div class='container my-5'><div class='alert alert-danger'>Compra não encontrada ou não pertence a você.</div></div>";
    include("footer.php");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<div class="container my-5">
    <h1 class="mb-4 fw-bold" style="color: #ff7f00;">Detalhes da Compra</h1>

    <div class="d-flex flex-column flex-md-row align-items-stretch gap-4">
        <!-- Coluna da imagem com flex-grow para ocupar 5/12 do espaço -->
        <div class="flex-shrink-0" style="flex-basis: 40%; max-width: 40%; min-width: 280px;">
            <img src="<?= $fotoCarro ?>" alt="Foto do carro <?= $nomeCarro ?>" 
                style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.25rem; box-shadow: 0 0 10px rgb(0 0 0 / 0.1); min-height: 320px;">
        </div>

        <!-- Coluna de conteúdo ocupa o restante -->
        <div class="flex-grow-1" style="min-width: 280px;">
            <h2 class="fw-bold mb-3"><?= $nomeCarro ?></h2>

            <p><i class="bi bi-building fs-5 me-2" style="color:#ff7f00;"></i><strong>Marca:</strong> <?= $marcaCarro ?></p>
            <p><i class="bi bi-tools fs-5 me-2" style="color:#ff7f00;"></i><strong>Modelo:</strong> <?= $modeloCarro ?></p>
            <p><i class="bi bi-calendar fs-5 me-2" style="color:#ff7f00;"></i><strong>Ano:</strong> <?= $anoCarro ?></p>
            <p>
                <i class="bi bi-palette fs-5 me-2" style="color:#ff7f00;"></i>
                <strong>Cor:</strong>
                <span style="display:inline-block; width: 30px; height: 20px; background-color: <?= $corCarro ?>; border: 1px solid #333; vertical-align: middle;"></span>
            </p>
            <p><i class="bi bi-card-text fs-5 me-2" style="color:#ff7f00;"></i><strong>Placa:</strong> <?= $placaCarro ?></p>

            <hr>

            <p><i class="bi bi-file-text fs-5 me-2" style="color:#ff7f00;"></i><strong>Descrição:</strong> <?= $descricaoCarro ?></p>

            <hr>

            <p><i class="bi bi-calendar-event fs-5 me-2" style="color:#ff7f00;"></i><strong>Data da Compra:</strong> <?= $dataCompra ?></p>
            <p><i class="bi bi-clock fs-5 me-2" style="color:#ff7f00;"></i><strong>Hora da Compra:</strong> <?= $horaCompra ?></p>

            <p class="fs-4 fw-bold text-success mt-3">
                <i class="bi bi-currency-dollar fs-5 text-success me-2"></i>Valor Pago: R$ <?= $valorCompra ?>
            </p>

            <a href="visualizarPedidos.php" class="btn" style="background-color: #ff7f00; color: white; font-weight: bold; margin-top: 20px;">
                <i class="bi bi-arrow-left-circle me-2"></i> Voltar para Minhas Compras
            </a>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
