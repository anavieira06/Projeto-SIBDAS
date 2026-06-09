<?php
$bodyClass = 'bg-login';
include '../private/includes/header.php';
?>

        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-sm-8 col-10">
                    <!-- Card e restante conteúdo -->
                    <div class="card p-4" style="min-height: 500px;">
                        <div class="d-flex align-items-center justify-content-center my-4">
                            <!-- Imagem da empresa -->
                            <img src="/ProjetoSIBDAS/Frontend/assets/img/Imagem 3.jpeg" width="200">
                        </div>

                        <div class="row">
                            <div class="col">
                                <!-- Formulário -->
                                <form action="../private/index.php" method="post">
                                    <div class="mb-3">
                                        <!-- Utilizador -->
                                        <label for="email" class="form-label">Utilizador</label>
                                        <input type="email" name="text_username" id="" class="form-control" placeholder="Insira o seu email">
                                    </div>

                                    <div class="mb-3">
                                        <!-- Password -->
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="text_password" id="" class="form-control" placeholder="Insira a sua password">
                                    </div>

                                    <div class="mb-3 text-center">
                                        <!-- Submit -->
                                        <button type="submit" class="btn px-4" style="background-color: #945880; color:#fff">
                                            Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i>
                                        </button>
                                    </div>

                                    <div class="text-center mt-5">
                                        <a href="/ProjetoSIBDAS/Frontend/public/index.php"
                                        class="btn btn-outline-secondary px-4">
                                            <i class="fa-solid fa-house me-2"></i> Voltar ao início
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include '../private/includes/footer.php'; ?>