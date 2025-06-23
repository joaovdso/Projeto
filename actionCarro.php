<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Redireciona se não for POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formCarro.php");
    exit();
}

include "header.php";
echo "<div class='container mt-3 mb-3'>";

$erroPreenchimento = false;

// Função para sanitizar
function testar_entrada($dado) {
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}

// Captura e sanitiza os campos
$nomeCarro      = empty($_POST["nomeCarro"]) ? null : testar_entrada($_POST["nomeCarro"]);
$descricaoCarro = empty($_POST["descricaoCarro"]) ? null : testar_entrada($_POST["descricaoCarro"]);
$marcaCarro     = empty($_POST["marcaCarro"]) ? null : testar_entrada($_POST["marcaCarro"]);
$modeloCarro    = empty($_POST["modeloCarro"]) ? null : testar_entrada($_POST["modeloCarro"]);
$anoCarro       = empty($_POST["anoCarro"]) ? null : intval($_POST["anoCarro"]);
$corCarro       = empty($_POST["corCarro"]) ? null : testar_entrada($_POST["corCarro"]);
$placaCarro     = empty($_POST["placaCarro"]) ? null : testar_entrada($_POST["placaCarro"]);
$valorCarro     = empty($_POST["valorCarro"]) ? null : floatval(str_replace(',', '.', $_POST["valorCarro"]));

// Validações
if (!$nomeCarro) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
    $erroPreenchimento = true;
}
if (!$descricaoCarro) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
    $erroPreenchimento = true;
}
if (!$marcaCarro) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>MARCA</strong> é obrigatório!</div>";
    $erroPreenchimento = true;
}
if (!$modeloCarro) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>MODELO</strong> é obrigatório!</div>";
    $erroPreenchimento = true;
}
if (!$anoCarro || $anoCarro < 1900 || $anoCarro > intval(date('Y')) + 1) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>ANO</strong> é obrigatório e deve ser válido!</div>";
    $erroPreenchimento = true;
}
if (!$corCarro || !preg_match('/^#[a-fA-F0-9]{6}$/', $corCarro)) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>COR</strong> é obrigatório e deve ser hexadecimal (#RRGGBB)!</div>";
    $erroPreenchimento = true;
}
if (!$placaCarro || !preg_match('/^[A-Z]{3}-[0-9]{4}$/', strtoupper($placaCarro))) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>PLACA</strong> deve estar no formato ABC-1234!</div>";
    $erroPreenchimento = true;
}
if (!$valorCarro || $valorCarro <= 0) {
    echo "<div class='alert alert-warning text-center'>O campo <strong>VALOR</strong> deve ser positivo!</div>";
    $erroPreenchimento = true;
}

// Upload de imagem
$diretorio = "img/";
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0755, true);
}

$erroUpload = false;
$caminhoCompleto = '';

if (isset($_FILES['fotoCarro']) && $_FILES['fotoCarro']['size'] > 0) {
    $extensao = strtolower(pathinfo($_FILES["fotoCarro"]["name"], PATHINFO_EXTENSION));
    $tiposPermitidos = ["jpg", "jpeg", "png", "webp"];

    if ($_FILES['fotoCarro']['size'] > 5000000) {
        echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> não pode ter mais de 5MB!</div>";
        $erroUpload = true;
    }
    if (!in_array($extensao, $tiposPermitidos)) {
        echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve ser JPG, JPEG, PNG ou WEBP!</div>";
        $erroUpload = true;
    }

    if (!$erroUpload) {
        $novoNome = uniqid("carro_") . "." . $extensao;
        $caminhoCompleto = $diretorio . $novoNome;

        if (!move_uploaded_file($_FILES['fotoCarro']['tmp_name'], $caminhoCompleto)) {
            echo "<div class='alert alert-warning text-center'>Erro ao mover a <strong>FOTO</strong> para o diretório!</div>";
            $erroUpload = true;
        }
    }
} else {
    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> é obrigatória!</div>";
    $erroUpload = true;
}

// Inserção no banco
if (!$erroPreenchimento && !$erroUpload) {
    include "conexaoBD.php";

    if (!$conn) {
        die("<div class='alert alert-danger text-center'>Erro na conexão: " . mysqli_connect_error() . "</div>");
    }

    $nomeCarro      = mysqli_real_escape_string($conn, $nomeCarro);
    $descricaoCarro = mysqli_real_escape_string($conn, $descricaoCarro);
    $marcaCarro     = mysqli_real_escape_string($conn, $marcaCarro);
    $modeloCarro    = mysqli_real_escape_string($conn, $modeloCarro);
    $corCarro       = mysqli_real_escape_string($conn, $corCarro);
    $placaCarro     = mysqli_real_escape_string($conn, strtoupper($placaCarro));

    $sql = "INSERT INTO carros (
                fotoCarro, nomeCarro, descricaoCarro, marcaCarro, modeloCarro,
                anoCarro, corCarro, placaCarro, valorCarro, disponivel
            ) VALUES (
                '$caminhoCompleto', '$nomeCarro', '$descricaoCarro', '$marcaCarro', '$modeloCarro',
                $anoCarro, '$corCarro', '$placaCarro', $valorCarro, 'disponivel'
            )";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success text-center'>Carro cadastrado com sucesso!</div>";
        echo "<div class='container mt-3'>
                <div class='mt-3 text-center'>
                    <img src='$caminhoCompleto' style='width:150px' title='Foto de $nomeCarro' alt='Foto do carro'>
                </div>
                <div class='table-responsive'>
                    <table class='table'>
                        <tr><th>NOME</th><td>$nomeCarro</td></tr>
                        <tr><th>DESCRIÇÃO</th><td>$descricaoCarro</td></tr>
                        <tr><th>MARCA</th><td>$marcaCarro</td></tr>
                        <tr><th>MODELO</th><td>$modeloCarro</td></tr>
                        <tr><th>ANO</th><td>$anoCarro</td></tr>
                        <tr><th>COR</th><td><div style='width:30px; height:30px; background-color:$corCarro; border:1px solid #000;'></div></td></tr>
                        <tr><th>PLACA</th><td>$placaCarro</td></tr>
                        <tr><th>VALOR</th><td>R$ " . number_format($valorCarro, 2, ',', '.') . "</td></tr>
                        <tr><th>DISPONÍVEL</th><td>Sim</td></tr>
                    </table>
                </div>
              </div>";
        mysqli_close($conn);
    } else {
        echo "<div class='alert alert-danger text-center'>Erro ao inserir dados: " . mysqli_error($conn) . "</div>";
    }
}

echo "</div>";
include "footer.php";
?>
