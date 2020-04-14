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
	<p><b>Вариант 12:</b> В произвольном тесте (длинный текст) выполнить.  При вводе слова в форму поиска необходимо найти все упоминания этого слова в тексте и выделить (подсветить) цветом, жирным или другим настраивающим способом. В случае, если указываются 2 слова, то каждое должно искаться индивидуально, если словосочетание указывается в кавычках, то ищется как единое словосочетание. Помимо грубого поиска так же должен выполнятся поиск слова с разными окончаниями: Родина, Родины, Родиной..  Искомое слово получить через веб-форму. Текст получать из файла.</p>
	<form action="./main.php" method="get" accept-charset="utf-8">
		<label>Введите слова или словосочетания в двойных кавычках, которые хотите найти в тексте:</label>
		<textarea name="comment"></textarea>
		<input type="submit" value="Найти">
	</form>
</body>
<footer>
	<script> </script>
</footer>
</html>