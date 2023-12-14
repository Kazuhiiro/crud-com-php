<?php
session_start();
ob_start();
include_once './conexao.php';

//Filtro para puxar o ID do cadastro na URL
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    //Atribuição de sessão global
    $_SESSION['msg'] = "<p style='color: red;'>Erro: Usuário não encontrado.</p><br>";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar</title>
</head>

<body>
    <a href="index.php">Listar</a><br>
    <a href="Cadastro.php">Cadastrar</a><br>
    <h1>Visualizar</h1>

    <?php
    $query_usuario = "SELECT id, nome, email FROM usuarios WHERE id = $id LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->execute();

    if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
        extract($row_usuario);
        //echo "ID: " . $row_usuario['id'] . "<br>";

        echo "ID: $id <br>";
        echo "Nome: $nome <br>";
        echo "E-mail: $email <br>";
    } else {
        $_SESSION['msg'] = "<p style='color: red;'>Erro: Usuário não encontrado.</p><br>";
        header("Location: index.php");
    }

    ?>
</body>

</html>