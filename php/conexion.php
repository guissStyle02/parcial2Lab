<?php
function conectaDB() 
{ 
   $host = 'localhost'; 
   $user = 'root';
   $pass = '';
   $db   = 'gestion_documentos';

   $link = mysqli_connect($host, $user, $pass, $db);

   if (!$link) {
       echo json_encode([]);
       exit();
   }

   mysqli_set_charset($link, "utf8mb4");

   return $link; 
} 
?>