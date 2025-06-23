<?php include ("header.php") ?>

<div class='container mt-3 mb-3'>

    <?php

        session_start(); //Inicia sessão

        //Verifica se há sessão iniciada
        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){

            if(isset($_POST['idCarro'])){

                $idUsuario   = $_SESSION['idUsuario']; //Captura o id do usuário logado (pela sessão)
                $idCarro     = (int)$_POST['idCarro'];
                $fotoCarro   = $_POST['fotoCarro'];
                $nomeCarro   = $_POST['nomeCarro'];
                // Para evitar problemas com vírgula no valor, substituímos vírgula por ponto
                $valorCompra = floatval(str_replace(',', '.', str_replace('.', '', $_POST['valorCarro'])));
                $dataCompra  = date('Y-m-d'); //Captura a data atual
                $horaCompra  = date('H:i:s'); //Captura a hora atual

                //Incluir o arquivo de conexão com o banco de dados
                include("conexaoBD.php");

                //Query para inserir a compra na tabela Compras
                $efetuarCompra = "INSERT INTO compras (idUsuario, idCarro, dataCompra, horaCompra, valorCompra) VALUES($idUsuario, $idCarro, '$dataCompra', '$horaCompra', $valorCompra)";
                //Atualiza status do carro para 'Esgotado'
                $atualizarStatusCarro = "UPDATE carros SET disponivel = 'Esgotado' WHERE idCarro = $idCarro";

                if(mysqli_query($conn, $efetuarCompra)){
                    if(mysqli_query($conn, $atualizarStatusCarro)){
                        echo "
                            <div class='alert alert-success text-center'>
                                Você comprou $nomeCarro!
                                <i class='bi bi-emoji-smile'></i>
                            </div>
                        ";
                    }
                    else{
                        echo "
                            <div class='alert alert-danger text-center'>
                                Erro ao tentar atualizar o status do carro!
                                <i class='bi bi-emoji-frown'></i>
                            </div>
                        ";
                    }
                }
                else{
                    echo "
                        <div class='alert alert-danger text-center'>
                            Erro ao tentar efetuar a compra!
                            <i class='bi bi-emoji-frown'></i>
                        </div>
                    ";
                }

                mysqli_close($conn);

            }
            else{
                header('location:index.php');
                exit();
            }
        }
        else{
            header('location:index.php');
            exit();
        }

    ?>

</div>

<?php include ("footer.php") ?>
