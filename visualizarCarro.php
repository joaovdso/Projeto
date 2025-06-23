<?php
session_start();
include "header.php";
?>

<div class="container my-5">
    <?php
    if (isset($_GET['idCarro']) && is_numeric($_GET['idCarro'])) {
        $idCarro = (int)$_GET['idCarro'];
        include("conexaoBD.php");

        $stmt = mysqli_prepare($conn, "SELECT * FROM carros WHERE idCarro = ?");
        mysqli_stmt_bind_param($stmt, 'i', $idCarro);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if ($res && mysqli_num_rows($res) > 0) {
            $registro = mysqli_fetch_assoc($res);

            $fotoCarro      = htmlspecialchars($registro["fotoCarro"]);
            $nomeCarro      = htmlspecialchars($registro["nomeCarro"]);
            $descricaoCarro = htmlspecialchars($registro["descricaoCarro"]);
            $marcaCarro     = htmlspecialchars($registro["marcaCarro"]);
            $modeloCarro    = htmlspecialchars($registro["modeloCarro"]);
            $anoCarro       = (int)$registro["anoCarro"];
            $corCarro       = htmlspecialchars($registro["corCarro"]);
            $placaCarro     = htmlspecialchars($registro["placaCarro"]);
            $valorCarro     = number_format($registro["valorCarro"], 2, ',', '.');

            // Limpa espaços e coloca em minúsculo para comparação segura
            $disponivelRaw = $registro["disponivel"];
            $disponivel = mb_strtolower(trim($disponivelRaw), 'UTF-8');
            ?>

            <div class="row justify-content-center align-items-center">
                <!-- Coluna imagem -->
                <div class="col-md-6 col-lg-5 mb-4">
                    <div id="carroCarousel" class="carousel slide shadow rounded" data-bs-ride="carousel" aria-label="Imagens do carro <?php echo $nomeCarro; ?>">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Imagem 1"></button>
                            <button type="button" data-bs-target="#carroCarousel" data-bs-slide-to="1" aria-label="Imagem 2"></button>
                            <button type="button" data-bs-target="#carroCarousel" data-bs-slide-to="2" aria-label="Imagem 3"></button>
                        </div>

                        <div class="carousel-inner">
                            <?php
                            for ($i = 0; $i < 3; $i++) {
                                $active = $i === 0 ? "active" : "";
                                $filter = $disponivel === 'esgotado' ? "filter: grayscale(100%);" : "";
                                echo "<div class='carousel-item $active'>";
                                echo "<img src='$fotoCarro' class='d-block w-100 rounded' alt='Imagem $i do carro $nomeCarro' style='$filter'>";
                                echo "</div>";
                            }
                            ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carroCarousel" data-bs-slide="prev" aria-label="Imagem anterior">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carroCarousel" data-bs-slide="next" aria-label="Próxima imagem">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>

                <!-- Coluna conteúdo -->
                <div class="col-md-6 col-lg-5 text-center">
                    <div class="card shadow p-4">
                        <h2 class="fw-bold mb-3"><?php echo $nomeCarro; ?></h2>

                        <p class="mb-3 text-muted" style="white-space: pre-line;"><?php echo $descricaoCarro; ?></p>

                        <ul class="list-group text-start mb-4">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-building me-2" style="color:#ff7f00;"></i>
                                <strong>Marca:</strong> <?php echo $marcaCarro; ?>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-gear-wide-connected me-2" style="color:#ff7f00;"></i>
                                <strong>Modelo:</strong> <?php echo $modeloCarro; ?>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-calendar3 me-2" style="color:#ff7f00;"></i>
                                <strong>Ano:</strong> <?php echo $anoCarro; ?>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-palette me-2" style="color:#ff7f00;"></i>
                                <strong>Cor:</strong> 
                                <div style="width: 30px; height: 20px; background-color: <?php echo $corCarro; ?>; margin-left: 10px; border: 1px solid #000;"></div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-credit-card me-2" style="color:#ff7f00;"></i>
                                <strong>Placa:</strong> <?php echo $placaCarro; ?>
                            </li>
                        </ul>

                        <h4 class="text-success mb-4">R$ <?php echo $valorCarro; ?></h4>

                        <div>
                            <?php
                            if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
                                if ($_SESSION['tipoUsuario'] === 'cliente') {
                                    if ($disponivel === 'disponivel') {
                                        ?>
                                        <form action="efetuarCompra.php" method="POST" class="d-inline-block">
                                            <input type="hidden" name="idCarro" value="<?php echo $idCarro; ?>">
                                            <input type="hidden" name="fotoCarro" value="<?php echo $fotoCarro; ?>">
                                            <input type="hidden" name="nomeCarro" value="<?php echo $nomeCarro; ?>">
                                            <input type="hidden" name="valorCarro" value="<?php echo $valorCarro; ?>">
                                            <button type="submit" class="btn btn-lg" style="background-color: #ff6b00; color: white; font-weight: 600; border: none;">
                                                <i class="bi bi-bag-plus"></i> Efetuar Compra
                                            </button>
                                        </form>
                                        <?php
                                    } else {
                                        echo "<div class='alert alert-secondary'>Carro esgotado! <i class='bi bi-emoji-frown'></i></div>";
                                    }
                                } else {
                                    ?>
                                    <form action="formEditarCarro.php?idCarro=<?php echo $idCarro; ?>" method="POST" class="d-inline-block">
                                        <input type="hidden" name="idCarro" value="<?php echo $idCarro; ?>">
                                        <button type="submit" class="btn btn-lg" style="background-color: #ff6b00; color: white; font-weight: 600; border: none;">
                                            <i class="bi bi-pencil-square"></i> Editar Veículo
                                        </button>
                                    </form>
                                    <?php
                                }
                            } else {
                                echo '<div class="alert text-white" style="background-color: #ff7f00;">';
                                echo '<a href="formLogin.php" class="alert-link text-white fw-bold">';
                                echo 'Acesse o sistema para poder comprar este carro! <i class="bi bi-person"></i>';
                                echo '</a>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        } else {
            echo "<div class='alert alert-danger text-center'>Carro não localizado!</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger text-center'>ID do carro inválido!</div>";
    }
    ?>
</div>

<?php include "footer.php"; ?>
