<?php include "header.php" ?>

<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">

    <?php
        if(isset($_GET['erroLogin'])){
            $erroLogin = $_GET['erroLogin'];

            if($erroLogin == 'dadosInvalidos'){
                echo "<div class='alert alert-warning text-center w-100' role='alert'><strong>USUÁRIO ou SENHA</strong> inválidos!</div>";
            }
            if($erroLogin == 'naoLogado'){
                echo "<div class='alert alert-warning text-center w-100' role='alert'><strong>USUÁRIO</strong> não logado!</div>";
            }
            if($erroLogin == 'acessoProibido'){
                header('location:index.php?pagina=index');
            }
        }
    ?>

    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px; background-color: #fff;">
        <h2 class="mb-4 fw-bold" style="color:rgb(255, 102, 0); text-align: center;">Login JCar</h2>
        <form action="actionLogin.php" method="POST" class="needs-validation" novalidate>
            <div class="form-floating mb-3">
                <input 
                    type="email" 
                    class="form-control" 
                    id="emailUsuario" 
                    placeholder="Digite seu email" 
                    name="emailUsuario" 
                    required
                >
                <label for="emailUsuario">Email</label>
                <div class="invalid-feedback">
                    Por favor, insira um email válido.
                </div>
            </div>
            <div class="form-floating mb-4">
                <input 
                    type="password" 
                    class="form-control" 
                    id="senhaUsuario" 
                    placeholder="Digite sua senha" 
                    name="senhaUsuario" 
                    required
                >
                <label for="senhaUsuario">Senha</label>
                <div class="invalid-feedback">
                    Por favor, insira sua senha.
                </div>
            </div>

            <button type="submit" class="btn" style="background-color: #ff6600; color: #fff; font-weight: 700; width: 100%;">
                <i class="bi bi-person-fill"></i> Entrar
            </button>
        </form>
    </div>

    <p class="mt-4" style="color: #666;">
        Ainda não possui cadastro? 
        <a href="formUsuario.php" title="Cadastrar-se" style="color: #ff6600; font-weight: 600; text-decoration: none;">Clique aqui!</a> <i class="bi bi-emoji-smile" style="color: #ff6600;"></i>
    </p>

</div>

<?php include "footer.php" ?>
