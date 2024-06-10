<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$error_message = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $username, $email, $user_id);

    if ($stmt->execute()) {
        $message = "Perfil atualizado com sucesso!";
    } else {
        $message = "Erro ao atualizar perfil.";
    }
    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);


    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($current_password, $hashed_password)) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $new_password, $user_id);
        if ($stmt->execute()) {
            $message = "Senha alterada com sucesso!";
        } else {
            $message = "Erro ao alterar a senha.";
        }
        $stmt->close();
    } else {
        $error_message = "Senha atual incorreta.";
    }
}


$sql = "SELECT username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die('Usuário não encontrado.');
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações do Perfil</title>
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
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .form-group label {
            flex: 1;
            margin-right: 10px;
            font-weight: bold;
        }
        .form-group input {
            flex: 2;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .message {
            color: green;
            margin-bottom: 15px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
        footer {
            flex-shrink: 0;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }
        .hidden {
            display: none;
        }
    </style>
    <script>
        function togglePasswordChange() {
            const passwordChangeSection = document.getElementById('passwordChangeSection');
            if (passwordChangeSection.classList.contains('hidden')) {
                passwordChangeSection.classList.remove('hidden');
            } else {
                passwordChangeSection.classList.add('hidden');
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Configurações do Perfil</h1>
    </header>
    <main>
        <h1>Informações Pessoais</h1>
        <br>
        <br>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="configuracoes.php">
            <div class="form-group">
                <label for="username">Nome de Usuário:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" value="********" readonly>
                <button type="button" onclick="togglePasswordChange()">Alterar Senha</button>
            </div>
            <div class="form-group">
                <label>Data de Criação:</label>
                <p><?php echo htmlspecialchars($user['created_at']); ?></p>
            </div>
            <div class="form-group">
                <label>Assinatura:</label>
                <p>Nenhuma</p>
            </div>
            <div class="form-group">
                <button type="submit" name="update_profile">Atualizar Perfil</button>
            </div>
        </form>
        <div id="passwordChangeSection" class="hidden">
            <hr>
            <br>
            <h2>Trocar Senha</h2>
            <br>
            <form method="POST" action="configuracoes.php">
                <div class="form-group">
                    <label for="current_password">Senha Atual:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <?php if ($error_message): ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="new_password">Nova Senha:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="change_password">Confirmar</button>
                </div>
            </form>
        </div>
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
