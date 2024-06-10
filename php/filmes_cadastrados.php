<?php
session_start();
require 'db_connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM movies WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes Cadastrados</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        header {
            flex-shrink: 0;
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
        main {
            width: 60%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: rgba(168, 168, 168, 0.6);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }
        main h1 {
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #e4e4e4;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
        footer {
            flex-shrink: 0;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Filmes Cadastrados</h1>
    </header>
    <main>
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li><a href="assistir_filme.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?> (<?php echo htmlspecialchars($row['release_year']); ?>)</a></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Você não cadastrou nenhum filme ainda.</p>
        <?php endif; ?>
        <a href="index.php">Voltar</a>
    </main>
    <footer>
        <p>&copy; 2024 Fatec Movies</p>
    </footer>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
