<?php
include("includes/conexao.php");

// Recebe os dados
$nome = $_POST['nomeUsuario'];
$email = $_POST['emailUsuario'];
$senha = $_POST['senhaUsuario'];
$confirmarSenha = $_POST['confirmarSenha'];
$dataNasc = $_POST['dataNasc'];

// Verifica se as senhas são iguais
if($senha != $confirmarSenha){
    echo "<script>alert('As senhas não conferem!'); history.back();</script>";
    exit;
}

// Criptografar senha
$senhaCriptografada = hash('sha256', $senha);

// Verifica se já existe usuário com esse email
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = mysqli_query($conexao, $sql);

if(mysqli_num_rows($result) > 0){
    echo "<script>alert('Email já cadastrado!'); history.back();</script>";
    exit;
}

// Inserir no banco
$insert = "INSERT INTO usuarios (nome, email, senha, data_nascimento) 
           VALUES ('$nome', '$email', '$senhaCriptografada', '$dataNasc')";

if(mysqli_query($conexao, $insert)){
    echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='formLogin.php';</script>";
} else {
    echo "Erro: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
