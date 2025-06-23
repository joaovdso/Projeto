<?php
session_start();
include "header.php";

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: index.php');
    exit();
}

include "conexaoBD.php";

$idUsuario = $_SESSION['idUsuario'];

$msgSucesso = '';
$msgErro = '';

// Se o formulário foi enviado para atualizar dados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editarPerfil'])) {
    // Receber dados e sanitizar
    $nomeUsuario = trim($_POST['nomeUsuario']);
    $dataNascimento = trim($_POST['dataNascimentoUsuario']);
    $cidadeUsuario = trim($_POST['cidadeUsuario']);
    $telefoneUsuario = trim($_POST['telefoneUsuario']);
    $emailUsuario = trim($_POST['emailUsuario']);

    // Validações básicas (pode aumentar conforme necessidade)
    if (empty($nomeUsuario) || empty($dataNascimento) || empty($cidadeUsuario) || empty($telefoneUsuario) || empty($emailUsuario)) {
        $msgErro = "Por favor, preencha todos os campos obrigatórios.";
    } else {
        // Lógica para foto (opcional)
        $fotoUsuario = null;
        if (isset($_FILES['fotoUsuario']) && $_FILES['fotoUsuario']['size'] > 0) {
            $diretorio = "img/";
            $nomeArquivo = basename($_FILES['fotoUsuario']['name']);
            $destino = $diretorio . uniqid() . "_" . $nomeArquivo;
            $ext = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                if (move_uploaded_file($_FILES['fotoUsuario']['tmp_name'], $destino)) {
                    $fotoUsuario = $destino;
                } else {
                    $msgErro = "Erro ao fazer upload da foto.";
                }
            } else {
                $msgErro = "Formato da foto inválido. Use jpg, jpeg, png ou webp.";
            }
        }

        if (empty($msgErro)) {
            // Montar query UPDATE (com ou sem foto)
            if ($fotoUsuario) {
                $sql = "UPDATE usuarios SET nomeUsuario=?, dataNascimentoUsuario=?, cidadeUsuario=?, telefoneUsuario=?, emailUsuario=?, fotoUsuario=? WHERE idUsuario=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssssi", $nomeUsuario, $dataNascimento, $cidadeUsuario, $telefoneUsuario, $emailUsuario, $fotoUsuario, $idUsuario);
            } else {
                $sql = "UPDATE usuarios SET nomeUsuario=?, dataNascimentoUsuario=?, cidadeUsuario=?, telefoneUsuario=?, emailUsuario=? WHERE idUsuario=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssi", $nomeUsuario, $dataNascimento, $cidadeUsuario, $telefoneUsuario, $emailUsuario, $idUsuario);
            }

            if (mysqli_stmt_execute($stmt)) {
                $msgSucesso = "Perfil atualizado com sucesso!";
            } else {
                $msgErro = "Erro ao atualizar perfil. Tente novamente.";
            }
        }
    }
}

// Buscar dados atualizados do usuário
$sql = "SELECT * FROM usuarios WHERE idUsuario = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);

// Últimas 3 compras
$sqlCompras = "
    SELECT compras.idCompra, compras.dataCompra, carros.nomeCarro, carros.fotoCarro 
    FROM compras
    INNER JOIN carros ON compras.idCarro = carros.idCarro
    WHERE compras.idUsuario = ?
    ORDER BY compras.dataCompra DESC
    LIMIT 3
";
$stmtCompras = mysqli_prepare($conn, $sqlCompras);
mysqli_stmt_bind_param($stmtCompras, "i", $idUsuario);
mysqli_stmt_execute($stmtCompras);
$resCompras = mysqli_stmt_get_result($stmtCompras);
?>

<div class="container my-5">
    <div class="row g-4">
        <!-- Perfil do Usuário com formulário -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header text-white fw-bold" style="background-color: #ff7f00;">
                    <i class="bi bi-person-circle me-2"></i>Perfil do Usuário
                </div>
                <div class="card-body">

                    <?php if ($msgErro): ?>
                        <div class="alert alert-danger"><?= $msgErro ?></div>
                    <?php elseif ($msgSucesso): ?>
                        <div class="alert alert-success"><?= $msgSucesso ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <?php if (!empty($usuario['fotoUsuario'])): ?>
                                <img src="<?= htmlspecialchars($usuario['fotoUsuario']) ?>" alt="Foto do usuário" class="img-fluid shadow" style="width: 180px; height: auto;">
                            <?php else: ?>
                                <p class="text-muted">Sem foto de perfil</p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="fotoUsuario" class="form-label">Atualizar Foto (jpg, png, webp)</label>
                            <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario" accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <div class="mb-3">
                            <label for="nomeUsuario" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeUsuario" name="nomeUsuario" value="<?= htmlspecialchars($usuario['nomeUsuario']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="dataNascimentoUsuario" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="dataNascimentoUsuario" name="dataNascimentoUsuario" value="<?= htmlspecialchars($usuario['dataNascimentoUsuario']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="cidadeUsuario" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidadeUsuario" name="cidadeUsuario" value="<?= htmlspecialchars($usuario['cidadeUsuario']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefoneUsuario" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefoneUsuario" name="telefoneUsuario" value="<?= htmlspecialchars($usuario['telefoneUsuario']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="emailUsuario" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" value="<?= htmlspecialchars($usuario['emailUsuario']) ?>" required>
                        </div>

                        <button type="submit" name="editarPerfil" class="btn btn-lg" style="background-color: #ff7f00; color: white;">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Últimas Compras -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header text-white fw-bold" style="background-color: #ff7f00;">
                    <i class="bi bi-cart-fill me-2"></i>Últimas Compras
                </div>
                <div class="card-body">
                    <?php
                    if (mysqli_num_rows($resCompras) > 0) {
                        while ($compra = mysqli_fetch_assoc($resCompras)) {
                            echo "<div class='mb-3 d-flex align-items-center'>";
                            echo "<img src='{$compra['fotoCarro']}' alt='Carro' style='width: 70px; height: 50px; object-fit: cover; border-radius: 6px; margin-right: 10px;'>";
                            echo "<div>";
                            echo "<strong>{$compra['nomeCarro']}</strong><br>";
                            echo "<small class='text-muted'>Comprado em " . date('d/m/Y', strtotime($compra['dataCompra'])) . "</small>";
                            echo "</div></div>";
                        }
                        echo "<div class='text-center mt-3'>";
                        echo "<a href='visualizarPedidos.php' class='btn btn-sm' style='background-color: #ff7f00; color: white;'>Ver todas</a>";
                        echo "</div>";
                    } else {
                        echo "<p class='text-muted text-center'>Nenhuma compra registrada.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
mysqli_close($conn);
?>
