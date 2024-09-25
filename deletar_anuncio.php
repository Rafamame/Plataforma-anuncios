<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['anuncio_id'])) {
    $anuncio_id = intval($_GET['anuncio_id']);
    
    // Verificar se o anúncio pertence ao usuário logado
    $sql = "DELETE FROM anuncios WHERE id = '$anuncio_id' AND usuario_id = '{$_SESSION['user_id']}'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Anúncio deletado com sucesso.";
        header("Location: index.php");
    } else {
        echo "Erro ao deletar o anúncio: " . $conn->error;
    }
} else {
    echo "ID do anúncio não fornecido.";
    exit();
}
?>
