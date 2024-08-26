<!DOCTYPE html>
<html lang="pt-br">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" type="text/css" href="agendamentos.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="jsCallendar/index.global.min.js"></script>
	<script>

	      document.addEventListener('DOMContentLoaded', function() {
	        var calendarEl = document.getElementById('calendar');
	        var calendar = new FullCalendar.Calendar(calendarEl, {
	          initialView: 'dayGridMonth',
	          locale: 'pt-br'
	        });
	        calendar.render();
	      });

	    </script>
	<title>
		Agendamentos
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
	<div id='calendar'></div><br>
	<footer class="footer">
		<hr>
		<div class="footer-content">
			<p>DESENVOLVIDO POR:</p>
			<img class="img-footer" src="images/logo.png" alt="Logo">
		</div>
	</footer>
	
</body>
</html>