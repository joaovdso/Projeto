<!DOCTYPE html>
<html lang="pt-br">
<?php date_default_timezone_set('America/Sao_Paulo'); ?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JCar - Sistema</title>

    <!-- CSS principal -->
    <link href="css/styles.css" rel="stylesheet" />

    <!-- Bootstrap ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#telefoneUsuario").mask("(00) 00000-0000");
        });
    </script>
</head>
<body class="d-flex flex-column min-vh-100">

<?php
    error_reporting(0);
    session_start();

    if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
        $idUsuario    = $_SESSION['idUsuario'];
        $tipoUsuario  = $_SESSION['tipoUsuario'];
        $nomeUsuario  = $_SESSION['nomeUsuario'];
        $emailUsuario = $_SESSION['emailUsuario'];

        $nomeCompleto = explode(' ', $nomeUsuario);
        $primeiroNome = $nomeCompleto[0];
    }
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg" style="background-color: #ff7f00;">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand fw-bold text-white" href="index.php">
            <i class="bi bi-car-front-fill"></i> JCar
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="index.php">
                        <i class="bi bi-house-door-fill"></i> Início
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white fw-bold" href="sobreNos.php">
                        <i class="bi bi-info-circle-fill"></i> Sobre Nós
                    </a>
                </li>

                <?php if ($tipoUsuario == 'administrador'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="painelAdmin.php">
                            <i class="bi bi-speedometer2"></i> Painel do Administrador
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="formProduto.php">
                            <i class="bi bi-plus-circle-fill"></i> Adicionar Veículo
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($tipoUsuario == 'cliente'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="visualizarPedidos.php">
                            <i class="bi bi-cart-check-fill"></i> Minhas Compras
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="perfilUsuario.php">
                            <i class="bi bi-person-badge-fill"></i> Meu Perfil
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                <span class="navbar-text text-white me-3">
                    <i class="bi bi-person-circle"></i> Olá, <strong><?= $primeiroNome ?></strong>
                </span>
                <a href="logout.php" class="btn btn-light fw-bold">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            <?php else: ?>
                <a class="btn btn-light fw-bold" href="formLogin.php">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            <?php endif; ?>

            <a href="index.php" class="ms-3">
                <img src="img/generico_logo.png" alt="Logotipo JCar" style="width: 60px;">
            </a>
        </div>
    </div>
</nav>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
