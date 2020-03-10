<!DOCTYPE html>
<html lang="Russian">
<head>
	<title>PHP Laboratory</title>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width=device-width, initial-scale=1">
	<meta name="author" content="maksim">
	<meta name="description" content="Page with PHP algorithms">
	<meta name="keywords" content="php, algorithm, test, input">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<ul>
	<?php
		$input = '';
		if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["button"])) {
			$input = test_input($_GET["button"]);
		}

		$about = $services = $price = $contacts = '';
		$color = 'white';

		if ($input == 'about') {
			$about = 'style="background-color:'.$color.'"';
		} elseif ($input == 'services') {
			$services = 'style="background-color:'.$color.'"';
		} elseif ($input == 'price') {
			$price = 'style="background-color:'.$color.'"';
		} elseif ($input == 'contacts') {
			$contacts = 'style="background-color:'.$color.'"';
		}

		echo '<li><a class="about" '.$about.' href="/links.php?button=about">О нас</a></li>';
		echo '<li><a class="services" '.$services.' href="/links.php?button=services">Услуги</a></li>';
		echo '<li><a class="price" '.$price.' href="/links.php?button=price">Цена</a></li>';
		echo '<li><a class="contacts" '.$contacts.' href="/links.php?button=contacts">Контакты</a></li>';

		function test_input($data) {
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	?>
	</ul>
</body>
</html>