<?php
//Remove os Warnings
ini_set('display_errors', 'Off');

//Criar variáveis de erro
$msg_erro = array();
$msg_success = array();

//FUNÇÃO QUE VALIDA O CNPJ
function validarCNPJ($documento) {
    // Remove caracteres especiais
    $documento = preg_replace('/[^0-9]/', '', (string) $documento);

    // Valida tamanho
    if (strlen($documento) != 14) {
        return false;
    }

    // Verifica se todos os dígitos são iguais, o que não é permitido
    if (preg_match('/(\d)\1{13}/', $documento)) {
        return false;
    }

    // Calcula o primeiro dígito verificador
    $soma = 0;
    for ($i = 0, $j = 5; $i < 12; $i++) {
        $soma += $documento[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    // Calcula o segundo dígito verificador
    $soma = 0;
    for ($i = 0, $j = 6; $i < 13; $i++) {
        $soma += $documento[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    // Verifica se os dígitos calculados são iguais aos informados
    if ($documento[12] != $digito1 || $documento[13] != $digito2) {
        return false;
    }

    return true;
}

//CADASTRAR FÁBRICA
if (isset($_POST['submit'])) {
	//Coleta Dados do Form
	$documento = $_POST['documento'];
    $nome = $_POST['nome'];
    $telefone1 = $_POST['telefone1'];
    $telefone2 = $_POST['telefone2'];
    $email = $_POST['email'];
    $site = $_POST['site'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $complemento = $_POST['complemento'];
    $pais = $_POST['pais'];
    $ativo = isset($_POST['ativo']) ? true : false;

    //Valida CNPJ
    if (!validarCNPJ($documento)) {
    	$msg_erro['msg'][] = "CNPJ Inválido!";
    }
    //Campos Obrigatórios
    if(strlen($documento) == 0){
    	$msg_erro['msg'][] = "Informe o CNPJ da Fábrica!";
    }
    if(strlen($nome) == 0){
    	$msg_erro['msg'][] = "Informe o Nome da Fábrica!";
    }
    if(strlen($email) == 0){
    	$msg_erro['msg'][] = "Informe o E-mail da Fábrica!";
    }
    if(strlen($endereco) == 0){
    	$msg_erro['msg'][] = "Informe o Endereço da Fábrica!";
    }
    if(strlen($numero) == 0){
    	$msg_erro['msg'][] = "Informe o Número da Fábrica!";
    }
    if(strlen($cidade) == 0){
    	$msg_erro['msg'][] = "Informe a Cidade da Fábrica!";
    }
    if(strlen($estado) == 0){
    	$msg_erro['msg'][] = "Informe o Estado da Fábrica!";
    }
    if(strlen($pais) == 0){
    	$msg_erro['msg'][] = "Informe o País da Fábrica!";
    }

    //Se não houver erros, prossegue
    if (empty($msg_erro)) {
    // Formata os dados como JSON
    	$data = json_encode([
	        "documento" => $documento,
	        "nome" => $nome,
	        "telefone1" => $telefone1,
	        "telefone2" => $telefone2,
	        "email" => $email,
	        "site" => $site,
	        "endereco" => $endereco,
	        "numero" => $numero,
	        "cidade" => $cidade,
	        "estado" => $estado,
	        "complemento" => $complemento,
	        "pais" => $pais,
	        "ativo" => $ativo
	    ]);

	    // Inicializa o cURL POST
	    $curlPOST = curl_init();
	    curl_setopt_array($curlPOST, array(
	    	CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => ' ',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
				'Access-Env: HOMOLOGATION',
				'Content-Type: application/json'
			),
		));

		$responsePOST = curl_exec($curlPOST);
		$httpCodePOST = curl_getinfo($curlPOST, CURLINFO_HTTP_CODE);
		curl_close($curlPOST);

		// Verifica se a requisição foi bem sucedida (HTTP 200)
		if ($httpCodePOST == 200) {
			$msg_success['msg'][] = "Fábrica cadastrada com Sucesso!";
		} else {
			// Se der erro, pega a mensagem de erro da API
			$responseDataPOST = json_decode($responsePOST, true); // Converte o JSON em array

			if(isset($responseDataPOST['error'])) {
				$msg_erro['msg'][] = "Erro ao cadastrar Fábrica: " . $responseDataPOST['error'];
			} else {
				$msg_erro['msg'][] = "Erro ao cadastra Fábrica!";
			}
		}
	}
}

//FUNÇÃO QUE ENCONTRA ID DA FÁBRICA
function obterIdFabrica($documento) {
	$curlGET = curl_init();
	curl_setopt_array($curlGET, array(
        CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
            'Access-Env: HOMOLOGATION',
            'Content-Type: application/json'
        ),
    ));

    $responseGET = curl_exec($curlGET);
    curl_close($curlGET);
    $fabricas = json_decode($responseGET, true);

    // Encontrar a fábrica com o documento desejado
    $fabricaId = null;
    foreach ($fabricas as $fabrica) {
        if ($fabrica['documento'] === $documento) {
            $fabricaId = $fabrica['fabrica'];
            break;
        }
    }

    return $fabricaId;
}

//DESATIVAR FÁBRICA
if (isset($_POST['desativar'])) {
    $documento = $_POST['documento'];
    
    // Inicializa o cURL GET para buscar a fábrica pelo documento
    $curlGET = curl_init();
    curl_setopt_array($curlGET, array(
        CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
            'Access-Env: HOMOLOGATION',
            'Content-Type: application/json'
        ),
    ));

	    $responseGET = curl_exec($curlGET);
	    curl_close($curlGET);
	    $fabricas = json_decode($responseGET, true);
	    
	    // Encontrar a fábrica com o documento desejado
	    $fabricaId = null;
	    foreach ($fabricas as $fabrica) {
	        if ($fabrica['documento'] === $documento) {
	            $fabricaId = $fabrica['fabrica'];
	            break;
	        }
    }

    // Verifica se encontrou a fábrica com o documento desejado
    if ($fabricaId !== null) {
        // Inicializa o cURL DELETE
        $curlDELETE = curl_init();
        curl_setopt_array($curlDELETE, array(
            CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal?fabrica=' . $fabricaId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
                'Access-Env: HOMOLOGATION',
                'Content-Type: application/json'
            ),
        ));
        $responseDELETE = curl_exec($curlDELETE);
        $httpCodeDELETE = curl_getinfo($curlDELETE, CURLINFO_HTTP_CODE);
        curl_close($curlDELETE);
        
        // Verifica o código HTTP retornado
        if ($httpCodeDELETE == 200) {
            $msg_success['msg'][] = "Fábrica inativada com sucesso!";
            
            // Atualiza a lista de fábricas após a inativação
            $curlGET = curl_init();
            curl_setopt_array($curlGET, array(
                CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
                    'Access-Env: HOMOLOGATION',
                    'Content-Type: application/json'
                ),
            ));

            $responseGET = curl_exec($curlGET);
            curl_close($curlGET);
            $fabricas = json_decode($responseGET, true);
            
            // Atualiza Qtde de Registros
            $total_registros = count($fabricas);
            $total_paginas = ceil($total_registros / $registros_por_pagina);

            // Atualiza Registros da Página Atual
            $fabricas_pagina = array_slice($fabricas, $inicio, $registros_por_pagina);
        } else {
            $msg_erro['msg'][] = "Erro ao inativar a Fábrica!";
        }
    } else {
        $msg_erro['msg'][] = "Fábrica não encontrada!";
    }
}

//ATIVAR FÁBRICA
if (isset($_POST['ativar'])) {
    $documento = $_POST['documento'];

    // Inicializa o cURL GET para buscar a fábrica pelo documento
    $curlGET = curl_init();
    curl_setopt_array($curlGET, array(
        CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
            'Access-Env: HOMOLOGATION',
            'Content-Type: application/json'
        ),
    ));

    $responseGET = curl_exec($curlGET);
    curl_close($curlGET);
    $fabricas = json_decode($responseGET, true);

    // Encontrar a fábrica com o documento desejado
    $fabricaId = null;
    foreach ($fabricas as $fabrica) {
        if ($fabrica['documento'] === $documento) {
            $fabricaId = $fabrica['fabrica'];
            break;
        }
    }

    // Verifica se encontrou a fábrica com o documento desejado
    if ($fabricaId !== null) {
        // Inicializa o cURL PUT para ativar a fábrica
        $data = json_encode(array("ativo" => true));
        $curlPUT = curl_init();
        curl_setopt_array($curlPUT, array(
            CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal?fabrica=' . $fabricaId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
                'Access-Env: HOMOLOGATION',
                'Content-Type: application/json'
            ),
        ));
        $responsePUT = curl_exec($curlPUT);
        $httpCodePUT = curl_getinfo($curlPUT, CURLINFO_HTTP_CODE);
        curl_close($curlPUT);

        // Verifica o código HTTP retornado
        if ($httpCodePUT == 200) {
            $msg_success['msg'][] = "Fábrica ativada com sucesso!";
            
            // Atualiza a lista de fábricas após a ativação
            $curlGET = curl_init();
            curl_setopt_array($curlGET, array(
                CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
                    'Access-Env: HOMOLOGATION',
                    'Content-Type: application/json'
                ),
            ));

            $responseGET = curl_exec($curlGET);
            curl_close($curlGET);
            $fabricas = json_decode($responseGET, true);
            
            // Atualiza Qtde de Registros
            $total_registros = count($fabricas);
            $total_paginas = ceil($total_registros / $registros_por_pagina);

            // Atualiza Registros da Página Atual
            $fabricas_pagina = array_slice($fabricas, $inicio, $registros_por_pagina);
        } else {
            $msg_erro['msg'][] = "Erro ao ativar a fábrica!";
        }
    } else {
        $msg_erro['msg'][] = "Fábrica não encontrada!";
    }
}

//ATUALIZAR FÁBRICA
if (isset($_POST['btn-atualizar'])) {
    // Coleta os dados atualizados do formulário
    $documento = $_POST['documento'];
    $nome = $_POST['nome'];
    $telefone1 = $_POST['telefone1'];
    $telefone2 = $_POST['telefone2'];
    $email = $_POST['email'];
    $site = $_POST['site'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $complemento = $_POST['complemento'];
    $pais = $_POST['pais'];
    $ativo = isset($_POST['ativo']) ? true : false;

    // Formata os dados atualizados como JSON
    $data = json_encode([
        "documento" => $documento,
        "nome" => $nome,
        "telefone1" => $telefone1,
        "telefone2" => $telefone2,
        "email" => $email,
        "site" => $site,
        "endereco" => $endereco,
        "numero" => $numero,
        "cidade" => $cidade,
        "estado" => $estado,
        "complemento" => $complemento,
        "pais" => $pais,
        "ativo" => $ativo
    ]);

    // Obtém o ID da fábrica a ser atualizada
    $fabricaId = obterIdFabrica($documento); 

    if ($fabricaId !== null) {
        // Inicializa o cURL PUT para atualizar a fábrica
        $curlPUT = curl_init();
        curl_setopt_array($curlPUT, array(
            CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal?fabrica=' . $fabricaId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
                'Access-Env: HOMOLOGATION',
                'Content-Type: application/json'
            ),
        ));
        $responsePUT = curl_exec($curlPUT);
        $httpCodePUT = curl_getinfo($curlPUT, CURLINFO_HTTP_CODE);
        curl_close($curlPUT);

        // Verifica o código HTTP retornado
        if ($httpCodePUT == 200) {
            $msg_success['msg'][] = "Fábrica atualizada com sucesso!";
        } else {
            $msg_erro['msg'][] = "Erro ao atualizar a fábrica!";
        }
    } else {
        $msg_erro['msg'][] = "Fábrica não encontrada!";
    }
}
	// Configurar Paginação
	$registros_por_pagina = 10;
	$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
	$inicio = ($pagina_atual - 1) * $registros_por_pagina;

	// Inicializa o cURL GET
	$curlGET = curl_init();
	curl_setopt_array($curlGET, array(
		CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal?sort=ativo',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => ' ',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'Access-Application-Key: 5f64bfee020c2555872ca14bff7dafe01998b7e0',
			'Access-Env: HOMOLOGATION',
			'Content-Type: application/json'
		),
	));

	$responseGET = curl_exec($curlGET);
	curl_close($curlGET);
	$fabricas = json_decode($responseGET, true);

	//Calcular Qtde de Páginas
	$total_registros = count($fabricas);
	$total_paginas = ceil($total_registros / $registros_por_pagina);

	//Obter os registros da Página Atual
	$fabricas_pagina = array_slice($fabricas, $inicio, $registros_por_pagina);
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="cadastro_fabricas.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Fábricas Atendidas
	</title>
</head>
<body>
	<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-brand">
                <img class="rounded-circle" src="images/Teste_Telecontrol.jpg">
            </div>
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">TICKET</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="cadastro_ticket.php">ABRIR</a></li>
                                <hr>
                                <li><a class="dropdown-item" href="consulta_tickets.php">CONSULTAR</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">CADASTROS</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="cadastro_fabricas.php">FÁBRICAS</a></li>
                                <hr>
                                <li><a class="dropdown-item" href="cadastro_produtos.php">PRODUTOS</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">AGENDAMENTO</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
	<div class="title-cadastro">
		<h1>Cadastro de Fábricas</h1>
	</div>
	<!-- DIV abaixo para caso der erro em tela -->
		<?php if (count($msg_erro) > 0){ ?>
			<div id="alert-danger" class="alert alert-danger"><?php echo implode("<br>", $msg_erro['msg']); ?></div>
		<?php } ?>
		<!-- DIV abaixo para caso produto for cadastrado com sucesso -->
		<?php if(count($msg_success) > 0){ ?>
			<div id="alert-success" class="alert alert-success"><?php echo implode("<br>", $msg_success['msg']) ?></div>
		<?php } ?>
	<form method="POST" action="" enctype="multipart/form-data">
		<div class="cadastroFabrica">
			<div class="row">
				<div class="col-3 mx-auto">
					<label>CNPJ:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="documento" id="documento" value="<?php echo $documento ?>" oninput="limparDocumento()" required>
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>Nome:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome ?>">
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>E-mail:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="email" id="email" value="<?php echo $email ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3 mx-auto">
					<label>Telefone 01:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="telefone1" id="telefone1" value="<?php echo $telefone1 ?>">
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>Telefone 02:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="telefone2" id="telefone2" value="<?php echo $telefone2 ?>">
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>Site:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="site" id="site" value="<?php echo $site ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3 mx-auto">
					<label>Pais:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="pais" id="pais" value="<?php echo $pais ?>">
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>Estado:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="estado" id="estado" value="<?php echo $estado ?>">
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>Cidade:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="cidade" id="cidade" value="<?php echo $cidade ?>">
					</div>
				</div>
			</div>		
			<div class="row">
				<div class="col-3 mx-auto">
					<label>Endereço:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="endereco" id="endereco" value="<?php echo $endereco ?>">
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>Número:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="numero" id="numero" value="<?php echo $numero ?>">
					</div>
				</div>
				<div class="col-3 mx-auto">
					<label>Complemento:</label>
					<div class="input-group">
						<input type="text" class="form-control" name="complemento" id="complemento" value="<?php echo $complemento ?>">
					</div>
				</div>
			</div><br>
			<div class="row">
				<div class="col-3 mx-auto">
					<label>Ativo:</label>
					<div class="input-group">
						<input type="checkbox" class="form-check-input" name="ativo" id="ativo">
					</div>
				</div>
			</div><br><br>
			<div class="row justify-content-center">
				<div class="col mx-auto text-center">
					<button type="submit" id="btn-cadastrar" name="submit" class="btn btn-primary">Cadastrar</button>
					<button type="submit" id="btn-atualizar" name="btn-atualizar" class="btn btn-primary" style="display: none;">Atualizar</button>
				</div>
			</div>
		</div><br>
	</form>
	<h2>Fábricas Cadastradas</h2>
	<table class="table table-striped">
		<thead>
			<tr>
		      	<th scope="col" class="text-center">Documento</th>
		      	<th scope="col" class="text-center">Nome</th>
		      	<th scope="col" class="text-center">E-mail</th>
		      	<th scope="col" class="text-center">Telefone 01</th>
		      	<th scope="col" class="text-center">Telefone 02</th>
		      	<th scope="col" class="text-center">Endereço</th>
		      	<th scope="col" class="text-center">Complemento</th>
		      	<th scope="col" class="text-center">Cidade / Estado</th>
		      	<th scope="col" class="text-center">País</th>
		      	<th scope="col" class="text-center">Site</th>
		      	<th scope="col" class="text-center">Ativo</th>
		      	<th scope="col" class="text-center">Ações</th>
		    </tr>
	  	</thead>
	  	<tbody>
	  		<?php foreach ($fabricas_pagina as $fabrica) : ?>
	  			<tr id="row-<?php echo $fabrica['fabrica']; ?>">
	  				<td class="text-center"><?php echo $fabrica['documento']; ?></td>
                    <td class="text-center"><?php echo $fabrica['nome']; ?></td>
                    <td class="text-center"><?php echo $fabrica['email']; ?></td>
                    <td class="text-center"><?php echo $fabrica['telefone1']; ?></td>
                    <td class="text-center"><?php echo $fabrica['telefone2']; ?></td>
                    <td class="text-center"><?php echo $fabrica['endereco']. ' , ' . $fabrica['numero']; ?></td>
                    <td class="text-center"><?php echo $fabrica['complemento']; ?></td>                        
                    <td class="text-center"><?php echo $fabrica['cidade']. ', ' . $fabrica['estado']; ?></td>
                    <td class="text-center"><?php echo $fabrica['pais']; ?></td>
                    <td class="text-center"><?php echo $fabrica['site']; ?></td>
                    <td class="text-center"><?php echo $fabrica['ativo'] ? 'Sim' : 'Não'; ?></td>
                    <td class="d-flex justify-content-center align-items-center">
                    	<?php if ($fabrica['ativo']) : ?>
                    		<form method="POST" action="">
							    <input type="hidden" name="desativar" value="desativar">
							    <input type="hidden" name="documento" value="<?php echo $fabrica['documento']; ?>">
							    <button type="submit" class="btn btn-danger">Inativar</button>
							    <button type="button" class="btn btn-primary btn-editar" onclick="editarRegistro(this)" data-documento="<?php echo $fabrica['documento']; ?>">Editar</button>
							</form>
                    	<?php else : ?>
                    		<form method="POST" action="">
								<input type="hidden" name="ativar" value="ativar">
				    			<input type="hidden" name="documento" value="<?php echo $fabrica['documento']; ?>">
				    			<button type="submit" class="btn btn-success">Ativar</button><br>
				    		</form>
				    	<?php endif; ?>
				    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
	</table>
	<nav aria-label="teste">
		<ul class="pagination justify-content-center">
			<li class="page-item disabled">
				<?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
					<li class="page-item <?php if ($i == $pagina_atual) echo 'active'; ?>"><a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php endfor; ?>
		</ul>
	</nav>
	<footer class="footer">
		<hr>
		<div class="footer-content">
			<p>DESENVOLVIDO POR:</p>
			<img class="img-footer" src="images/logo.png" alt="Logo">
		</div>
	</footer>
	<script>
		function editarRegistro(button) {
        // Pega o documento do registro a ser editado
        var documento = button.getAttribute('data-documento');

        // Obtém os dados do registro
        var fabrica = <?php echo json_encode($fabricas); ?>.find(function(item) {
            return item.documento === documento;
        });

        // Preenche os campos do formulário com os dados
        document.getElementById('documento').value = fabrica.documento;
        document.getElementById('nome').value = fabrica.nome;
        document.getElementById('telefone1').value = fabrica.telefone1;
        document.getElementById('telefone2').value = fabrica.telefone2;
        document.getElementById('email').value = fabrica.email;
        document.getElementById('site').value = fabrica.site;
        document.getElementById('endereco').value = fabrica.endereco;
        document.getElementById('numero').value = fabrica.numero;
        document.getElementById('cidade').value = fabrica.cidade;
        document.getElementById('estado').value = fabrica.estado;
        document.getElementById('complemento').value = fabrica.complemento;
        document.getElementById('pais').value = fabrica.pais;
        document.getElementById('ativo').checked = fabrica.ativo;

        // Altera o texto do botão "Cadastrar" para "Atualizar"
        document.getElementById('btn-cadastrar').style.display = 'none';
    	document.getElementById('btn-atualizar').style.display = 'block';
    }
</script>
<script>
        function limparDocumento() {
            var inputDocumento = document.getElementById('documento');
            var valor = inputDocumento.value;
            // Remover caracteres não numéricos
            var documentoLimpo = valor.replace(/\D/g, '');
            // Atualizar o valor do campo com o documento limpo
            inputDocumento.value = documentoLimpo;
        }
    </script>
</body>
</html>