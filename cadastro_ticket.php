<!DOCTYPE html>
<html lang="pt-br">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="cadastro_ticket.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cadastro de Tickets</title>
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
	<div class="title">
		<h1>Cadastro de Tickets</h1>
	</div>
	<div class="col mb-4">
		<h4 class="title-cliente">DADOS CLIENTE</h4>
	</div>
	<div class="dadosCliente">
		<div class="row">
			<div class="col-3 mx-auto">
				<label for="nome" class="form-label">Nome</label>
				<div class="input-group">
					<input type="text" class="form-control" name="nome" id="nome" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="cep" class="form-label">CEP</label>
				<div class="input-group">
					<input type="text" class="form-control" name="cep" id="cep" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="complemento" class="form-label">COMPLEMENTO</label>
				<div class="input-group">
					<input type="text" class="form-control" name="complemento" id="cep" value="">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-3 mx-auto">
				<label for="documento" class="form-label">CPF/CNPJ</label>
				<div class="input-group">
					<input type="text" class="form-control" name="documento" id="documento" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="endereco" class="form-label">ENDEREÇO</label>
				<div class="input-group">
					<input type="text" class="form-control" name="endereco" id="endereco" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="numero" class="form-label">NÚMERO</label>
				<div class="input-group">
					<input type="text" class="form-control" name="numero" id="numero" value="">
				</div>
			</div>
		</div>
	</div>
	<div class="col mb-4">
		<h4 class="title-produto">DADOS PRODUTO</h4>
	</div>
	<div class="dadosProduto">
		<div class="row">
			<div class="col-3 mx-auto">
				<label for="referencia" class="form-label">Referência</label>
				<div class="input-group">
					<input type="text" class="form-control" name="referencia" id="referencia" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="descricao" class="form-label">Descrição</label>
				<div class="input-group">
					<input type="text" class="form-control" name="descricao" id="descricao" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="quantidade" class="form-label">Qtde.</label>
				<div class="input-group">
					<input type="text" class="form-control" name="quantidade" id="quantidade" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="marca" class="form-label">Marca</label>
				<div class="input-group">
					<select type="text" class="form-select select2 form-control" name="marca" id="customSelect" value=""></select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-3 mx-auto">
				<label for="defeitoReclamado" class="form-label">Defeito Reclamado</label>
				<div class="input-group">
					<input type="text" class="form-control" name="defeitoReclamado" id="defeitoReclamado" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="nota" class="form-label">Nota Fiscal</label>
				<div class="input-group">
					<input type="text" class="form-control" name="nota" id="nota" value="">
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="dataNota" class="form-label">Data da Nota Fiscal</label>
				<div class="input-group">
					<input type="date" class="form-control" name="dataNota" id="dataNota" value="">
				</div>
			</div>
		</div>
	</div>
	<div class="col mb-4">
		<h4 class="title-defeitos">DEFEITOS</h4>
	</div>
	<div class="defeitos">
		<div class="row">
			<div class="col-4">
				<label for="descricao" class="form-label">Descrição</label>
				<div class="input-group">
					<textarea type="text" class="form-control custom-text-input" name="descricao" id="descricao" placeholder="Escreva os defeitos...." value=""></textarea>
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="tipoDefeito" class="form-label">Tipo de Defeito</label>
				<div class="input-group">
					<input type="text" class="form-control" name="tipoDefeito" id="tipoDefeito" value="">
				</div>
			</div>
			<div class="col-4">
				<label for="solucao" class="form-label">Solução</label>
				<div class="input-group">
					<textarea type="text" class="form-control custom-text-input" name="solucao" placeholder="Escreve as soluções...." value=""></textarea>
				</div>
			</div>
			<div class="col-3 mx-auto">
				<label for="causaDefeito" class="form-label">Causa do Defeito</label>
				<div class="input-group">
					<input type="text" class="form-control" name="causaDefeito" id="causaDefeito" value="">
				</div>
			</div>
		</div>
	</div><br>
	<footer class="footer">
		<hr>
		<div class="footer-content">
			<p>DESENVOLVIDO POR:</p>
			<img class="img-footer" src="images/logo.png" alt="Logo">
		</div>
	</footer>
	<script>
        $(document).ready(function() {
            $('.select2').select2({<div class="row">
			<div class="col-3 mx-auto">
				<label for="causaDefeito" class="form-label">Causa do Defeito</label>
				<div class="input-group">
					<input type="text" class="form-control" name="causaDefeito" id="causaDefeito" value="">
				</div>
			</div>
		</div>
                tags: true,
                placeholder: "Selecione uma opção existente ou digite uma nova...",
                createTag: function(params) {
                    return {
                        id: params.term,
                        text: params.term,
                        newOption: true
                    };
                }
            }).on('select2:select', function(e) {
                if (e.params.data.newOption) {
                    console.log('Nova opção selecionada:', e.params.data.text);
                }
            });
        });
    </script>
</body>
</html>