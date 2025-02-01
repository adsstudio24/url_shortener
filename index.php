<?php
$conn = new mysqli('localhost', 'root', '', 'url_shortener');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $original_url = $_POST['url'];
    $short_code = substr(md5(time()), 0, 6);
    $conn->query("INSERT INTO links (short_code, original_url) VALUES ('$short_code', '$original_url')");
    echo "📏 Коротке посилання: <a href='?c=$short_code'>http://site.com/$short_code</a>";
}

if (isset($_GET['c'])) {
    $code = $_GET['c'];
    $result = $conn->query("SELECT original_url FROM links WHERE short_code = '$code'");
    if ($row = $result->fetch_assoc()) {
        header("Location: " . $row['original_url']);
    } else {
        echo "❌ Посилання не знайдено.";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Скорочувач URL</title>
</head>
<body>
    <form method="post">
        <input type="url" name="url" placeholder="Вставте посилання" required>
        <button type="submit">✂️ Скоротити</button>
    </form>
</body>
</html>
