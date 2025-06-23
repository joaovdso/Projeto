<?php 
include "header.php";
include "validarSessao.php";
include "conexaoBD.php";

if (!isset($_GET['idCarro']) || empty($_GET['idCarro'])) {
    echo "<div class='alert alert-danger text-center mt-4'>ID do veículo não informado.</div>";
    include "footer.php";
    exit;
}

$idCarro = intval($_GET['idCarro']);

$query = "SELECT * FROM carros WHERE idCarro = $idCarro LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-warning text-center mt-4'>Veículo não encontrado.</div>";
    include "footer.php";
    exit;
}

$carro = mysqli_fetch_assoc($result);

$fotoCarro      = htmlspecialchars($carro['fotoCarro']);
$nomeCarro      = htmlspecialchars($carro['nomeCarro']);
$descricaoCarro = htmlspecialchars($carro['descricaoCarro']);
$marcaCarro     = htmlspecialchars($carro['marcaCarro']);
$modeloCarro    = htmlspecialchars($carro['modeloCarro']);
$anoCarro       = htmlspecialchars($carro['anoCarro']);
$corCarro       = htmlspecialchars($carro['corCarro']);
$placaCarro     = htmlspecialchars($carro['placaCarro']);
$valorCarro     = number_format($carro['valorCarro'], 2, '.', '');
$disponivel     = htmlspecialchars($carro['disponivel']);
?>

<div class="container mt-4 mb-5" style="max-width: 900px;">
    <h2 class="mb-4 text-center" style="color:#ff6b00; font-weight:700;">Editar Veículo</h2>

    <form action="actionEditarProduto.php" method="POST" class="was-validated" enctype="multipart/form-data" id="formVeiculo">
        <input type="hidden" name="idCarro" value="<?= $idCarro ?>">

        <div class="row g-3">

            <!-- Foto -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="file" accept="image/*" class="form-control" id="fotoProduto" name="fotoProduto" onchange="previewImage(event)">
                    <label for="fotoProduto">Foto</label>
                    <div class="invalid-feedback">Envie uma foto do veículo ou mantenha a atual.</div>
                </div>
                <img id="fotoPreview" src="<?= $fotoCarro ?>" alt="Preview da Foto" style="margin-top:10px; max-width:100%; height:auto; border-radius:8px;" />
            </div>

            <!-- Nome -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" required minlength="3" maxlength="50" value="<?= $nomeCarro ?>">
                    <label for="nomeProduto">Nome do Veículo</label>
                </div>
            </div>

            <!-- Descrição -->
            <div class="col-md-6">
                <div class="form-floating">
                    <textarea class="form-control" id="descricaoProduto" name="descricaoProduto" style="height: 100px;" required maxlength="300" oninput="updateCounter()"><?= $descricaoCarro ?></textarea>
                    <label for="descricaoProduto">Descrição do Veículo</label>
                </div>
                <small id="descCounter" class="text-muted">0 / 300 caracteres</small>
            </div>

            <!-- Marca -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="marcaProduto" name="marcaProduto" required minlength="2" maxlength="30" value="<?= $marcaCarro ?>">
                    <label for="marcaProduto">Marca</label>
                </div>
            </div>

            <!-- Modelo -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="modeloProduto" name="modeloProduto" required minlength="2" maxlength="30" value="<?= $modeloCarro ?>">
                    <label for="modeloProduto">Modelo</label>
                </div>
            </div>

            <!-- Ano -->
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="number" min="1900" max="<?= date('Y') + 1 ?>" class="form-control" id="anoProduto" name="anoProduto" required value="<?= $anoCarro ?>">
                    <label for="anoProduto">Ano</label>
                </div>
            </div>

            <!-- Cor -->
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="color" class="form-control form-control-color" id="corProduto" name="corProduto" required value="<?= $corCarro ?>" style="height: 58px;">
                    <label for="corProduto" style="padding-left: 3rem;">Cor</label>
                </div>
            </div>

            <!-- Placa -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="placaProduto" name="placaProduto" required maxlength="8" pattern="[A-Za-z]{3}-[0-9]{4}" title="Formato: ABC-1234" value="<?= $placaCarro ?>">
                    <label for="placaProduto">Placa (Ex: ABC-1234)</label>
                </div>
            </div>

            <!-- Valor -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="valorProduto" name="valorProduto" required pattern="^\d+(\.\d{1,2})?$" value="<?= $valorCarro ?>">
                    <label for="valorProduto">Valor (R$)</label>
                </div>
            </div>

            <!-- Status (Disponível / Esgotado) -->
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="disponivel" name="disponivel" required>
                        <option value="Disponível" <?= $disponivel == 'Disponível' ? 'selected' : '' ?>>Disponível</option>
                        <option value="Esgotado" <?= $disponivel == 'Esgotado' ? 'selected' : '' ?>>Esgotado</option>
                    </select>
                    <label for="disponivel">Status</label>
                </div>
            </div>

        </div>

        <button type="submit" class="btn mt-4 w-100" style="background-color: #ff6b00; color: white; font-weight: 600;">Atualizar Veículo</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => updateCounter());

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('fotoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateCounter() {
        const textarea = document.getElementById('descricaoProduto');
        const counter = document.getElementById('descCounter');
        counter.textContent = `${textarea.value.length} / 300 caracteres`;
    }

    document.getElementById('placaProduto').addEventListener('input', function(e) {
        let val = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        if(val.length > 3) val = val.slice(0,3) + '-' + val.slice(3,7);
        e.target.value = val;
    });

    document.getElementById('valorProduto').addEventListener('input', function(e) {
        let val = e.target.value.replace(/[^\d,\.]/g, '').replace(',', '.');
        const parts = val.split('.');
        if(parts.length > 2) val = parts[0] + '.' + parts.slice(1).join('');
        e.target.value = val;
    });
</script>

<?php include "footer.php"; ?>
