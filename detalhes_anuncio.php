<?php
session_start();
include 'db.php';

if (isset($_GET['anuncio_id'])) {
    $anuncio_id = intval($_GET['anuncio_id']);
    
    $sql = "SELECT * FROM anuncios WHERE id = '$anuncio_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $anuncio = $result->fetch_assoc();
        $fotos = unserialize($anuncio['fotos']);
        $video = $anuncio['video'];
        $usuario_id = $anuncio['usuario_id'];
    } else {
        echo "Anúncio não encontrado.";
        exit();
    }
} else {
    echo "ID do anúncio não fornecido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Anúncio - ANUNCINGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .navbar {
            background-color: #333;
        }
        .navbar-brand, .nav-link {
            color: #fff;
        }
        .carousel-inner img {
            max-height: 300px;
            object-fit: cover;
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
        .social-link i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">ANUNCINGA</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4"><?php echo htmlspecialchars($anuncio['titulo']); ?></h2>
        <div class="row">
            <div class="col-md-8">
                <?php if (is_array($fotos) && !empty($fotos)) { ?>
                    <div id="carouselAnuncio" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($fotos as $key => $foto) { ?>
                                <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>">
                                    <img src="/uploads/<?php echo basename($foto); ?>" class="d-block w-100" alt="Foto do Anúncio">
                                </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAnuncio" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselAnuncio" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>
                <?php } else { ?>
                    <p class="text-center">Nenhuma foto disponível.</p>
                <?php } ?>

                <?php if ($video) { ?>
                    <div class="mt-4">
                        <video width="100%" height="400" controls>
                            <source src="/uploads/<?php echo basename($video); ?>" type="video/mp4">
                            Seu navegador não suporta o elemento de vídeo.
                        </video>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-4">
                <div class="card p-4">
                    <h5 class="card-title">Detalhes do Anúncio</h5>
                    <p class="card-text"><?php echo htmlspecialchars($anuncio['descricao']); ?></p>
                    <p class="card-text"><strong>Preço: R$ <?php echo number_format($anuncio['preco'], 2, ',', '.'); ?></strong></p>
                    <p class="card-text">Categoria: 
                        <?php
                        $categoria_id = $anuncio['categoria_id'];
                        $categoria_sql = "SELECT nome FROM categorias WHERE id = '$categoria_id'";
                        $categoria_result = $conn->query($categoria_sql);
                        if ($categoria_result->num_rows > 0) {
                            $categoria = $categoria_result->fetch_assoc();
                            echo htmlspecialchars($categoria['nome']);
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2024 ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
