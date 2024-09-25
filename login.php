<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
        } else {
            echo "<div class='alert alert-danger text-center'>Senha incorreta.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Usuário não encontrado.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ANUNCINGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; /* Fundo preto */
            color: #fff; /* Texto branco */
        }
        .navbar {
            background-color: #333; /* Navbar escura */
        }
        .navbar-brand, .nav-link {
            color: #fff;
        }
        .card {
            background-color: #222; /* Fundo do card preto */
            border: none;
        }
        .card-title, .card-text {
            color: #fff; /* Texto dentro do card branco */
        }
        .btn-custom {
            background-color: #ffcc00; /* Botões amarelos */
            color: #000;
        }
        .btn-custom:hover {
            background-color: #ff9900;
        }
        .footer {
            background-color: #333;
            padding: 20px;
            text-align: center;
        }
        label {
            color: #ffcc00; /* Labels em amarelo */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">ANUNCINGA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro.php">Cadastrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Login</h2>
        <div class="card p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Digite seu e-mail">
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required placeholder="Digite sua senha">
                </div>
                <button type="submit" class="btn btn-custom w-100">Login</button>
            </form>
        </div>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2024 ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script> <!-- Assumindo que o arquivo está em uma pasta "js" -->
</body>
</html>
