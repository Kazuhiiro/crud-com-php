<?php
session_start();
ob_start();
include_once './conexao.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body>
    <a href="index.php">Listar</a><br>
    <a href="Cadastro.php">Cadastrar</a><br>
    <h1>Cadastro</h1>
    <?php
    //Receber os dados do Formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['CadUsuario'])) {
        //var_dump($dados);

        $empty_input = false;

        //Verificar se os dados que o usuário colocou são válidos
        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            //Erro caso o usuário não preencha todos os campos
            echo "<p style='color: red;'>Erro: É necessário preencher todos os campos.</p><br>";
            //Validão de e-mail
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $empty_input = true;
            //Erro caso o usuário não preencha com um e-mail válido
            echo "<p style='color: red;'>Erro: Necessário preencher com e-mail válido.</p><br>";
        }

        //Verificar se 
        if (!$empty_input) {
            //$query_usuario = "INSERT INTO usuarios (nome, email) VALUES ('" . $dados['nome'] ."', '" . $dados['email'] . "') ";
            $query_usuario = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
            $cad_usuario = $conn->prepare($query_usuario);
            //Link das variáveis do banco de dados
            $cad_usuario->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
            $cad_usuario->bindParam(":email", $dados['email'], PDO::PARAM_STR);
            $cad_usuario->execute();
            if ($cad_usuario->rowCount()) {
                unset($dados);
                $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!</p><br>";
                header("Location: index.php");
            } else {
                echo "<p style='color: red;'>Erro: Usuário não cadastrado</p><br>";
            }
        }
    }
    ?>
    <form name="cad_usuario" method="post" action="">
        <label>Nome: </label>
        <input type="text" name="nome" id="nome" placeholder="Nome completo" value="<?php
        if (isset($dados['nome'])) {
            echo $dados['nome'];
            }
        ?>"><br><br>

        <label>E-mail: </label>
            <input type=" email" name="email" id="email" placeholder="email" value="<?php
        if (isset($dados['email'])) {
            echo $dados['email'];
            }
        ?>"><br><br>

        <input type="submit" value="Cadastrar" name="CadUsuario">
    </form>


</body>

</html>