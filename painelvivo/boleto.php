<!DOCTYPE html>
<html>
<head>
	<title>Boleto</title>
	<style>
		body {
			font-family: Arial, sans-serif;
		}
		.container {
			margin: 0 auto;
			max-width: 700px;
			padding: 20px;
			border: 2px solid #ccc;
		}
		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}
		.header img {
			height: 50px;
		}
		.main-info {
			display: flex;
			justify-content: space-between;
			margin-bottom: 30px;
		}
		.info-block {
			display: flex;
			flex-direction: column;
			align-items: center;
			text-align: center;
			margin-bottom: 10px;
		}
		.info-block p {
			margin: 0;
		}
		.bold {
			font-weight: bold;
		}
		.separator {
			margin-bottom: 20px;
		}
		.text-right {
			text-align: right;
		}
		.subtotal-row {
			display: flex;
			justify-content: space-between;
			font-weight: bold;
			margin-bottom: 5px;
		}
		.total-row {
			display: flex;
			justify-content: space-between;
			font-size: 20px;
			margin-bottom: 30px;
		}
		.message {
			background-color: #e0e0e0;
			padding: 20px;
			margin-bottom: 30px;
		}
		.footer {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			align-items: center;
			border-top: 2px solid #ccc;
			padding-top: 20px;
			margin-top: 20px;
			font-size: 12px;
		}
		.footer p {
			margin: 0;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<img src="https://i.imgur.com/OSuapPl.png" alt="Vivo logo">
			<p>Número da conta: <span class="bold">1317925429</span></p>
		</div>
		<div class="main-info">
			<div class="info-block">
				<p>Mês de referência:</p>
				<p class="bold">02/23</p>
			</div>
			<div class="info-block">
				<p>Data de emissão:</p>
				<p class="bold">01/02/2023</p>
			</div>
			<div class="info-block">
				<p>2ª via boleto de regularização de dívida</p>
				<p class="bold">www.vivo.com.br/meuvivo</p>
			</div>
		</div>
		<div class="separator">
			<hr>
		</div>
		<div class="info-block">
			<p>Fale conosco:</p>
			<p class="bold">Central de Relacionamento *8486 ou 1058</p>
			<p class="bold">www.vivo.com.br/faleconosco</p>
		</div>
        <div class="info-block">
      <p>Vencimento</p>
      <h3>04/02/2023</h3>
    </div>

    <div class="clear"></div>

    <div class="info-block">
      <p>Seu(s) número(s) Vivo</p>
      <h3>(16) 99226-1822</h3>
    </div>

    <div class="clear"></div>

    <div class="info-block">
      <p>Total a pagar</p>
      <h2>R$ 191,99</h2>
    </div>

    <div class="clear"></div>

    <table>
      <thead>
        <tr>
          <th>O que está sendo cobrado</th>
          <th>Valor Total R$</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Serviços Contratados</td>
          <td>191,99</td>
        </tr>
        <tr>
          <td>Mês de referência: 02/2023</td>
          <td></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td>Subtotal</td>
          <td>191,99</td>
        </tr>
        <tr>
          <td>TOTAL A PAGAR</td>
          <td>191,99</td>
        </tr>
      </tfoot>
    </table>

    <div class="clear"></div>

    <div class="message-block">
      <p>Pagando sua conta em dia, você evita multa de 2% e juros de 1% ao mês.</p>
      <p>O pagamento desta conta não quita débitos anteriores.</p>
      <p>Caso tenha pago esta conta, por favor, desconsidere a mensagem.</p>
    </div>

    <div class="clear"></div>

    <div class="footer-block">
      <p>Razão Social</p>
      <h4>MERCADOPAGO.COM REPRESENTAÇÕES LTDA</h4>
      <p>CNPJ: 10.573.521/0001-91</p>
    </div>

    <div class="footer-block">
      <p>Vencimento</p>
      <h4>04/02/2023</h4>
      <p>Total a pagar - R$</p>
      <h4>191,99</h4>
      <p>Cód. Débito Automático 87967659 Nº da Conta 14235549 Mês Referência 02/2023</p>
    </div>

    <div class="footer-block">
      <p>23793.38029 61019.932179 88006.333301 1 92810000019199 Autenticação Mecânica</p>
    </div>
  </div>

</body>
</html>

		
