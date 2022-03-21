<?php
@include '../../php/verificacao.php';
@include '../../php/configuracao.php';

if(isset($_POST['adicione'])){
    $titulo = $_POST['titulo'];
    $orientador = $_POST['orientador'];
    $pdf = $_FILES['pdf']['name'];
    $pdf_tmp_nome = $_FILES['pdf']['tmp_name'];
    $pdf_arquivo = '../../arquivos/'.$pdf;

    if(empty($titulo) || empty($orientador) || empty($pdf)){
        $mensagem[] = 'Preenchar todas as informações!';
    }else{
        $insert = "INSERT INTO tcc(nome, orientador, arquivo) VALUES('$titulo', '$orientador', '$pdf')";
        $upload = mysqli_query($conexao, $insert);
      if($upload){
         move_uploaded_file($pdf_tmp_nome, $pdf_arquivo);
         $message[] = 'O tcc foi adicionado com sucesso!';
      }else{
         $message[] = 'Não foi possível adicionar o tcc.';
      }
    }
};

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conexao, "DELETE FROM tcc WHERE id = $id");
    header('location:cpp.php');
};

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPP home - adminpage </title>

    <!-- Estilos -->

    <link rel="stylesheet" href="../../style/cpp.css">
    <link rel="stylesheet" href="../../style/formularioTCC.css">
</head>
<body>
    <!-- Barra lateral -->

        <?php include '../../php/barraLateral.php';?>

    <!-- Área de conteúdo -->

    <main class="conteudo">
        
    <?php
        if(isset($mensagem)){
            foreach($mensagem as $mensagem){
            echo '<span class="mensagem">'.$mensagem.'</span>';
            }
        }
    
    ?>
        <div class="conteudo-formulario-admin">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                <h3>Adicione o TCC</h3>
                <input type="text" placeholder="Digite o título" name="titulo" class="input_caixa">
                <input type="text" placeholder="Digite o nome do Orientador" name="orientador" class="input_caixa">
                <input type="file" placeholder="Anexe o arquivo" accept="application/pdf" name="pdf" class="input_caixa">
                <input type="submit" class="botao_forms" name="adicione" value="Adicione o TCC">
            </form>
        </div>
        <?php
            $select = mysqli_query($conexao, "SELECT * FROM tcc");
        ?>
        <div class="caixa_tcc">
            <table class="caixa_tcc_tabela">
                <thead>
                    <tr>
                        <th>arquivo</th>
                        <th>nome</th>
                        <th>orientador</th>
                        <th colspan="2">opções</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                        while($linha = mysqli_fetch_assoc($select)){
                    
                        echo"<tr>";
                            echo'<td><img src="../../image/pdf.svg" alt="Um quadrado vermelho com a palavra pdf." height="100px"></td>';
                            echo'<td><a href="../../arquivos/'.$linha['arquivo'].'" target="_blank" rel="noopener noreferrer" style="font-size: 2em;">'.$linha['nome'].'</a></td>';
                            echo'<td style="font-size: 2em;">'.$linha['orientador'].'</td>';
                            echo'<td>
                                <a href="../../php/admin_atualizacao.php?edit='.$linha['id'].'" class="botao_forms"><i class="fas fa-edit"></i>editar</a>';
                                echo'<a href="cpp.php?delete='.$linha['id'].'" class="botao_forms"><i class="fas fa-trash"></i>deletar</a>';
                            echo'</td>';
                        echo"</tr>";
                        };
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Scripts -->
    <script src="../../js/barraLateral.js"></script>
    <script src="../../js/pesquisa.js"></script>
    <script src="../../js/fontawesome.js"></script>
</body>
</html>