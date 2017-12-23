<?php
	require "../connection.php";
?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Готель</title>
		<link rel="shortcut icon" href="../images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="../css/styles.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="../css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="../css/slider.css">
		<link rel="stylesheet" href="../css/table.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.js"></script>
		<script>
			var h_hght = 0; // высота шапки
			var h_mrg = 0;    // отступ когда шапка уже не видна

			$(function(){

				var elem = $('#top_nav');
				var top = $(this).scrollTop();

				if(top > h_hght){
					elem.css('top', h_mrg);
				}
				$(window).scroll(function(){
					top = $(this).scrollTop();

					if (top+h_mrg < h_hght) {
						elem.css('top', (h_hght-top));
					} 
					else {
						elem.css('top', h_mrg);
					}
				});

			});
		</script>			
	</head>
	<body>
		<div class="wrapper">				
			<header>
				<!-- <div class="register_signup">
						<?php 
							$login = $_SESSION['login'];
							$password = $_SESSION['pass'];
							if (empty($_SESSION['login']) or empty($_SESSION['id_employee'])){// Если пусты, то мы не выводим ссылку
								echo '<div id="user"><h3>Авторизируйтесь</h3></div><a href=".login_class" class="open_login"></a><a href="registration.php"></a>';
							}
							else{// Если не пусты, то мы выводим ссылку
							echo '<div id="user"><h4 title="пользователь '.$_SESSION['login'].'">'.$_SESSION['login'].'</h4></div><a href="exit.php">Выйти</a>';
						}
						?>	
					</div> -->
				<div class="admin">
					<input class="services" type="text" name="" value="Автризация администратора" disabled="disabled">
				</div>
			</header>
			<aside>
			
			</aside>
			<article>
				<form action="index.php" method="POST" id="admins">
					<h3>Введите свои данные</h3>
					<p>
						<label for="login">Логин(телефон)</label>
						<input type="text" type="text" name="login" size="30" maxlength="40"/>
					</p>
					<p>
						<label for="login">Пароль</label>
						<input type=password name=password size=30 maxlength=40 />
					</p>
					<p style="text-align: center; padding-bottom: 10px;">
						<button class="login-btn" type="submit" id="button" name="login-btn">Войти</button>
					</p>
				</form>
			</article>
		</div>
	</body>
</html>
<?php 
	if(isset($_POST['login-btn'])){
		if (isset($_POST['login'])){ 
			$login = $_POST['login'];
			if ($login == ''){ 
				unset($login);
			}
		} 

		if (isset($_POST['password'])){
			$password=$_POST['password']; 
			if ($password ==''){
				unset($password);
			} 
		}

		if (empty($login) or empty($password)) {
			exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
		}

	 	$login = stripslashes($login);
		$login = htmlspecialchars($login);
		$password = stripslashes($password);
		$password = htmlspecialchars($password);

		//удаляем лишние пробелы
		$login = trim($login);
		$password = trim($password);

		$result = mysql_query("SELECT * FROM staff WHERE phone='$login' AND pass='$password'"); //извлекаем из базы все данные о пользователе с    введенным логином и паролем
   		$myrow = mysql_fetch_array($result);
   		if (empty($myrow['id_employee'])){
   			exit ("Извините, введённый вами логин или пароль неверный.");
   		}
		else {
			//если пароли    совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
			$_SESSION['pass']=$myrow['pass']; 
			$_SESSION['phone']=$myrow['phone']; 

			$_SESSION['id_employee']=$myrow['id_employee'];//эти    данные очень часто используются, вот их и будет "носить с собой"    вошедший пользователь

			//Далее мы запоминаем данные в куки, для последующего входа.
			//ВНИМАНИЕ!!! ДЕЛАЙТЕ ЭТО НА ВАШЕ УСМОТРЕНИЕ, ТАК КАК ДАННЫЕ ХРАНЯТСЯ    В КУКАХ БЕЗ ШИФРОВКИ
			if ($_POST['save'] == 1) {
			//Если пользователь хочет, чтобы его данные сохранились для    последующего входа, то сохраняем в куках его браузера
			setcookie("login", $_POST["login"], time()+9999999);
			setcookie("password", $_POST["password"], time()+9999999);
			}
			echo '<script>location.replace("orders.php");</script>';
		}
	}
?>