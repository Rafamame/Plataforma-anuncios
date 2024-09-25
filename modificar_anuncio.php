<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['anuncio_id'])) {
    $anuncio_id = intval($_GET['anuncio_id']);
    
    // Buscar detalhes do anúncio no banco de dados
    $sql = "SELECT * FROM anuncios WHERE id = '$anuncio_id' AND usuario_id = '{$_SESSION['user_id']}'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $anuncio = $result->fetch_assoc();
    } else {
        echo "Anúncio não encontrado ou você não tem permissão para modificá-lo.";
        exit();
    }
} else {
    echo "ID do anúncio não fornecido.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $preco = mysqli_real_escape_string($conn, $_POST['preco']);
    $categoria_id = intval($_POST['categoria']);

    // Atualizar o anúncio no banco de dados
    $sql = "UPDATE anuncios SET titulo='$titulo', descricao='$descricao', preco='$preco', categoria_id='$categoria_id' WHERE id='$anuncio_id' AND usuario_id = '{$_SESSION['user_id']}'";

    if ($conn->query($sql) === TRUE) {
        header("Location: detalhes_anuncio.php?anuncio_id=$anuncio_id");
    } else {
        echo "Erro ao modificar o anúncio: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Anúncio - ANUNCINGA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Modificar Anúncio</h2>
        <div class="card p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título do Anúncio</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($anuncio['titulo']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" required><?php echo htmlspecialchars($anuncio['descricao']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="text" class="form-control" id="preco" name="preco" value="<?php echo htmlspecialchars($anuncio['preco']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <?php
                        $sql = "SELECT id, nome FROM categorias";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="'. $row['id'] .'"'. ($row['id'] == $anuncio['categoria_id'] ? ' selected' : '') .'>'. htmlspecialchars($row['nome']) .'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning w-100">Salvar Modificações</button>
            </form>
        </div>
    </div>
</body>
</html>
