<?php

@include 'configuracao.php';

$id = $_GET['edit'];

if(isset($_POST['atualize'])){

    $titulo = $_POST['titulo'];
    $orientador = $_POST['orientador'];
    $pdf = $_FILES['pdf']['name'];
    $pdf_tmp_nome = $_FILES['pdf']['tmp_name'];
    $pdf_arquivo = '../../arquivos/'.$pdf;

    if(empty($titulo) || empty($orientador) || empty($pdf)){
        $mensagem[] = 'Preenchar todas as informações!';
    }else{
        $update = "UPDATE tcc SET nome='$titulo', orientador='$orientador', arquivo='$pdf' WHERE id = $id";
        $upload = mysqli_query($conexao, $update);
        if($upload){
            move_uploaded_file($pdf_tmp_nome, $pdf_arquivo);
            header('location:../html/cpp/cpp.php');
        }else{
            $mensagem[] = 'Não foi possível atualizar o documento';
        }
    }
};

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>página de atualização</title>

    <!-- Estilos -->

    <link rel="stylesheet" href="../style/formularioTCC.css">
</head>
<body>
    <?php
        if(isset($mensagem)){
            foreach($mensagem as $mensagem){
                echo '<span class="mensagem">'.$mensagem.'</span>';
            }
        }
    ?>

    <div class="conteudo">
        <div class="conteudo-formulario-admin centro">

        <?php
    
            $select = mysqli_query($conexao, "SELECT * FROM tcc WHERE id = $id;");
            while($linha = mysqli_fetch_assoc($select)){

        ?>

            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                <h3>Atualize o TCC</h3>
                <input type="text" placeholder="Digite o título do TCC" value="<?php echo $linha['nome'];?>" name="titulo" class="input_caixa">
                <input type="text" placeholder="Digite o nome do Orientador" value="<?php echo $linha['orientador'];?>" name="orientador" class="input_caixa">
                <input type="file" accept="application/pdf" name="pdf" class="input_caixa">
                <input type="submit" class="botao_forms" name="atualize" value="atualize o TCC">
                <a href="../html/cpp/cpp.php" class="botao_forms">Voltar</a>
            </form>

            <?php
                };
            ?>

        </div>
    </div>

    <!--Link de font awesome-->

    <script src="https://kit.fontawesome.com/b9bdcd005c.js" crossorigin="anonymous"></script>
</body>
</html>