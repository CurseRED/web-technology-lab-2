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
        function clear_cookie($key) {
            if (isset($_COOKIE[$key])) {
                unset($_COOKIE[$key]);
                setcookie($key, null, time()-3600, '/');
            }
        }
        function new_value() {
            $num = rand(0, 2);
            switch ($num) {
                case (0):
                    try {
                        return random_int(0, 8192);
                    } catch (Exception $e) {
                        return 0;
                    }
                case (1): {
                    $random_number_array = range(0, 31);
                    shuffle($random_number_array );
                    return $random_number_array;
                }
                default:
                    return random_string(32);

            }
        }
        function random_string($n) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            return $randomString;
        }
        function store_cookie($key, $value) {
            $data = serialize($value);
            $data = gzcompress($data);
            $data = base64_encode($data);
            setcookie($key, $data, time() + 3600, '/');
        }
        const AMOUNT_OF_DATA = 4;
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["generate"]))
            for ($i = 0; $i < AMOUNT_OF_DATA; $i++)
                store_cookie('cookie_' . $i, new_value());
    ?>
    <?php
        function fetch_cookie($key) {
            if (isset($_COOKIE[$key])) {
                $data = $_COOKIE[$key];
                $data = base64_decode($data);
                $data = gzuncompress($data);
                return unserialize($data);
            } else
                return null;
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["check"])) {
            echo '<p>Куки пользователя:</p>';
            for ($i = 0; $i < AMOUNT_OF_DATA; $i++) {
                $value = fetch_cookie('cookie_'. $i);
                if ($value == null)
                    echo '<p>' . 'Куки с названием ' . 'cookie_'. $i . ' не установлен!' . '</p>';
                else if (is_array($value)) {
                    echo '<p>' . 'Куки cookie_'. $i . '</p>';
                    echo '<p>';
                    print_r($value);
                    echo '</p>';
                } else {
                    echo '<p>'  . 'Куки cookie_'. $i . '</p>';
                    echo '<p>' . $value . '</p>';
                }
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["clear"])) {
            for ($i = 0; $i < AMOUNT_OF_DATA; $i++)
                clear_cookie('cookie_' . $i);
            echo '<p>Куки очищены!</p>';
        }
    ?>
    <form class="db-control">
        <button type="submit" name="generate">Сгенерировать куки</button>
        <button type="submit" name="check">Просмотреть куки</button>
        <button type="submit" name="clear">Очистить куки</button>
    </form>
</body>
<footer>
	<script> </script>
</footer>
</html>