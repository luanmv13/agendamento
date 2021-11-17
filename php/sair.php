<?php
	// include "conexao.php";
    SESSION_START();
  
   $_SESSION['logado']=0;
   session_destroy();
   header("Location: index.php");
   exit;
   
?>