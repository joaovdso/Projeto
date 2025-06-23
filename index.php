<?php
session_start();
include "header.php";
?>

<!-- Page Content -->
<div class="container px-4 px-lg-5 mt-5">
    <?php
        include("conexaoBD.php");

        $listarCarros = "SELECT * FROM carros";
        $res = mysqli_query($conn, $listarCarros);
        $totalCarros = mysqli_num_rows($res);

        if ($totalCarros > 0) {
            if (isset($_SESSION['logado']) && $_SESSION['logado'] === true && $_SESSION['tipoUsuario'] === 'admin') {
                $msg = $totalCarros == 1 
                    ? "Há <strong>$totalCarros</strong> carro cadastrado no sistema!"
                    : "Há <strong>$totalCarros</strong> carros cadastrados no sistema!";
                echo "<div class='alert alert-info text-center'>$msg</div>";
            }
        } else {
            echo "<div class='alert alert-warning text-center'>Não há carros cadastrados neste sistema!</div>";
        }
    ?>

    <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-4 justify-content-center">
        <?php
            while($registro = mysqli_fetch_assoc($res)){
                $idCarro        = htmlspecialchars($registro["idCarro"]);
                $fotoCarro      = htmlspecialchars($registro["fotoCarro"]);
                $nomeCarro      = htmlspecialchars($registro["nomeCarro"]);
                $descricaoCarro = htmlspecialchars($registro["descricaoCarro"]);
                $valorCarro     = number_format($registro["valorCarro"], 2, ',', '.');
                $disponivel     = htmlspecialchars($registro["disponivel"]); // capturando status

                $descricaoLimitada = strlen($descricaoCarro) > 60 
                    ? substr($descricaoCarro, 0, 57) . '...'
                    : $descricaoCarro;

                // Aplica grayscale se carro estiver indisponível (exemplo: "Esgotado")
                $imgStyle = ($disponivel === 'Esgotado' || $disponivel === 'Indisponível') ? 'filter: grayscale(100%);' : '';

                echo "
                <div class='col mb-5'>
                    <div class='card h-100'>
                        <!-- Imagem do carro -->
                        <img class='card-img-top' src='$fotoCarro' alt='Foto de $nomeCarro' style='height: 200px; object-fit: cover; $imgStyle' />
                        <!-- Detalhes do carro -->
                        <div class='card-body p-4'>
                            <div class='text-center'>
                                <h5 class='fw-bolder'>$nomeCarro</h5>
                                <p class='text-muted small'>$descricaoLimitada</p>
                                <span class='fs-5 fw-bold'>R$ $valorCarro</span>
                            </div>
                        </div>
                        <!-- Ações do carro -->
                        <div class='card-footer p-4 pt-0 border-top-0 bg-transparent'>
                            <div class='text-center'>
                                <a class='btn btn-outline-dark mt-auto' href='visualizarCarro.php?idCarro=$idCarro'>Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
        ?>
    </div>
</div>

<?php include "footer.php"; ?>
