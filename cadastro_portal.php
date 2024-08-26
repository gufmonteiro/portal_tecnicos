<?php

//Eliminar Warning
ini_set('display_errors', 'off');

//Variável de Erro
$msg_erro = array();
$msg_success = array();

//Verifica se Formulário foi Enviado
if (isset($_POST['btnCadastrar'])) {
	//Pega dados do Form
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$repetirSenha = $_POST['repetirSenha'];

	//Obriga preencher os Campos
	if (strlen($nome) == 0) {
		$msg_erro['msg'][] = "Informe o Nome!";
	}
	if (strlen($email) == 0) {
		$msg_erro['msg'][] = "Informe o E-mail!";
	}
	if (strlen($senha) == 0) {
		$msg_erro['msg'][] = "Informe a Senha!";
	}
	if (strlen($repetirSenha) == 0) {
		$msg_erro['msg'][] = "Repita a Senha!";
	}
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="cadastro_portal.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Cadastro ao Portal
	</title>
</head>
<body>
	<div class="background-container">
		<div class="blue-bg"></div>
		<div class="white-bg"></div>
    </div>
    <div class="cadastro-container">
    	<div class="col mb-4">
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
    	    <div class="row">
    			<div class="col-5 mx-auto">
    				<label for="nome" class="form-label">Nome:</label>
    				<div class="input-group">
    					<input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome ?>">
    					<span class="input-group-text">
    						<i class="bi bi-person-arms-up"></i>
    					</span>
    				</div>
    			</div>
    			<div class="col-5 mx-auto">
    				<label for="email" class="form-label">E-mail:</label>
    				<div class="input-group">
    					<input type="email" class="form-control" name="email" id="email" value="<?php echo $email ?>">
    					<span class="input-group-text">
    						<i class="bi bi-envelope-fill"></i>
    					</span>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-5 mx-auto">
					<label for="senha" class="form-label">Senha:</label>
					<div class="input-group">
						<input type="password" class="form-control" name="senha" id="senha" value="<?php echo $senha ?>">
						<span class="input-group-text">
							<i class="bi bi-lock"></i>
						</span>
					</div>
				</div>
				<div class="col-5 mx-auto">
					<label for="repetirSenha" class="form-label">Repetir Senha:</label>
					<div class="input-group">
						<input type="password" class="form-control" name="repetirSenha" id="repetirSenha" value="<?php echo $repetirSenha ?>">
						<span class="input-group-text">
							<i class="bi bi-lock"></i>
						</span>
					</div><br>
				</div>
			</div>
			<div class="uploader" onclick="document.getElementById('file-input').click()">
		        <span>
		        	<i class="bi bi-upload">Upload Logo</i>
		        </span>
		        <input type="file" id="file-input" class="file-input" onchange="handleFileUpload(this.files)">
		        <img id="uploaded-image" class="uploaded-image" src="">
		    </div><br>
			<div class="row justify-content-center">
				<div class="col mx-auto text-center">
					<button type="submit" class="btn btn-primary" name="btnCadastrar" id="btnCadastrar">CADASTRAR</button>
				</div>
			</div>
			<div class=" text-center mb-3">
				<hr class="my-4">
				<a class="no-link" href="login_portal.php">FAZER LOGIN</a><br>
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
	<script>
        function handleFileUpload(files) {
            if (files.length > 0) {
            	const file = files[0];
            	console.log('Arquivo selecionado:', file.name);
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('uploaded-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>