<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = password_hash(mysqli_real_escape_string($conn, $_POST['senha']), PASSWORD_DEFAULT);
    $telegram = mysqli_real_escape_string($conn, $_POST['telegram']);
    $twitter = mysqli_real_escape_string($conn, $_POST['twitter']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);

    $sql = "INSERT INTO usuarios (nome, email, senha, telegram, twitter, linkedin, whatsapp) 
            VALUES ('$nome', '$email', '$senha', '$telegram', '$twitter', '$linkedin', '$whatsapp')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ANUNCINGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluindo Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #000; /* Fundo preto */
            color: #fff; /* Texto branco */
        }
        .navbar {
            background-color: #333; /* Navbar escura */
        }
        .navbar-brand {
            font-size: 1.5rem; /* Aumenta o tamanho da fonte */
            font-weight: bold; /* Deixa o texto em negrito */
            color: #ffcc00; /* Cor amarela */
            transition: color 0.3s ease, transform 0.3s ease; /* Efeito de transição */
        }
        .navbar-brand:hover {
            color: #ff9900; /* Cor amarela escura ao passar o mouse */
            transform: scale(1.1); /* Efeito de zoom ao passar o mouse */
        }
        .nav-link {
            padding: 10px 20px;
            background-color: #ffcc00; /* Cor amarela */
            color: #000;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #ff9900; /* Amarelo escuro ao passar o mouse */
            color: #000;
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
            color: #000; /* Texto escuro */
        }
        .btn-custom:hover {
            background-color: #ff9900; /* Cor ao passar o mouse */
        }
        .footer {
            background-color: #333;
            padding: 20px;
            text-align: center;
        }
        .form-label {
            color: #ffcc00; /* Destaque nas labels */
            font-weight: bold;
        }
        .form-control::placeholder {
            color: #ccc; /* Placeholder mais claro */
        }
        /* Estilos para organizar os campos de redes sociais em uma linha */
        .social-fields {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }
        .social-field {
            flex: 1;
            display: flex;
            align-items: center;
        }
        .social-field i {
            margin-right: 8px;
            font-size: 1.5rem;
        }
        /* Cores oficiais dos ícones */
        .whatsapp-icon {
            color: #25D366;
        }
        .telegram-icon {
            color: #0088cc;
        }
        .twitter-icon {
            color: #1DA1F2;
        }
        .linkedin-icon {
            color: #0077B5;
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
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Cadastro de Usuário</h2>
        <div class="card p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Endereço de Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Escolha uma senha segura" required>
                </div>

                <!-- Redes sociais dispostas em uma linha -->
                <div class="social-fields">
                    <div class="social-field">
                        <i class="fab fa-whatsapp whatsapp-icon"></i>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="WhatsApp">
                    </div>
                    <div class="social-field">
                        <i class="fab fa-telegram telegram-icon"></i>
                        <input type="text" class="form-control" id="telegram" name="telegram" placeholder="Telegram">
                    </div>
                    <div class="social-field">
                        <i class="fab fa-twitter twitter-icon"></i>
                        <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter">
                    </div>
                    <div class="social-field">
                        <i class="fab fa-linkedin linkedin-icon"></i>
                        <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="LinkedIn">
                    </div>
                </div>

                <button type="submit" class="btn btn-custom w-100 mt-4">Cadastrar</button>
            </form>
        </div>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2024 ANUNCINGA - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
