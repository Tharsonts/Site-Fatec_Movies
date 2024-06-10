<?php
session_start();
require 'db_connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if (!isset($_GET['id'])) {
    die('ID do filme não fornecido.');
}

$movie_id = $_GET['id'];


$sql = "SELECT * FROM movies WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $movie_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die('Filme não encontrado ou você não tem permissão para assisti-lo.');
}

$movie = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?></title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        video {
            width: 80%;
            height: auto;
        }
    </style>
</head>
<body>
    <video controls>
        <source src="uploads/<?php echo htmlspecialchars($movie['file_name']); ?>" type="video/mp4">
        Seu navegador não suporta a reprodução de vídeos.
    </video>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>