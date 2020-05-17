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
	<?php
        function cell_wrap($text, $tag = 'td') {
            return "<$tag>$text</$tag>";
        }
        function print_db($connection, $table_name) {
            $query = "SELECT * FROM $table_name";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                echo '<table>';
                echo cell_wrap(cell_wrap('Идентификатор', 'th')
                    . cell_wrap('Название', 'th')
                    . cell_wrap('Жанр', 'th')
                    . cell_wrap('Имя автора', 'th'), 'tr');
                while ($row = $result->fetch_assoc()) {
                    $query = "SELECT name FROM author WHERE id='" . $row['author_id'] . "'";
                    $res = $connection->query($query);
                    $arr = $res->fetch_assoc();
                    echo cell_wrap(cell_wrap($row['id'])
                    . cell_wrap($row['title'])
                    . cell_wrap($row['genre'])
                    . cell_wrap($arr['name']), 'tr');
                }
                echo '</table>';
            } else
                echo '<p>Нет результатов!</p>';
        }
        $username = 'root';
        $servername = 'localhost';
        $password = '';
        $dbname = 'library';
        // Создаем соединение с БД
        $connection = new mysqli($servername, $username, $password, $dbname);
        if ($connection->connect_error) {
            die('Ошибка подключения: ' . $connection->connect_error);
        }
        echo '<p>Подключение успешно выполнено!</p>';
        $connection->set_charset('UTF8');
        $connection->query("SET CHARACTER SET 'UTF8'");
        $connection->query("SET CHARSET 'UTF8'");
        $connection->query("SET NAMES 'UTF8'");
        // Обработка нажатия кнопки удалить
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && isset($_GET['delete'])) {
            $id = $_GET["id"];
            $query = "DELETE FROM books WHERE id=$id";
            if ($connection->query($query) !== TRUE) {
                echo "<p>Ошибка при удалении записи! (" . $connection->error . ")</p>";
            }
        }
        // Обработка нажатия кнопки добавить/обновить
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])
                && isset($_GET["title"])
                && isset($_GET["genre"])
                && isset($_GET["author_id"])
                && (isset($_GET['update'])) || (isset($_GET['add']))) {
            $id = $_GET["id"];
            $title = $_GET["title"];
            $genre = $_GET["genre"];
            $author_id = $_GET["author_id"];
            $query = '';
            if (isset($_GET['update']))
                $query = "UPDATE books SET id='$id', title='$title', genre='$genre', author_id='$author_id' WHERE id=$id";
            else
                $query = "INSERT INTO books (id, title, genre, author_id) VALUES ('$id', '$title', '$genre', '$author_id')";
            if ($connection->query($query) !== TRUE) {
                echo "<p>Ошибка при добавлении/обновлении записи! (" . $connection->error . ")</p>";
            }
        }
	?>
    <div style="overflow-x: auto">
        <?php
            print_db($connection, 'books');
            $connection->close();
        ?>
    </div>
	<form method="get">
        <div class="db-control">
            <div class="db-field">
                <label>Идентификатор</label>
                <input type="number" name="id">
            </div>
            <div class="db-field">
                <label>Название</label>
                <input type="text" name="title">
            </div>
            <div class="db-field">
                <label>Жанр</label>
                <input type="text" name="genre">
            </div>
            <div class="db-field">
                <label>Идентификатор автора</label>
                <input type="number" name="author_id">
            </div>
        </div>
		<div class="db-control">
			<button type="submit" name="add">Добавить</button>
			<button type="submit" name="delete">Удалить</button>
			<button type="submit" name="update">Изменить</button>
		</div>
	</form>
</body>
<footer>
	<script> </script>
</footer>
</html>