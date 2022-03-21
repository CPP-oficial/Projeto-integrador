<?php
  //Importanto o PHPMailler

  require_once('src/PHPMailer.php');
  require_once('src/SMTP.php');
  require_once('src/Exception.php');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

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
        $mail->Username = 'oficialcpp@gmail.com';
        $mail->Password = 'CPP21@!p';
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