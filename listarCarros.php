<?php
session_start();
include("includes/conexao.php");

$sql = "SELECT * FROM carros";
$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Carros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #111; color: white;">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="paginaInicial.php">VendaCarros</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <span class="nav-link">Bem-vindo, <?php echo $_SESSION['nome']; ?>!</span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Catálogo de Carros</h2>

    <div class="row">
        <?php while($carro = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="uploads/<?php echo $carro['imagem']; ?>" class="card-img-top" alt="Imagem do carro">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $carro['marca']." ".$carro['modelo']; ?></h5>
                        <p class="card-text">
                            Ano: <?php echo $carro['ano']; ?><br>
                            <?php echo $carro['descricao']; ?>
                        </p>
                        <h5>R$ <?php echo number_format($carro['preco'], 2, ',', '.'); ?></h5>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
