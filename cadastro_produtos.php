 <?php 

//Eliminar Warning
ini_set('display_errors', 'off');

//Variável de Erro
$msg_erro_cadastro = array();
$msg_success_cadastro = array();
$msg_erro_pesquisa = array();
$msg_success_pesquisa = array();

//CADASTRAR PRODUTO
if (isset($_POST['btnCadastrar'])) {
	//Pega dados do Form
	$referencia = $_POST['referencia'];
	$descricao = $_POST['descricao'];
    $voltagem = $_POST['voltagem'];
	$origem = $_POST['origem'];
    $fabrica = $_POST['fabrica'];
    $ativo = isset($_POST['ativo']) ? true : false;
    $tempo_garantia = $_POST['tempo_garantia'];

    // Limpa mensagens de cadastro
    $msg_erro_pesquisa = array();
    $msg_success_pesquisa = array();

	//Obriga preencher os Campos
	if (strlen($referencia) == 0) {
		$msg_erro_cadastro['msg'][] = "Informe a Referência!";
	}
	if (strlen($descricao) == 0) {
		$msg_erro_cadastro['msg'][] = "Informe a Descrição!";
	}
    if (strlen($voltagem) == 0) {
        $msg_erro_cadastro['msg'][] = "Informe a Voltagem!";
    }
    if (strlen($origem) == 0) {
        $msg_erro_cadastro['msg'][] = "Informe a Origem!";
    }
	if (strlen($fabrica) == 0) {
		$msg_erro_cadastro['msg'][] = "Informe a Fábrica!";
	}
	if (strlen($tempo_garantia) == 0) {
		$msg_erro_cadastro['msg'][] = "Informe a Garantia!";
	}

	//Se não houver erros, prossegue
    if (empty($msg_erro)) {
    // Formata os dados como JSON
    	$data = json_encode([
	        "referencia" => $referencia,
	        "descricao" => $descricao,
            "voltagem" => $voltagem,
            "origem" => $origem,
	        "fabrica" => $fabrica,
            "ativo" => $ativo,
            "tempo_garantia" => $tempo_garantia
	    ]);

   		// Inicializa o cURL POST
	    $curlPOST = curl_init();
	    curl_setopt_array($curlPOST, array(
	    	CURLOPT_URL => 'https://api2.telecontrol.com.br/ticket-checkin/produto-portal',
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

		// Verifica se a requisição foi bem sucedida
		if ($httpCodePOST == 200) {
			$msg_success_cadastro['msg'][] = "Produto cadastrado com Sucesso!";
		} else {
			// Se der erro, pega a mensagem de erro da API
			$responseDataPOST = json_decode($responsePOST, true); // Converte o JSON em array

			if(isset($responseDataPOST['error'])) {
				$msg_erro_cadastro['msg'][] = "Erro ao cadastrar Produto: " . $responseDataPOST['error'];
			} else {
				$msg_erro_cadastro['msg'][] = "Erro ao cadastrar Produto2!" . $responsePOST;
			}
		}
	}
}

$produtos_pagina = array();

//BUSCAR PRODUTOS
if (isset($_POST['btnPesquisar'])) {
    $fabricaId = $_POST['fabrica'];

    // Limpa mensagens de cadastro
    $msg_erro_cadastro = array();
    $msg_success_cadastro = array();

    //Verifica se foi selecionada a fábrica
    if (strlen($fabricaId) == 0) {
        $msg_erro_pesquisa['msg'][] = "Selecione uma Fábrica para Pesquisar!";
    }else {
        //Inicializa cURL para pesquisar
        $curlGET = curl_init();
        $apiUrl = 'https://api2.telecontrol.com.br/ticket-checkin/produto-portal?fabrica=' . $fabricaId;
        
        curl_setopt_array($curlGET, array(
            CURLOPT_URL => $apiUrl,
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
        $httpCodeGET = curl_getinfo($curlGET, CURLINFO_HTTP_CODE);
        curl_close($curlGET);

        if ($httpCodeGET == 200) {
            $produtos_pagina = json_decode($responseGET, true);
        } else {
            $msg_erro['msg'][] = "Erro ao buscar produtos: " . $responseGET;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="cadastro_produtos.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Produtos Atendidos
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
		<h1>Cadastro de Produtos</h1>
	</div>
	<div class="cadastroProduto">
		<form action="" method="POST">
        <?php if (count($msg_erro_pesquisa) > 0){ ?>
            <div id="alert-danger" class="alert alert-danger"><?php echo implode("<br>", $msg_erro_pesquisa['msg']); ?></div>
        <?php } ?>
		<?php if (count($msg_erro_cadastro) > 0){ ?>
    		<div id="alert-danger" class="alert alert-danger"><?php echo implode("<br>", $msg_erro_cadastro['msg']); ?></div>
    	<?php } ?>
    	<!-- DIV success para mensagens de sucesso -->
    	<?php if(count($msg_success_cadastro) > 0){ ?>
    	    <div id="alert-success" class="alert alert-success"><?php echo implode("<br>", $msg_success_cadastro['msg']); ?></div>
    	<?php } ?>
		<div class="row">
			<div class="col-3 mx-auto">
				<label>Referência:</label>
				<div class="input-group">
					<input type="text" class="form-control" name="referencia" id="referencia" value="<?php echo $referencia ?>">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label>Descrição:</label>
				<div class="input-group">
					<input type="text" class="form-control" name="descricao" id="descricao" value="<?php echo $descricao ?>">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label>Fábrica:</label>
				<div class="input-group">
					<select id="fabrica" name="fabrica" class="form-select select2" aria-label="Escolha a fábrica">
	            		<option value="<?php echo $fabrica ?>"></option>
                        <?php
                        // Inicializa o cURL para fazer a requisição GET
                        $curlGET = curl_init();

                        $apiUrl = 'https://api2.telecontrol.com.br/ticket-checkin/fabrica-portal';
                        
                        // Define as opções do cURL
                        curl_setopt_array($curlGET, array(
                            CURLOPT_URL => $apiUrl,
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

                        // Executa a requisição cURL
                        $response = curl_exec($curlGET);

                        // Verifica se houve algum erro na requisição
                        if ($response === false) {
                            echo 'Erro ao buscar fábricas: ' . curl_error($curlGET);
                        } else {
                        // Decodifica a resposta JSON em um array associativo PHP
                            $fabricas = json_decode($response, true);

                            // Filtra fábricas ativas
                            $fabricas_ativas = array_filter($fabricas, function($fabrica) {
                                return $fabrica['ativo'] == 1;
                            });

                            // Preenche o select com as opções das fábricas
                            foreach ($fabricas_ativas as $fabrica) {
                                $selected = (isset($_POST['fabrica']) && $fabrica['fabrica'] == $_POST['fabrica']) ? 'selected' : '';
                                echo '<option value="' . $fabrica['fabrica'] . '" ' . $selected . '>' . $fabrica['nome'] . '</option>';
                            }
                        }

                        // Fecha a sessão cURL
                        curl_close($curlGET);

                        ?>
	        		</select>
	        	</div>
			</div>
		</div>
		<div class="row">
			<div class="col-3 mx-auto">
				<label>Origem:</label>
				<div class="input-group">
					<input type="text" maxlength="2" class="form-control" name="origem" id="origem" value="<?php echo $origem ?>">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label>Voltagem:</label>
				<div class="input-group">
					<input type="text" class="form-control" name="voltagem" id="voltagem" value="<?php echo $voltagem ?>">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label>Garantia:</label>
				<div class="input-group">
					<input type="text" class="form-control" name="tempo_garantia" id="tempo_garantia" value="<?php echo $tempo_garantia ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-3 mx-auto">
				<label>Ativo:</label>
				<div class="input-group">
					<input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="<?php echo $ativo ?>">
				</div>
			</div>
		</div><br><br>
		<div class="row">
			<div class="col mx-auto text-center">
				 <input type="hidden" name="btnCadastrar" value="1">
                    <input class="btn btn-primary btn-cadastrar" type="submit" value="Cadastrar" name="btnCadastrar">
			</div>
		</div><br>
        <div class="row">
            <div class="col mx-auto text-center">
                 <input type="hidden" name="btnPesquisar" value="1">
                    <input class="btn btn-secondary btn-pesquisar" type="submit" value="Pesquisar" name="btnPesquisar">
            </div>
        </div>
	</div><br>
	<h2>Produtos Cadastrados</h2>
	<table class="table">
		<thead>
			<tr>
		      	<th scope="col-3 mx-auto">Fabrica</th>
		      	<th scope="col-3 mx-auto">Referência</th>
		      	<th scope="col-3 mx-auto">Descrição</th>
		      	<th scope="col-3 mx-auto">Origem</th>
		      	<th scope="col-3 mx-auto">Voltagem</th>
		      	<th scope="col-3 mx-auto">Garantia</th>
		      	<th scope="col-3 mx-auto">Ativo</th>
		      	<th scope="col-3 mx-auto">Ações</th>
		    </tr>
	  	</thead>
	  	<tbody>
	  		<?php foreach ($produtos_pagina as $produto) : ?>
	  			<tr id="row-<?php echo $produto['fabrica']; ?>">
                    <td class="text-center"><?php echo $produto['referencia']; ?></td>
                    <td class="text-center"><?php echo $produto['descricao']; ?></td>
                    <td class="text-center"><?php echo $produto['fabrica']; ?></td>
                    <td class="text-center"><?php echo $produto['origem']; ?></td>
                    <td class="text-center"><?php echo $produto['voltagem']; ?></td>
                    <td class="text-center"><?php echo $produto['garantia']; ?></td>                        
                    <td class="text-center"><?php echo $produto['ativo'] ? 'Sim' : 'Não'; ?></td>
                    <td class="d-flex justify-content-center align-items-center">
                    	<?php if ($produto['ativo']) : ?>
                    		<form method="POST" action="">
							    <input type="hidden" name="desativar" value="desativar">
							    <input type="hidden" name="documento" value="<?php echo $produto['referencia']; ?>">
							    <button type="submit" class="btn btn-danger">Inativar</button>
							    <button type="button" class="btn btn-primary btn-editar" onclick="editarRegistro(this)" data-documento="<?php echo $produto['referencia']; ?>">Editar</button>
							</form>
                    	<?php else : ?>
                    		<form method="POST" action="">
								<input type="hidden" name="ativar" value="ativar">
				    			<input type="hidden" name="documento" value="<?php echo $produto['referencia']; ?>">
				    			<button type="submit" class="btn btn-success">Ativar</button><br>
				    		</form>
				    	<?php endif; ?>
				    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
	</table><br><br>
	<footer class="footer">
		<hr>
		<div class="footer-content">
			<p>DESENVOLVIDO POR:</p>
			<img class="img-footer" src="images/logo.png" alt="Logo">
		</div>
	</footer>
	<script>
		$(document).ready(function() {
			$('#linha').select2({
				tags: true,
				tokenSeparators: [',', ' ']
			});
		});
</script>
</body>
</html>