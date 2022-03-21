<?php
session_start();
require_once '../../php/login.php';
$user = new Users();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesse o CPP</title>
    <link rel="stylesheet" href="../../style/header.css">
    <link rel="stylesheet" href="../../style/footer.css">
    <link rel="stylesheet" href="../../style/login.css">
    <link rel="stylesheet" href="../../style/erros.css">
</head>
<body>
    <!-- header -->

    <?php include '../../php/header.php'; ?>

    <!-- login -->

    <main class="caixa-pai">
        <div class="caixa">
            <div class="conteudo">
                <div class="login">
                    <h1>
                        Login
                    </h1>
                </div>
                <div class="parametros">
                   <form method="POST">
                        <input type="email" placeholder="E-mail" name="email">
                        <input type="password" placeholder="Senha" name="password" id="password">
                        <div class="check">
                            <input type="checkbox" id="mostrar-senha" onclick="mostrar_senha()">
                            <label for="mostrar-senha">Mostrar/Esconder senha</label>
                        </div>
                        <input type="submit" value="Login">
                    </form>
                    <?php
                        if(isset($_POST['email'])) {
                            $email = addslashes($_POST['email']);
                            $password = addslashes($_POST['password']);
                            if(!empty($email) && !empty($password)){
                                $user->connect("login", "localhost", "root", "");
                                if($user->msgERRO ==  ""){
                                    if($user->log($email, $password)){
                                        header("location: ../cpp/cpp.php");
                                    }else{
                                        ?>
                                            <div class="errado">
                                                <?php
                                                    echo "E-mail e/ou senha estão incorretos!";
                                                ?>
                                            </div>
                                        <?php
                                        //Recarregar página
                                        echo "<meta http-equiv='refresh' content='10'>";
                                    }
                                }else{
                                    ?>
                                        <div class="errado">
                                            <?php
                                                echo "Erro".$user->msgERRO;
                                            ?>
                                        </div>
                                    <?php
                                    //Recarregar página
                                    echo "<meta http-equiv='refresh' content='10'>";
                                }
                            }else{
                                ?>
                                    <div class="errado">
                                        <?php
                                            echo "preencha todos os campos!";
                                        ?>
                                    </div>
                                <?php
                                //Recarregar página
                                echo "<meta http-equiv='refresh' content='10'>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>

    <!-- footer -->
    
    <?php include '../../php/footer.php'; ?>

    <!-- Scripts -->

    <script src="../../js/menu.js"></script>
    <script src="../../js/mostrarSenha.js"></script>
    <script src="../../js/fontawesome.js"></script>
</body>
</html>