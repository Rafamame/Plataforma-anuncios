<?php
session_start();
include 'db.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $preco = mysqli_real_escape_string($conn, $_POST['preco']);
    $categoria_id = intval($_POST['categoria']);
    $usuario_id = $_SESSION['user_id'];

    // Array para armazenar os caminhos das fotos
    $fotos = [];

    // Diretório de upload
    $target_dir = "/var/www/ununcinga.click/public_html/uploads/";

    // Processar o upload de múltiplas imagens
    $total_files = count($_FILES['fotos']['name']);
    for($i = 0; $i < $total_files; $i++) {
        if ($_FILES['fotos']['error'][$i] == 0) {
            $file_name = basename($_FILES['fotos']['name'][$i]);
            $target_file = $target_dir . uniqid() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
            if (move_uploaded_file($_FILES['fotos']['tmp_name'][$i], $target_file)) {
                $fotos[] = $target_file; // Adicionar o caminho da foto ao array
            } else {
                echo "Erro ao mover o arquivo de foto.";
            }
        }
    }

    // Serializar o array de fotos para armazená-las no banco de dados
    $fotos_serializadas = serialize($fotos);

    // Processar o upload do vídeo (opcional)
    $video_path = null;
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $video_file_name = basename($_FILES['video']['name']);
        $video_target_file = $target_dir . uniqid() . '.' . pathinfo($video_file_name, PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['video']['tmp_name'], $video_target_file)) {
            $video_path = $video_target_file; // Guardar o caminho do vídeo
        } else {
            echo "Erro ao mover o arquivo de vídeo.";
        }
    }

    // Inserir o anúncio no banco de dados
    $sql = "INSERT INTO anuncios (titulo, descricao, preco, categoria_id, usuario_id, fotos, video) 
            VALUES ('$titulo', '$descricao', '$preco', '$categoria_id', '$usuario_id', '$fotos_serializadas', '$video_path')";

    if ($conn->query($sql) === TRUE) {
        echo "Anúncio criado com sucesso!";
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
    <title>Criar Anúncio - ANUNCINGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        label {
            color: #ffcc00; /* Labels em amarelo */
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
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Criar Novo Anúncio</h2>
        <div class="card p-4">
            <form method="POST" action="criar_anuncio.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título do Anúncio</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="text" class="form-control" id="preco" name="preco" required>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <?php
                        $sql = "SELECT id, nome FROM categorias";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="'. $row['id'] .'">'. htmlspecialchars($row['nome']) .'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fotos" class="form-label">Fotos do Anúncio (selecione múltiplas imagens)</label>
                    <input type="file" class="form-control" id="fotos" name="fotos[]" multiple required>
                </div>
                <div class="mb-3">
                    <label for="video" class="form-label">Vídeo do Anúncio (opcional)</label>
                    <input type="file" class="form-control" id="video" name="video" accept="video/*">
                </div>
                <button type="submit" class="btn btn-custom w-100">Criar Anúncio</button>
            </form>
        </div>
    </div>

    <footer class="footer mt-5">
        <p>&copy; 2024 ANUNCINGA ANÚNCIOS GRATUITOS - PARA MARINGÁ E REGIÃO - Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
