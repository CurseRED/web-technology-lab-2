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
<p><b>Вариант 2:</b> Выведите форму на сайте со следующими полями: «Получатели», «Тема», «Текст сообщения» и кнопкой «Отправить». В поле «Получатели» введите через пробел или другой установленный раздельный символ(, или;)  адреса электронной почты получателей. Получите все данные из формы, проверьте их правильность, при ошибке выведите соответствующее сообще-ние, оставив  введенные в полях формы, при успешном результате проверки - разошлите письмо. Сохраните в текстовом файле список получателей.</p>
<?php
    $emails = array();
    $subject = '';
    $text = '';
    if ($_SERVER["REQUEST_METHOD"] == "GET"
            && isset($_GET["email"])
            && isset($_GET["theme"])
            && isset($_GET["text"])) {
        $emails = explode(',', $_GET["email"]);
        $subject = $_GET["theme"];
        $text = $_GET["text"];
        $fp = fopen('log.txt', 'a' . PHP_EOL);
        fwrite($fp, 'Получатели: ' . implode(', ', $emails) . PHP_EOL);
        fwrite($fp, 'Тема: ' . $subject . PHP_EOL);
        fwrite($fp, 'Сообщение: ' . $text . PHP_EOL);
        fclose($fp);
        $headers  = "Content-Type: multipart/alternative; boundary=\"----123\"\r\n";
        $headers .= "From: Maksim <max-cun4@yandex.ru>\r\n";
        $headers .= "Reply-To: max-cun4@yandex.ru\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $message = "This is multipart message using MIME\n";
        $message .= "------123\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n";
        $message .= $text;
        $message .= "------123\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n";
        $message = '<html><body><p>' . $text . '</p></body></html>';
        $message .= "------123--\r\n";
        $to = '';
        if (count($emails) > 0){
            $to = $emails[0];
            for ($i = 1; $i < count($emails); $i++)
                $headers .= "Bcc: " . $emails[$i] . "\r\n";
            if (mail($to, $subject, $message, $headers))
                echo '<p class="success">Письмо успешно отправлено!</p>';
            else
                echo '<p class="error">Ошибка при отправке письма!</p>';
        } else
            echo '<p class="error">Введите хотя бы один email!</p>';
    }
?>
<form action="./main.php" method="get" accept-charset="utf-8" class="form">
    <label>Получатели</label>
    <input type="email" multiple name="email" class="email-input" value="<?php echo implode(', ', $emails);?>"/>
    <label>Тема</label>
    <input type="text" name="theme" class="email-input" value="<?php echo $subject;?>"/>
    <label>Текст сообщения</label>
    <textarea name="text"><?php echo $text;?></textarea>
    <input type="submit" value="Отправить">
</form>
</body>
<footer>
    <script> </script>
</footer>
</html>