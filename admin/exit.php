<?php
require "../connection.php";
unset($_SESSION['pass']);
unset($_SESSION['phone']); 
unset($_SESSION['id_employee']);//
header('Location: index.php');
?>

<html>
 <head>
  <style> 
   html { height: 100%; }
   body {
    margin: 0; /* Убираем отступы */
    height: 100%; /* Высота страницы */
    background: url(images/background.jpg); /* Параметры фона */
    background-size: cover; /* Фон занимает всю доступную площадь */
   } 
  </style>
 </head>
 <body>
 </body>
</html>