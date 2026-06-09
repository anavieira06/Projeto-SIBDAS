<?php
// Inicia a sessão para aceder e manipular os dados da $_SESSION
session_start();


// Termina a sessão removendo todas as variáveis/dados armazenados
session_unset();

// Isto elimina o identificador da sessão e os dados associados
session_destroy();

// Após terminar a sessão, redireciona o utilizador para a página de login
header('Location: login.php');

return;