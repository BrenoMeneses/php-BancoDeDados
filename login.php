<?php 
include('conexao.php');

$a = 0;

if(isset($_POST['nome']) || isset($_POST['senha'])){

    if(strlen($_POST['nome']) == 0){
        $a = 1;
    }else if(strlen($_POST['senha']) == 0){
        $a = 2;
    }else{

        $nome = $mysqli->real_escape_string($_POST['nome']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sqlCode = "select * from cadastro where nome = '$nome' and senha = '$senha';";
        $sqlQuery = $mysqli->query($sqlCode) or die("falha no carregamento: " . $mysqli->error);

        if($sqlQuery->num_rows > 0){

            $a = 3;
            $user = $sqlQuery->fetch_row();

            if(!isset($_SESSION)){
                session_start();
            }

            $_SESSION['id'] = $user[0];
            $_SESSION['nome'] = $user[1];

            header("location: index.php");

        }else{
            $a = 3;
        }
    }
}
?>  

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style/LOGIN.css">
</head>
<body onload="nome.focus()">
    <header>
        <h1>LOGIN</h1>
        <nav>
            <a href="index.php"><button>VOLTAR</button></a>
        </nav>
    </header>
    <section>
        <main>
            <div id="divForm">
                <form action="" method="post" autocomplete="off">
                    <label for="nome">nome
                        <input type="text" name="nome" id="nome" maxlength="30">
                    </label>
                    <label for="senha">senha
                        <input type="password" name="senha" id="senha" maxlength="16">
                    </label>
                    <input type="submit" value="ENVIAR" id="botaoA">
                </form>
            </div>
            <?php
                switch($a){
                    case 1:
                        echo '<p>preencha o campo com o nome</p>';
                        break;
                    case 2:
                        echo '<p>preencha o campo com a senha</p>';
                        break;
                    case 3:
                        echo "<p>nome ou senha incorretos</p>";
                        break;
                }
            ?>
        </main>
    </section>
</body> 
</html>