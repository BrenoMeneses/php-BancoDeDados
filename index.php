<?php 
    if(!isset($_SESSION)){
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="style/INDEX.css">
</head>
<body>
    <header>
        <h1>HOME</h1>
        <nav>
            <a href="login.php"><button>ENTRAR</button></a>
            <a href="cadastro.php"><button>CADASTRAR</button></a>
        </nav>
    </header>
    <main>
    <?php
        if(isset($_SESSION['nome'])){
            echo "<h1>olá, " . $_SESSION['nome'] . "!! obrigado por testar meu programa</h1>";
        }else{
            echo"<h1>nenhum cadastro feito</h1>";
        }
        ?>
    </main>
</body>
</html>