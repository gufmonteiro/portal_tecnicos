<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="consulta_tickets.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produtos Atendidos</title>
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
    <div class="ultimosTickets">
        <div class="row align-items-center">
            <h1 class="col-5">ÚLTIMOS TICKETS</h1>
            <div class="col-3">
                <div class="row justify-content-center">
                    <div class="search-container">
                        <input type="search" class="form-control" placeholder="Pesquisar...">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <i class="bi bi-filter float-right"> Filtrar </i>
            </div>
            <div class="col-sm-1">
                <button class="btn btn-primary">
                    <i class="bi bi-cloud-download"> CSV </i>
                </button>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table" id="sortableTable">
                <thead>
                    <tr>
                        <th scope="col">TICKET <i class="bi bi-arrow-down-short"></i></th>
						<th scope="col">CLIENTE <i class="bi bi-arrow-down-short"></i></th>
						<th scope="col">PRODUTO <i class="bi bi-arrow-down-short"></i></th>
						<th scope="col">CIDADE <i class="bi bi-arrow-down-short"></i></th>
						<th scope="col">STATUS <i class="bi bi-arrow-down-short"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row" class="td-ticket">123456789</td>
                        <td>Gustavo</td>
                        <td>Geladeira</td>
                        <td>Marília</td>
                        <td class="status-finalizado-parcial">Finalizado Parcial</td>
                    </tr>
                    <tr>
                        <td scope="row" class="td-ticket">987654321</td>
                        <td>Lucas</td>
                        <td>Frigobar</td>
                        <td>Marília</td>
                        <td class="status-realizado">Realizado</td>
                    </tr>
                    <tr>
                        <td scope="row" class="td-ticket">145679351</td>
                        <td>Ronald</td>
                        <td>Refrigerador</td>
                        <td>Marília</td>
                        <td class="status-cancelado">Cancelado</td>
                    </tr>
                    <tr>
                        <td scope="row" class="td-ticket">145679351</td>
                        <td>Luis</td>
                        <td>Fogão</td>
                        <td>Marília</td>
                        <td class="status-em-atendimento">Em Atendimento</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="footer">
		<hr>
		<div class="footer-content">
			<p>DESENVOLVIDO POR:</p>
			<img class="img-footer" src="images/logo.png" alt="Logo">
		</div>
	</footer>
    <script>
        $(document).ready(function(){
            $('#sortableTable th').click(function(){
                var table = $(this).parents('table').eq(0);
                var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
                this.asc = !this.asc;
                if (!this.asc){ rows = rows.reverse(); }
                for (var i = 0; i < rows.length; i++){ table.append(rows[i]); }
            });
            function comparer(index) {
                return function(a, b) {
                    var valA = getCellValue(a, index), valB = getCellValue(b, index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
                };
            }
            function getCellValue(row, index){ return $(row).children('td').eq(index).text(); }
        });
    </script>
</body>
</html>