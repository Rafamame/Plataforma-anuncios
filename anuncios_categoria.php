<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anúncios por Categoria - ANUNCINGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000; /* Fundo preto */
            color: #fff; /* Texto branco */
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
        .category-title {
            margin-bottom: 20px;
            color: #ffcc00;
            text-align: center;
            font-size: 1.5rem;
        }
        .card-img-top {
            max-height: 180px;
            object-fit: cover;
        }
        .carousel-inner img {
            max-height: 180px;
            object-fit: cover;
        }
        /* Estilos para as setas do carrossel */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: transparent; /* Fundo transparente */
            color: #ffcc00; /* Apenas a cor da seta será amarela */
        }
    </style>
</head>
<body>
    <div class="header-container">
        <img src="imagens/robo2.png" alt="Mascote" class="mascote">
        <div class="platform-name">ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO</div>
    </div>

    <div class="container mt-5">
        <?php
        if (isset($_GET['categoria_id'])) {
            $categoria_id = intval($_GET['categoria_id']);
            
            $categoria_sql = "SELECT nome FROM categorias WHERE id = '$categoria_id'";
            $categoria_result = $conn->query($categoria_sql);
            $categoria = $categoria_result->fetch_assoc();
            $categoria_nome = htmlspecialchars($categoria['nome']);

            echo '<h2 class="category-title">Anúncios em ' . $categoria_nome . '</h2>';
            
            $anuncios_sql = "SELECT * FROM anuncios WHERE categoria_id = '$categoria_id' ORDER BY data_criacao DESC";
            $anuncios_result = $conn->query($anuncios_sql);

            if ($anuncios_result->num_rows > 0) {
                echo '<div class="row">';
                while ($anuncio = $anuncios_result->fetch_assoc()) {
                    $fotos = unserialize($anuncio['fotos']); 

                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-4">';

                    // Adicionar link para a página de detalhes do anúncio
                    echo '<a href="detalhes_anuncio.php?anuncio_id=' . $anuncio['id'] . '">';
                    if (is_array($fotos) && !empty($fotos)) {
                        echo '<div id="carousel' . $anuncio['id'] . '" class="carousel slide" data-bs-ride="carousel">';
                        echo '<div class="carousel-inner">';
                        foreach ($fotos as $key => $foto) {
                            $active_class = ($key == 0) ? 'active' : '';
                            echo '<div class="carousel-item ' . $active_class . '">';
                            echo '<img src="' . htmlspecialchars($foto) . '" class="d-block w-100" alt="Foto do Anúncio">';
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
                        echo '</div>';
                    }
                    echo '</a>'; // Fim do link para o anúncio

                    echo '<div class="card-body">';
                    // Adicionar link no título para os detalhes do anúncio
                    echo '<a href="detalhes_anuncio.php?anuncio_id=' . $anuncio['id'] . '">';
                    echo '<h5 class="card-title">' . htmlspecialchars($anuncio['titulo']) . '</h5>';
                    echo '</a>';
                    echo '<p class="card-text">' . htmlspecialchars($anuncio['descricao']) . '</p>';
                    echo '<p class="card-text"><strong>R$ ' . number_format($anuncio['preco'], 2, ',', '.') . '</strong></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p class="text-center">Nenhum anúncio encontrado nesta categoria.</p>';
            }
        } else {
            echo '<p class="text-center">Categoria não especificada.</p>';
        }
        ?>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2024 ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
