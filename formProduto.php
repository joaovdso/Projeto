<?php include "header.php" ?>
<?php include "validarSessao.php" ?>

<div class="container mt-4 mb-5" style="max-width: 900px;">
    <h2 class="mb-4 text-center" style="color:#ff6b00; font-weight:700;">Cadastrar Veículo</h2>

    <form action="actionCarro.php" method="POST" class="was-validated" enctype="multipart/form-data" id="formVeiculo">
        <div class="row g-3">

            <!-- Foto com preview -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="file" accept="image/*" class="form-control" id="fotoCarro" name="fotoCarro" required onchange="previewImage(event)">
                    <label for="fotoCarro">Foto</label>
                    <div class="invalid-feedback">Envie uma foto do veículo.</div>
                </div>
                <img id="fotoPreview" src="#" alt="Preview da Foto" style="display:none; margin-top:10px; max-width:100%; height:auto; border-radius:8px;"/>
            </div>

            <!-- Nome -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="nomeCarro" placeholder="Nome" name="nomeCarro" required minlength="3" maxlength="50">
                    <label for="nomeCarro">Nome do Veículo</label>
                    <div class="invalid-feedback">Informe o nome do veículo (3 a 50 caracteres).</div>
                </div>
            </div>

            <!-- Descrição com contador -->
            <div class="col-md-6">
                <div class="form-floating">
                    <textarea class="form-control" id="descricaoCarro" placeholder="Descrição" name="descricaoCarro" style="height: 100px;" required maxlength="300" oninput="updateCounter()"></textarea>
                    <label for="descricaoCarro">Descrição do Veículo</label>
                    <div class="invalid-feedback">Informe uma descrição (até 300 caracteres).</div>
                </div>
                <small id="descCounter" class="text-muted">0 / 300 caracteres</small>
            </div>

            <!-- Marca -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="marcaCarro" placeholder="Marca" name="marcaCarro" required minlength="2" maxlength="30">
                    <label for="marcaCarro">Marca</label>
                    <div class="invalid-feedback">Informe a marca do veículo.</div>
                </div>
            </div>

            <!-- Modelo -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="modeloCarro" placeholder="Modelo" name="modeloCarro" required minlength="2" maxlength="30">
                    <label for="modeloCarro">Modelo</label>
                    <div class="invalid-feedback">Informe o modelo do veículo.</div>
                </div>
            </div>

            <!-- Ano -->
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="number" min="1900" max="<?php echo date('Y') + 1; ?>" class="form-control" id="anoCarro" placeholder="Ano" name="anoCarro" required>
                    <label for="anoCarro">Ano</label>
                    <div class="invalid-feedback">Informe o ano (entre 1900 e <?php echo date('Y') + 1; ?>).</div>
                </div>
            </div>

            <!-- Cor - seletor de cor -->
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="color" class="form-control form-control-color" id="corCarro" name="corCarro" title="Escolha a cor" required value="#ff6b00" style="height: 58px;">
                    <label for="corCarro" style="padding-left: 3rem;">Cor</label>
                    <div class="invalid-feedback">Escolha a cor do veículo.</div>
                </div>
            </div>

            <!-- Placa com máscara -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="placaCarro" placeholder="Placa" name="placaCarro" required maxlength="8" pattern="[A-Za-z]{3}-[0-9]{4}" title="Formato esperado: ABC-1234">
                    <label for="placaCarro">Placa (Ex: ABC-1234)</label>
                    <div class="invalid-feedback">Informe a placa no formato ABC-1234.</div>
                </div>
            </div>

            <!-- Valor com máscara -->
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="valorCarro" placeholder="Valor" name="valorCarro" required pattern="^\d+(\.\d{1,2})?$" title="Informe o valor com até 2 casas decimais">
                    <label for="valorCarro">Valor (R$)</label>
                    <div class="invalid-feedback">Informe o valor do veículo (ex: 50000.00).</div>
                </div>
            </div>

        </div>

        <button type="submit" class="btn mt-4 w-100" style="background-color: #ff6b00; color: white; font-weight: 600; border: none;">
            Cadastrar Veículo
        </button>
    </form>
</div>

<script>
    // Preview da imagem selecionada
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('fotoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    // Contador de caracteres da descrição
    function updateCounter() {
        const textarea = document.getElementById('descricaoCarro');
        const counter = document.getElementById('descCounter');
        counter.textContent = `${textarea.value.length} / 300 caracteres`;
    }

    // Máscara simples para placa ABC-1234 (maiúsculo e hífen automático)
    document.getElementById('placaCarro').addEventListener('input', function(e) {
        let val = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        if(val.length > 3) {
            val = val.slice(0,3) + '-' + val.slice(3,7);
        }
        e.target.value = val;
    });

    // Máscara para valor monetário
    document.getElementById('valorCarro').addEventListener('input', function(e) {
        let val = e.target.value.replace(/[^\d,\.]/g, '');
        val = val.replace(',', '.');
        const parts = val.split('.');
        if(parts.length > 2) {
            val = parts[0] + '.' + parts.slice(1).join('');
        }
        e.target.value = val;
    });
</script>

<?php include "footer.php" ?>
