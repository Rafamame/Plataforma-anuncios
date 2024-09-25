<?php
session_start();
session_unset();  // Remove todas as variáveis de sessão
session_destroy();  // Destrói a sessão

// Redireciona o usuário para a página inicial após o logout
header("Location: index.php");
exit;
?>
