<?php

//Eliminar Warning
ini_set('display_errors', 'off');

//Variável de Erro
$msg_erro = array();
$msg_sucess = array();

//Verifica se Formulário foi Enviado
if (isset($_POST["btnLogin"])) {
	//Pega dados do Form
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	//Obriga a Preencher os Campos
	if (strlen($email) == 0) {
		$msg_erro['msg'][] = "Informe o E-mail!";
	}
	if (strlen($password) == 0) {
		$msg_erro['msg'][] = "Informe a Senha!";
	}
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="login_portal.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Acesso ao Portal
	</title>
</head>
<body>
	<div class="background-container">
		<div class="blue-bg"></div>
		<div class="white-bg"></div>
    </div>
    <div class="login-container">
    	<div class="mb-4">
    		<h1 class="text-center col mb-3">
    			<img class="rounded-circle" src="images/Teste_Telecontrol.jpg">TELECONTROL <br> CHECK-IN
    		</h1>
    	</div>
    	<form action="" method="POST">
    		<?php if (count($msg_erro) > 0){ ?>
    	        <div id="alert-danger" class="alert alert-danger"><?php echo implode("<br>", $msg_erro['msg']); ?></div>
    	    <?php } ?>
    	    <!-- DIV success para mensagens de sucesso -->
    	    <?php if(count($msg_success) > 0){ ?>
    	        <div id="alert-success" class="alert alert-success"><?php echo implode("<br>", $msg_success['msg']); ?></div>
    	    <?php } ?>
    		<div class="mb-3">
				<label for="email" class="form-label">E-mail:</label>
				<div class="input-group">
					<input type="email" class="form-control" name="email" id="email" value="<?php echo $email ?>">
					<span class="input-group-text">
						<i class="bi bi-envelope-fill"></i>
					</span>
				</div>
			</div>
			<div class="mb-3">
				<label for="password" class="col-sm-2 col-form-label">Senha:</label>
				<div class="input-group">
					<input type="password" class="form-control" name="password" id="password" value="<?php echo $password ?>">
					<span class="input-group-text">
						<i class="bi bi-lock"></i>
					</span>
				</div>
			</div>
			<div class="mb-3">
				<button type="submit" class="btn btn-primary" id="btnLogin" name="btnLogin">ENTRAR</button>
			</div>
			<div class=" text-center mb-3">
				<hr class="my-4">
				<a class="no-link" href="cadastro_portal.php">CRIAR CONTA</a><br>
			  	<a class="no-link" href="">ESQUECEU A SENHA</a>
			</div>
		</form>
	</div>
	<footer class="footer">
		<hr>
		<div class="footer-content">
			<p>DESENVOLVIDO POR:</p>
			<img class="img-footer" src="images/logo.png" alt="Logo">
		</div>
	</footer>
</body>
</html>