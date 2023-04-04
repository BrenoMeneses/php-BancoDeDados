<?php 
include('conexao.php');

$a = 0;
$b = true;

if(isset($_POST['nome']) || isset($_POST['senha']) || isset($_POST['confSenha'])){ //confirmando se as variaveis existem

    if(strlen($_POST['nome']) == 0){

        $a = 1; // preencha o campo com o nome

    }else if(strlen($_POST['senha']) == 0){ // confirmando que as variaveis tenham algum valor

        $a = 2; // preencha o campo com a senha

    }else if(strlen($_POST['confSenha']) == 0){

        $a = 3; // preencha a confirmação da senha

    }else {
        // se as variaveis tiverem valor começa o codigo

        $nome = $mysqli->real_escape_string($_POST['nome']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        $confSenha = $mysqli->real_escape_string($_POST['confSenha']); // alguma coisa de segurança do banco de dados

        if($senha == $confSenha){ // confiramção de senha

            $sqlCode = "select nome from cadastro";
            $sqlQuery = $mysqli->query($sqlCode) or die("<p>falha no carregamento: " . $mysqli->error . "</p>"); // executando comando sql

            if($sqlQuery->num_rows > 0){

                while($nomes = $sqlQuery->fetch_array()){ //verificando se existem nomes ja usados

                    if($nomes['nome'] == $_POST['nome']){
                        
                        $b = false; 
                        $a = 5; // nome já cadastrado
                        break;
                    }
                }
            }

            if($b == true){ // se o nome não existir ainda a variavel b for verdadeira continua o codigo

                $sqlCode = "insert into cadastro (nome, senha) value ('$nome', '$senha');";
                $sqlQuery = $mysqli->query($sqlCode) or die("<p>falha no carregamento: " . $mysqli->error . "</p>");// inserindo os dados no banco de dados

                if($mysqli->affected_rows == 1){ // verificação em caso de erro no banco de dados

                    $sqlCode = "select * from cadastro where nome = '$nome' and senha = '$senha'";
                    $sqlQuery = $mysqli->query($sqlCode) or die($mysqli->error); // selecionando a tabela toda
                    
                    if($sqlQuery->num_rows > 0){ // mais verificação

                        $user = $sqlQuery->fetch_row();

                        if(!isset($_SESSION)){
                            session_start(); //iniciando a sessao pra variaveis
                        }

                        $_SESSION['id'] = $user[0];
                        $_SESSION['nome'] = $user[1]; //atribuindo valores pra variavel de sessao

                        header("location: index.php"); //redirecionando pra home page

                    }else{

                    }
                }else{

                }

            }
            
        }else{
            $a = 4; // as senhas não estão iguais
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
    <title>cadastro</title>
    <link rel="stylesheet" href="style/CADASTRO.css">
</head>
<body onload="nome.focus()">
    <header>
        <h1>CADASTRO</h1>
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
                        <input type="text" name="senha" id="senha" maxlength="16">
                    </label>
                    <label for="confSenha"> confirme sua senha
                        <input type="password" name="confSenha" id="confSenha">
                    </label>
                    <input type="submit" value="ENVIAR" id="botaoA">
                </form>
            </div>
            <?php 
                switch($a){
                    case 1:
                        echo "<p>preencha o campo com o nome</p>";
                        break;
                    case 2:
                        echo "<p>preencha o campo com a senha</p>";
                        break;
                    case 3:
                        echo "<p>preencha a confirmação da senha</p>";
                        break;
                    case 4:
                        echo "<p>as senhas não estão iguais</p>";
                        break;
                    case 5:
                        echo "<p>nome já cadastrado</p>";
                        break;
                }
            ?>
        </main>
    </section>
</body>
</html>