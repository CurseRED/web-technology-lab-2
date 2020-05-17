<!DOCTYPE html>
<html lang="Russian">
<head>
	<title>PHP Laboratory</title>
	<meta charset="utf-8">
	<meta name = "viewport" content = "width=device-width, initial-scale=1">
	<meta name="author" content="maksim">
	<meta name="description" content="Page with PHP algorithms">
	<meta name="keywords" content="php, algorithm, test, input">
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<p><b>Вариант 3:</b> написать функцию, определяющую точный возраст человека (с точностью до одного дня) по его дате рождения. Дату рождения получать через веб-форму. Определить дату, когда человеку исполнится, например, 10000 дней (получать через веб-форму). Определить год человека по восточному календарю.</p>
	<?php
		$input = '0';
		$value = '';
		if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["error"]) && isset($_GET["value"])) {
			$input = test_input($_GET["error"]);
			$value = test_input($_GET["value"]);
		}
	?>
	<?php
		if ($input == "1") {
			echo '<p style="text-align:center">'.'Введите правильную дату!'.'</p>';
		} elseif ($input == "2") {
			echo '<p style="text-align:center">'.'Введите положительное число!'.'</p>';
		}

		function test_input($data) {
			$data = trim($data);
			$data = stripcslashes($data);
			$data = strip_tags($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	?>
	<form action="./main.php" method="get" accept-charset="utf-8">
		<label>Введите дату рождения:</label>
		<input type="date" name="date" <?php if ($input == "1") echo 'style="background-color: red"'; if ($input == "2") echo 'value='.$value;?>></input>
		<label>Дата когда вам будет N дней:</label>
		<input type="number" name="number" <?php if ($input == "2") echo 'style="background-color: red"'; if ($input == "1") echo 'value='.$value;?>></input>
		<input type="submit" value="Вычислить">
	</form>
</body>
<footer>
	<script> </script>
</footer>
</html>