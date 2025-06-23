<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['tipoUsuario'] !== 'administrador') {
    header("Location: index.php");
    exit;
}
include "header.php";
include "conexaoBD.php";

// Consultas resumidas
$totalVeiculos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM carros"))['total'];
$veiculosDisponiveis = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM carros WHERE disponivel = 'Disponível'"))['total'];
$veiculosEsgotados = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM carros WHERE disponivel = 'Esgotado'"))['total'];
$totalUsuarios = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM usuarios"))['total'];
?>

<div class="container my-5">
    <h1 class="text-center fw-bold mb-5" style="color: #ff7f00;">Painel do Administrador</h1>

    <!-- Cards Resumo -->
    <div class="row text-center mb-5">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-car-front-fill fs-1 text-primary"></i>
                    <h5 class="card-title mt-3 fw-bold">Veículos Cadastrados</h5>
                    <p class="fs-4"><?= $totalVeiculos ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                    <h5 class="card-title mt-3 fw-bold">Disponíveis</h5>
                    <p class="fs-4"><?= $veiculosDisponiveis ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-x-circle-fill fs-1 text-danger"></i>
                    <h5 class="card-title mt-3 fw-bold">Esgotados</h5>
                    <p class="fs-4"><?= $veiculosEsgotados ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-people-fill fs-1 text-dark"></i>
                    <h5 class="card-title mt-3 fw-bold">Usuários Cadastrados</h5>
                    <p class="fs-4"><?= $totalUsuarios ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações futuras -->
    <div class="text-center mt-5">
        <a href="formProduto.php" class="btn btn-lg fw-bold text-white" style="background-color: #ff7f00;">
            <i class="bi bi-plus-circle"></i> Adicionar Novo Veículo
        </a>
    </div>
</div>

<?php include "footer.php"; ?>
