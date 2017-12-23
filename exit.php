<?php
require "connection.php";
unset($_SESSION['password']);
unset($_SESSION['login']); 
unset($_SESSION['id']);//
header('Location: /');
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