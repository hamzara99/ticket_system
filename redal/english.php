<?php
	require_once "init.php";
	unset($_SESSION['ticket_id']);
	if(!isset($_SESSION['ticket_id'])){
		$_SESSION['ticket_id'] = createTicket();
	}
	
	$MyTicket = getTicketInfos($_SESSION['ticket_id']);
	$ticketsFun = getTicketsList();

	$ticketsList = $ticketsFun['results'];
	$ticketsCount = $ticketsFun['count'];

	$ticketsNoValid = array();
	foreach ($ticketsList as $key => $value) {
		if($value['validee'] == 0){
			$ticketsNoValid[$value['id']] = $value;
			continue;
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Redal Agency - Customer Service Ticket System</title>
	<style>
		body {
			font-family: 'Open Sans', sans-serif;
			background-color: #f4f9f9;
			background-image: url(bg2.png);
			background-size: cover;
			background-repeat: no-repeat;

		}

		.container {
			margin: 50px auto;
			padding: 20px;
			background-color: white;
			border-radius: 5px;
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			max-width: 400px;
			text-align: center;
		}

		h1 {
			font-size: 24px;
			color: #555;
			margin-top: 0;
			margin-bottom: 10px;
		}

		p {
			font-size: 18px;
			margin-bottom: 10px;
			line-height: 1.5;
		}

		.number {
			font-size: 48px;
			color: #e60000;
			margin-top: 0;
			margin-bottom: 10px;
		}

		.date {
			font-size: 18px;
			color: #555;
			margin-bottom: 0;
		}

		.logo {
			width: 60px;
			height: 60px;
			margin-bottom: 10px;
		}

		.thank-you {
			font-size: 18px;
			color: #e60000;
			margin-top: 20px;
		}

		.cancel-button {
			background-color: #555;
			color: white;
			padding: 5px 10px;
			border: none;
			border-radius: 3px;
			font-size: 14px;
			cursor: pointer;
			margin-top: 10px;
		}

		.cancel-button:hover {
			background-color: #333;
		}
	</style>
</head>
<body>

	<div class="container">
		<img class="logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0iPE-Kui0IF45NHt0CLT-D1GFwCPTo_QcW6zKCp_t&s">
		<h1>Get your ticket for customer service</h1>
		<p>Thank you for choosing Agence Redal <?= $localisation ?>.Your ticket number is:</p>
		<p class="number"> <?= $MyTicket['ticket_numero'] ?> </p>
		<p><span id="visitor-count"> <?= (count($ticketsNoValid) - 1)  ?> </span></p>
		<p class="date"><span id="current-time"></span></p>
		 <p id="seconds"></p>
		<button class="cancel-button" onclick="window.history.back()">Cancel ticket</button>
		<p class="thank-you">Thank you for your patience !</p>
	</div>
	<script>
		setInterval(() => {
			var now = new Date();
			var dateStr = now.toLocaleDateString('fr-FR');
			var timeStr = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
			document.getElementById('current-time').textContent = "Actual hour : " + dateStr + ' ' + timeStr;
		}, 1000);
		let seconds = 0;
		setInterval(function(){
			seconds++;
			document.getElementById('seconds').textContent = "Time elapsed : " + seconds + " secondes";
}, 1000);
	setTimeout(function(){
		window.history.back();
	}, 20000);
</script>
</body>
 </html>