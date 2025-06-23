<?php include "header.php" ?>

<div class="container mt-4 mb-5" style="max-width: 700px;">
    <h2 class="mb-4 text-center" style="color:#ff6b00; font-weight:700;">Cadastro de Usuário - JCar</h2>

    <form action="actionUsuario.php?pagina=formUsuario" method="POST" class="was-validated" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="fotoUsuario" class="form-label" style="color:#ff6b00;">Foto</label>
                <input type="file" class="form-control" id="fotoUsuario" name="fotoUsuario" required style="color:black;">
                <div class="invalid-feedback">Envie uma foto.</div>
            </div>

            <div class="col-md-6">
                <label for="nomeUsuario" class="form-label" style="color:#ff6b00;">Nome Completo</label>
                <input type="text" class="form-control" id="nomeUsuario" name="nomeUsuario" required style="color:black;">
                <div class="invalid-feedback">Informe seu nome completo.</div>
            </div>

            <div class="col-md-6">
                <label for="dataNascimentoUsuario" class="form-label" style="color:#ff6b00;">Data de Nascimento</label>
                <input type="date" class="form-control" id="dataNascimentoUsuario" name="dataNascimentoUsuario" required style="color:black;">
                <div class="invalid-feedback">Informe sua data de nascimento.</div>
            </div>

            <div class="col-md-6">
                <label for="cidadeUsuario" class="form-label" style="color:#ff6b00;">Cidade</label>
                <select class="form-select" id="cidadeUsuario" name="cidadeUsuario" required style="color:black;">
                    <option value="" disabled>Selecione</option>
                    <option value="curiuva">Curiúva</option>
                    <option value="imbau">Imbaú</option>
                    <option value="ortigueira">Ortigueira</option>
                    <option value="reserva">Reserva</option>
                    <option value="telemacoBorba" selected>Telêmaco Borba</option>
                    <option value="tibagi">Tibagi</option>
                </select>
                <div class="invalid-feedback">Selecione sua cidade.</div>
            </div>

            <div class="col-md-6">
                <label for="telefoneUsuario" class="form-label" style="color:#ff6b00;">Telefone</label>
                <input type="text" class="form-control" id="telefoneUsuario" name="telefoneUsuario" required style="color:black;">
                <div class="invalid-feedback">Informe seu telefone.</div>
            </div>

            <div class="col-md-6">
                <label for="emailUsuario" class="form-label" style="color:#ff6b00;">Email</label>
                <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" required style="color:black;">
                <div class="invalid-feedback">Informe um email válido.</div>
            </div>

            <div class="col-md-6">
                <label for="senhaUsuario" class="form-label" style="color:#ff6b00;">Senha</label>
                <input type="password" class="form-control" id="senhaUsuario" name="senhaUsuario" required style="color:black;">
                <div class="invalid-feedback">Crie uma senha.</div>
            </div>

            <div class="col-md-6">
                <label for="confirmarSenhaUsuario" class="form-label" style="color:#ff6b00;">Confirme a Senha</label>
                <input type="password" class="form-control" id="confirmarSenhaUsuario" name="confirmarSenhaUsuario" required style="color:black;">
                <div class="invalid-feedback">Confirme sua senha.</div>
            </div>
        </div>

        <button type="submit" class="btn mt-4 w-100" style="background-color: #ff6b00; color: white; font-weight: 600; border: none;"" style="font-weight: 700;">
            Cadastrar Conta <i class="bi bi-person-plus-fill"></i> 
        </button>
    </form>
</div>

<?php include "footer.php" ?>
