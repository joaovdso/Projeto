<?php include("header.php"); ?>

<div class="container my-5">
    <h1 class="mb-4 fw-bold" style="color: #ff7f00;">Minhas Compras</h1>

    <?php
    session_start(); // Inicia a sessão

    // Verifica se usuário está logado e é cliente
    if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
        $idUsuario   = $_SESSION['idUsuario'];
        $tipoUsuario = $_SESSION['tipoUsuario'];

        if ($tipoUsuario == 'cliente') {
            include("conexaoBD.php");

            // Query para listar os pedidos do usuário com os dados dos carros
            $listarPedidos = "
                SELECT
                    compras.idCompra,
                    compras.dataCompra,
                    compras.horaCompra,
                    compras.valorCompra,
                    carros.nomeCarro,
                    carros.descricaoCarro,
                    carros.fotoCarro
                FROM compras
                INNER JOIN carros ON compras.idCarro = carros.idCarro
                WHERE compras.idUsuario = $idUsuario
                ORDER BY compras.dataCompra DESC, compras.horaCompra DESC
            ";

            $res = mysqli_query($conn, $listarPedidos) or die("Erro ao tentar listar pedidos");
            $totalPedidos = mysqli_num_rows($res);

            echo "<div class='alert alert-info text-center'>
                    Você possui <strong>$totalPedidos</strong> pedido(s) registrado(s)!
                  </div>";

            if ($totalPedidos > 0) {
                echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4'>";

                while ($registro = mysqli_fetch_assoc($res)) {
                    $idCompra    = $registro['idCompra'];
                    $fotoCarro   = htmlspecialchars($registro['fotoCarro']);
                    $nomeCarro   = htmlspecialchars($registro['nomeCarro']);
                    $dataCompra  = $registro['dataCompra'];
                    $horaCompra  = $registro['horaCompra'];
                    $valorCompra = number_format($registro['valorCompra'], 2, ',', '.');

                    $dataFormatada = date('d/m/Y', strtotime($dataCompra));
                    $horaFormatada = date('H:i', strtotime($horaCompra));

                    echo "
                    <div class='col'>
                        <div class='card h-100 shadow-sm'>
                            <img src='$fotoCarro' class='card-img-top' alt='Foto do carro $nomeCarro' style='height: 180px; object-fit: cover;'>
                            <div class='card-body d-flex flex-column'>
                                <h5 class='card-title'>$nomeCarro</h5>
                                <p class='card-text text-truncate' title='" . htmlspecialchars($registro['descricaoCarro']) . "'>{$registro['descricaoCarro']}</p>
                                <p class='mb-1'><strong>Data:</strong> $dataFormatada</p>
                                <p class='mb-1'><strong>Hora:</strong> $horaFormatada</p>
                                <p class='mb-3 fw-bold text-success'>R$ $valorCompra</p>
                                <a href='detalhesCompra.php?idCompra=$idCompra' class='btn btn-sm mt-auto' style='background-color: #ff7f00; color: white;'>Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                    ";
                }

                echo "</div>";
            } else {
                echo "<div class='alert alert-warning text-center'>Você ainda não possui pedidos.</div>";
            }

            mysqli_close($conn);
        } else {
            header('Location: index.php');
            exit();
        }
    } else {
        header('Location: index.php');
        exit();
    }
    ?>
</div>

<?php include("footer.php"); ?>
