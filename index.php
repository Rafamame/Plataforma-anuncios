<?php
session_start();
include 'db.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO</title>

    <!-- Incluindo a biblioteca Font Awesome para os ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
        .navbar-nav .nav-item .nav-link {
            padding: 10px 20px;
            margin-right: 10px;
            background-color: #ffcc00; /* Cor amarela */
            color: #000;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .navbar-nav .nav-item .nav-link:hover {
            background-color: #ff9900; /* Amarelo escuro ao passar o mouse */
        }
        .header-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .mascote {
            max-height: 100px;
            animation: mascoteMove 2s infinite;
        }
        .platform-name {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
        @keyframes mascoteMove {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .category-section {
            margin-bottom: 50px;
            text-align: center;
        }
        .category-title {
            margin-bottom: 20px;
            color: #ffcc00;
            font-size: 1.5rem;
            display: inline-flex;
            align-items: center;
        }
        .category-title i {
            margin-right: 10px;
        }
        .card {
            background-color: #222;
            border: none;
        }
        .card-title, .card-text {
            color: #fff;
        }
        .footer {
            background-color: #333;
            padding: 20px;
            text-align: center;
        }
        .carousel-inner img {
            max-height: 180px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Navbar com os botões de "Anunciar", "Login", "Cadastrar" -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $user_sql = "SELECT nome FROM usuarios WHERE id = '$user_id'";
                        $user_result = $conn->query($user_sql);
                        $user = $user_result->fetch_assoc();
                        echo '<li class="nav-item"><a class="nav-link-logged-in">Olá, ' . htmlspecialchars($user['nome']) . '</a></li>';
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

    <!-- Cabeçalho com o mascote e o nome da plataforma -->
    <div class="header-container">
        <img src="imagens/robo2.png" alt="Mascote" class="mascote">
        <div class="platform-name">ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO</div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Categorias e Anúncios Recentes</h2>

        <?php
        // Mapear categorias para ícones com Font Awesome
        $categoria_icons = [
            'Empregos' => 'fa-briefcase',
            'Imóveis' => 'fa-home',
            'Veículos' => 'fa-car',
            'Eletrônicos' => 'fa-tv',
            'Moda' => 'fa-tshirt',
            'Serviços' => 'fa-concierge-bell',
            'Casa e Jardim' => 'fa-seedling',
            'Esportes e Lazer' => 'fa-futbol',
            'Outros' => 'fa-box-open',
            'Animais' => 'fa-paw'
        ];

        // Recuperar todas as categorias na ordem especificada
        $categorias_sql = "SELECT * FROM categorias ORDER BY FIELD(nome, 'Empregos', 'Imóveis', 'Veículos', 'Eletrônicos', 'Moda', 'Serviços', 'Casa e Jardim', 'Esportes e Lazer', 'Outros', 'Animais')";
        $categorias_result = $conn->query($categorias_sql);

        if ($categorias_result->num_rows > 0) {
            while ($categoria = $categorias_result->fetch_assoc()) {
                $categoria_id = $categoria['id'];
                $categoria_nome = htmlspecialchars($categoria['nome']);
                $icon_class = isset($categoria_icons[$categoria_nome]) ? $categoria_icons[$categoria_nome] : 'fa-tag';

                echo '<div class="category-section">';
                echo '<a href="anuncios_categoria.php?categoria_id=' . $categoria_id . '">';
                echo '<h3 class="category-title"><i class="fas ' . $icon_class . '"></i>' . $categoria_nome . '</h3>';
                echo '</a>';
                
                // Recuperar os 3 anúncios mais recentes dessa categoria
                $anuncios_sql = "SELECT * FROM anuncios WHERE categoria_id = '$categoria_id' ORDER BY data_criacao DESC LIMIT 3";
                $anuncios_result = $conn->query($anuncios_sql);

                if ($anuncios_result->num_rows > 0) {
                    echo '<div class="row">';
                    while ($anuncio = $anuncios_result->fetch_assoc()) {
                        $fotos = unserialize($anuncio['fotos']); // Deserializar as fotos
                        echo '<div class="col-md-4">';
                        echo '<div class="card">';
                        
                        // Verificar se há fotos e se são válidas
                        if (is_array($fotos) && !empty($fotos)) {
                            echo '<div id="carousel' . $anuncio['id'] . '" class="carousel slide" data-bs-ride="carousel">';
                            echo '<div class="carousel-inner">';
                            foreach ($fotos as $key => $foto) {
                                $active_class = ($key == 0) ? 'active' : '';
                                echo '<div class="carousel-item ' . $active_class . '">';
                                echo '<img src="/uploads/' . htmlspecialchars(basename($foto)) . '" class="d-block w-100" alt="Foto do Anúncio">';
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '<a class="carousel-control-prev" href="#carousel' . $anuncio['id'] . '" role="button" data-bs-slide="prev">';
                            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                            echo '<span class="visually-hidden">Anterior</span>';
                            echo '</a>';
                            echo '<a class="carousel-control-next" href="#carousel' . $anuncio['id'] . '" role="button" data-bs-slide="next">';
                            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                            echo '<span class="visually-hidden">Próximo</span>';
                            echo '</a>';
                            echo '</div>'; // Fim do carrossel
                        }

                        echo '<div class="card-body">';
                        echo '<a href="detalhes_anuncio.php?anuncio_id=' . $anuncio['id'] . '">';
                        echo '<h5 class="card-title">'. htmlspecialchars($anuncio['titulo']) .'</h5>';
                        echo '</a>';
                        echo '<p class="card-text">'. htmlspecialchars($anuncio['descricao']) .'</p>';
                        echo '<p class="card-text"><strong>R$ '. number_format($anuncio['preco'], 2, ',', '.') .'</strong></p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p class="text-center">Nenhum anúncio recente nesta categoria.</p>';
                }

                echo '</div>'; // Fim da seção da categoria
            }
        } else {
            echo '<p class="text-center">Nenhuma categoria encontrada.</p>';
        }
        ?>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2024 ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO - Todos os direitos reservados.</p>
        <p>Desenvolvido por CALV DEVELOPS LTDA</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
