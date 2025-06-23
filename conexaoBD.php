<?php

    $host     = "localhost"; //Servidor de BD
    $user     = "root"; //Usuário do BD
    $senhaBD  = "root"; //Senha do BD
    $database = "jcar"; //Nome do BD

    //Função do PHP para estabelecer conexão com o BD
    $conn = mysqli_connect("localhost", "root", "root", "jcar");

    //Se NÃO 
    if(!$conn){
        echo "<p>Erro ao tentar conectar à Base de Dados <strong>$database</strong>!</p>";
    }

?>

