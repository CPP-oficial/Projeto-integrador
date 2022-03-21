<?php
    //Importanto o PHPMailler

    require_once('../../php/src/PHPMailer.php');
    require_once('../../php/src/SMTP.php');
    require_once('../../php/src/Exception.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de contato</title>
    <link rel="stylesheet" href="../../style/header.css">
    <link rel="stylesheet" href="../../style/contatos.css">
    <link rel="stylesheet" href="../../style/footer.css">
    <link rel="stylesheet" href="../../style/erros.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
</head>
<body class="fundo">
    <!-- cabeçalho -->

    <?php include '../../php/header.php'; ?>
    
    <!-- Conteúdo -->
    <main>
        <div class="conteiner">
            <!-- Informações geográficas -->
            <section>
                <div class="caixa">
        
                    <!-- Mapa feito com o leaflet.js -->
                    <div id="map"></div>
        
                    <!-- Informações de contato -->
                    <div class="info">
                        <h3>
                            Informações de contato
                        </h3>
                        <div class="icone">
                            <i class="fas fa-phone"></i>
                            <span>(XX) XXXXXXXXX</span>
                        </div>
                        <div class="icone">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Sítio Lagoa do Clementino, S/N. Zona Rural - Apodi/RN - CEP 59.700.00</span>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Contato via formulário de e-mail -->
            <section>
                <div class="caixa">
                    <header class="cabeca">
                        <H3>
                            Formulário de contato
                        </H3>
                        <p>
                            Preencha todos os parâmetros abaixo para nos contatar. Dê preferência ao formulário no momento de relatar erros, problemas, feedbacks, etc. Jamais utilize para fazer brincadeiras, caso o use para tal fim, ignoraremos seu e-mail.
                        </p>
                    </header>
                    <!-- Área dedicada ao formulário -->
                    <main class="formulario">
                        <form method="POST">
        
                            <!-- Parametros do formulário -->
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" class="parametro" name="nome" required>
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" class="parametro" name="email" required>
                            <label for="assunto">Assunto:</label>
                            <input type="text" id="assunto" class="parametro" name="assunto" required>
                            <label for="mensagem">Mensagem:</label>
                            <textarea id="mensagem" cols="30" rows="10" class="parametro" name="mensagem" required></textarea>
                            <input type="submit" value="Enviar" class="botao">
                        </form>
                        <?php
                        if (isset($_POST["nome"],$_POST["email"],$_POST["assunto"], $_POST["mensagem"])) {
                                //Fuso horário
        
                                date_default_timezone_set('America/Sao_Paulo');
                                //Variáveis do Forms
                                $nome = $_POST['nome'];
                                $email = $_POST['email'];
                                $assunto = $_POST['assunto'];
                                $mensagem = $_POST['mensagem'];
                                $data_envio = date('d/m/Y');
                                $hora_envio = date('H:i:s');
                                //Corpos
        
                                //E-mail com HTML
                                $arquivo = "
                                <html>
                                    <p><b>Nome: </b>$nome</p>
                                    <p><b>E-mail: </b>$email</p>
                                    <p><b>Mensagem: </b>$mensagem</p>
                                    <p>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></p>
                                </html>
                                ";
                                //E-mail sem HTML
                                $semhtml = "
                                Nome: $nome
                                E-mail: $email
                                Mensagem: $mensagem
                                Este e-mail foi enviado em $data_envio às $hora_envio.
                                ";
                                $mail = new PHPMailer(true);
                                try {
                                    //Configurações Gerais
                                    $mail->isSMTP(); //Protocolo escolhido
                                    $mail->setLanguage(langcode:'pt-br'); //Lingua do e-mail
                                    $mail->CharSet = 'utf-8'; //Dicionário escolhido
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true; //Autentificação
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = 587;
                                    //Infos do remetente
                                    $mail->setFrom('oficialcpp@gmail.com', 'CPP Forms');
                                    //Infos do destinatário
                                    $mail->addAddress('oficialcpp@gmail.com');
                                    //Configurações do E-mail
                                    //E-mail com HTML
                                    $mail->isHTML(true); //E-mail em HTML
                                    $mail->Subject = $assunto;
                                    $mail->Body = $arquivo;
                                    //E-mail sem HTML
                                    $mail->AltBody = $semhtml;
                                    // ADD arquivos no e-mail
                                    //$mail->addAttachment('../image/pointer.png', 'new.jpg'); - ADD arquivo no email
                                    //Enviar E-mail
                                    if($mail->send()) {
                                        ?>
                                            <div class="correto">
                                                <?php
                                                    echo 'E-mail enviado com sucesso!';
                                                ?>
                                            </div>
                                        <?php
        
                                        //Recarregar página
                                        echo "<meta http-equiv='refresh' content='10'>";
                                    } else {
                                        ?>
                                            <div class="errado">
                                                <?php
                                                    echo 'E-mail não enviado!';
                                                ?>
                                            </div>
                                        <?php
                                        //Recarregar página
                                        echo "<meta http-equiv='refresh' content='10'>";
                                    }
                                } catch (Exception $e) {
                                    ?>
                                        <div class="errado">
                                            <?php
                                                echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
                                            ?>
                                        </div>
                                    <?php
                                    //Recarregar página
                                    echo "<meta http-equiv='refresh' content='5'>";
                                }
                            }
                        ?>
                    </main>
                </div>
            </section>
        </div>
    </main>

    <!--footer-->

    <?php include '../../php/footer.php'; ?> 

    <!-- Scripts -->

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
    <script src="../../js/mapa.js"></script>
    <script src="../../js/menu.js"></script>
    <script src="../../js/fontawesome.js"></script>
</body>
</html>