<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria - ANUNCINGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos semelhantes às outras páginas */
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
        .category-header {
            margin-bottom: 20px;
            color: #ffcc00; /* Cor amarela para o título da categoria */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">ANUNCINGA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                    session_start();
                    if(isset($_SESSION['user_id'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="criar_anuncio.php">Criar Anúncio</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastrar</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php
        if(isset($_GET['categoria']) && is_numeric($_GET['categoria'])) {
            $categoria_id = intval($_GET['categoria']);
            // Obter o nome da categoria
            $categoria_nome_sql = "SELECT nome FROM categorias WHERE id = '$categoria_id'";
            $categoria_nome_result = $conn->query($categoria_nome_sql);
            if($categoria_nome_result->num_rows > 0) {
                $categoria_nome = $categoria_nome_result->fetch_assoc()['nome'];
                echo '<h2 class="text-center category-header">Categoria: ' . htmlspecialchars($categoria_nome) . '</h2>';
            } else {
                echo '<h2 class="text-center category-header">Categoria Não Encontrada</h2>';
            }

            // Obter os anúncios da categoria
            $sql = "SELECT a.*, c.nome AS categoria_nome FROM anuncios a
                    JOIN categorias c ON a.categoria_id = c.id
                    WHERE a.categoria_id = '$categoria_id'
                    ORDER BY a.data_criacao DESC LIMIT 10";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="row">';
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-4">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">'. htmlspecialchars($row['titulo']) .'</h5>';
                    echo '<p class="card-text">'. htmlspecialchars($row['descricao']) .'</p>';
                    echo '<p class="card-text"><strong>R$ '. number_format($row['preco'], 2, ',', '.') .'</strong></p>';
                    echo '<p class="card-text"><em>Categoria: '. htmlspecialchars($row['categoria_nome']) .'</em></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p class="text-center">Sem anúncios disponíveis para esta categoria.</p>';
            }
        } else {
            echo '<p class="text-center">Categoria inválida.</p>';
        }
        ?>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2024 ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script> <!-- Referência ao seu script JS -->
</body>
</html>
