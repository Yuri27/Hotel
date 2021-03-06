<?php
	require "connection.php";
	// Проверяем, пусты ли переменные логина и id пользователя
    
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Информация о бронировании</title>
		<link rel="shortcut icon" href="images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="css/slider.css">
		<link rel="stylesheet" href="css/table.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="js/login.js"></script><!-- всплывающее окно -->
        <script type="text/javascript" src="js/bron.js"></script><!-- всплывающее окно -->
        <script type="text/javascript" src="js/newpass.js"></script><!-- всплывающее окно -->
        <script type="text/javascript" src="js/valid.js"></script><!-- всплывающее окно -->
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
				<form id="top_nav" name="search" action="bron.php" method="GET" onsubmit="myButton.disabled = true; return true;">
					<div class="register_signup">
					<?php 
						$login = $_SESSION['login'];
						$password = $_SESSION['password'];
						$result = mysql_query("SELECT avatar FROM users WHERE login='$login'"); 
						$myrow = mysql_fetch_array($result);
						if (empty($_SESSION['login']) or empty($_SESSION['id'])){// Если пусты, то мы не выводим ссылку
							echo '<div id="user"><h3>Вы вошли на сайт, как гость</h3></div><a href=".login_class" class="open_login">Войти/</a><a href="registration.php">Зарегистрироваться</a>';
						}
						else{// Если не пусты, то мы выводим ссылку
						echo '<div id="user"><a href="user.php"><img title="Щелкните чтобы перейти к своему аккаунту" src='.$myrow['avatar'].' height="40"></a><h4 title="пользователь '.$_SESSION['login'].'">'.$_SESSION['login'].'</h4></div><a href="exit.php">Выйти</a>';
					}
					?>
					</div>

					<a href="/"><img class="search" src="images/logo/logos.png" alt="Radissonblu logo"></a>
					<select class="search" type="text" name="city_name">
							<option selected disabled>Куда желаете отправиться?</option>
							<option value="Кривой Рог">Кривой Рог</option>														
							<option value="Киев">Киев</option>
							<option value="Буковель">Буковель</option>
					</select>
					<button class="search-btn" type="submit" id="button" name="myButton">ПОИСК</button>
				</form>

			</header>
				<div id="top_nav">
					<button class="menu-btn">&#9776; Меню</button>
				</div>
			</hr>	
			<aside>
			<!-- Pushy Menu -->
				<nav class="pushy pushy-right" data-focus="#first-link">
					<div class="pushy-content">
						<ul>
							<li class="pushy-submenu">
								<button id="first-link">Отели</button>
								<ul>
									<li class="pushy-link"><a href="kr.php">Кривой Рог</a></li>
									<li class="pushy-link"><a href="kiev.php">Киев</a></li>
									<li class="pushy-link"><a href="bukovel.php">Буковель</a></li>
								</ul>
							</li>
							<li class="pushy-link"><a href="category.php">Категории номеров</a></li>
							<li class="pushy-link"><a href="broninfo.php">Бронирование</a></li>
							<li class="pushy-link"><a href="#">Встречи и мероприятия</a></li>
							<li class="pushy-link"><a href="#">Услуги</a></li>
							<li class="pushy-link"><a href="contact_us.php">Контакты</a></li>
						</ul>
					</div>
				</nav>
			</aside>
			<article>
				
			<div id="bokaroom_info">
				<form action="broninfo.php" method="POST">
					<p>
						<label for="phone" style='padding-top: 40px;'><font size="5" color="red" face="Arial">*</font>Ваше полное имя: </label>
						<input type="text" name="full_name" id="name" maxsize="60" placeholder="Иванов Иван Иваныч" >
					</p>
					<p>
						<label for="phone" style='padding-top: 40px;'>Номер заказа: </label>
						<input type="text" name="order" id="num_order" maxsize="60" placeholder="5" >
					</p>
					<p>
						<label for="phone" style='padding-top: 40px;'>Дата: </label>
						<input style='width: 200px;' type="date" name="data" maxsize="60" placeholder="5" >
						<button type="submit" id="button" name="find">Найти</button>
					</p>

					
					</form>
					<img src="images/cover.jpg" alt="" height="293px">
					<h5>«Я ВСЕ СМОГУ!»
						Это нечто гораздо большее, чем просто девиз. «Я все смогу!» — это кредо бренда, особая философия обслуживания, отличающая нас от конкурентов. Истинное гостеприимство означает, что мы всегда уделяем все наше безраздельное внимание гостям.</h5>
					<div id="info" style="display: none; position: relative;top: -70px;">
						<?php 
							if(isset($_POST['find'])){
								$errors = array();
								
								if( trim($_POST['full_name'])=='' ){
									$errors[]='Введите полное имя:';
								}

								if( empty($errors)){	//заповнюємо таблицю
									$order = mysql_query("SELECT * FROM orders INNER JOIN clients ON orders.id_client = clients.id
												WHERE orders.id_client = clients.id AND clients.full_name_client = '".$_POST['full_name']."'");
									$ord = mysql_fetch_array($order);
										echo '<script type="text/javascript">
												openinfo("info");
												</script>';
										echo '<table class="simple-little-table" style="margin-top: 100px; text-align: center;" width="100%" cellpadding="5" cellspacing="0" align=center >
												<tr>
												<th ><a width=3%>Заказ</a></th>
												<th ><a width=3%>Комната</a></th>
												<th ><a width=10%>Город</a></th>
												<th ><a>Категория</a></th>
												<th ><a>Дата заезда</a></th>
												<th ><a>Дата отъезда</a></th>
												<th ><a>Сумма</a></th>
												</tr>';

									do{
										$cat = mysql_fetch_array(mysql_query("SELECT
  categories.name_category
FROM rooms
  INNER JOIN categories
    ON rooms.id_category = categories.id_category
  CROSS JOIN orders
  INNER JOIN state_room
    ON orders.id_status = state_room.id_status
    AND state_room.id_room = rooms.id_room
WHERE orders.id_status = state_room.id_status
AND state_room.id_room = rooms.id_room
AND rooms.id_category = categories.id_category
AND orders.id_order ='".$ord['id_order']."'"));
										echo '<tr>';
										echo '<td><a width=3%>'.$ord['id_order'].'</a></td>';
										echo '<td><a width=3%>'.$ord['id_status'].'</a></td>';
										echo '<td><a width=10%>'.$ord['name_city'].'</a></td>';
										echo '<td><a>'.$cat['name_category'].'</a></td>';
										echo '<td><a>'.$ord['date_issue'].'</a></td>';
										echo '<td><a>'.$ord['issued_by'].'</a></td>';
										echo '<td><a>'.$ord['all_cost'].'</a></td>';
										echo '</tr>';
									}while($ord = mysql_fetch_array($order));
									echo '</table>';
									// echo '<script type="text/javascript">alert("Сотрудник добавлен!");</script>';
								

								}
								else{
									echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
								}	
							}
						?>						
					</div>

				</div>
			</article>

			<footer>
				<div class="logo_footer">

					<a href="http://www.carlsonrezidor.com"><img alt="Carlson-Rezidor" src="images/logo/carlson-rezidor.png"></a>
					
					<a href="http://www.quorvuscollection.com/"><img alt="Quorvus Collection" src="images/logo/QUORVUS-COLLECTION-logo.png"></a>

					<a href="http://www.radissonblu.com"><img alt="raddison blu" src="images/logo/radissonblu-logo.png"></a>

					<a href="http://www.radisson.com/"><img alt="Radisson Green" src="images/logo/RadGreen-White-logo.png"></a>
					

					<a href="http://www.radissonred.com/"><img alt="Radisson Red" src="images/logo/RadissonRed-logo.png"></a>

					<a href="http://www.parkplaza.com"><img alt="Park Plaza" src="images/logo/ParkPlaza_logo.png"></a>

					<a href="http://www.parkinn.com/"><img alt="Park Inn" src="images/logo/ParkInn-logo.png"></a>

					<a href="http://www.countryinns.com/"><img alt="CIS" src="images/logo/CountryInn-logo.png"></a>

					<a href="http://www.countryinns.com/"><img alt="CIS" src="images/logo/prizeotel-logo.png"></a>
				</div>
				<div class="my">
					<p>© Курсовой проект<br>Наготнюк Юрий Александрович<br>+38(098) 039 24 72</p>
					<div class="soc">
						<h3>Найти меня</h3>
						<a href="https://www.facebook.com/yuri.nagotnyuk?ref=tn_tnmn" class="social_mini social_mini-facebook"></a>
						<a href="https://plus.google.com/109900682972739667583" class="social_mini social_mini-google-plus"></a>
						<a href="skype:yuri9731?chat" class="social_mini social_mini-skype"></a>
						<a href="https://vk.com/id140596261" class="social_mini social_mini-vk"></a>
						<a href="https://chat.whatsapp.com/Jcc7dZMV9xK8sUTKdMirpq" class="social_mini social_mini-whatsapp"></a>
						<a href="https://www.youtube.com/channel/UC7Au2hA2SkCvZBSfVjRiP_Q" class="social_mini social_mini-youtube"></a>
					</div>
				</div>
			</footer>
			<!-- Pushy JS -->
				<script src="js/pushy.min.js"></script>
		</div>
		<div class="login_div login_class">
			<p class="login_close">X</p>
				<form action="login.php" method="POST">
					<h3>Вход</h3>
					<p>
						<label for="login">Логин/E-mail</label>
						<input type="text" type="text" name="login" size="30" maxlength="40"/>
					</p>
					<p>
						<label for="login">Пароль</label>
						<input type=password name=password size=30 maxlength=40 />
					</p>
					<p style="text-align: center; padding-bottom: 10px;">
						<button class="login-btn" type="submit" id="button" name="login-btn">Войти</button>
					</p>
					<a href=".pass_class" class="open_pass">Забыли пароль</a>
				</form>
		</div>
		<div class="pass_div pass_class">
			<p class="pass_close">X</p>
				<form action="index.php" method="POST">
					<h3>Востановление пароля</h3>
					<p>
						<label for="login">E-mail</label>
						<input type="text" type="text" name="user_mail" size="30" maxlength="40"/>
					</p>
					<p style="text-align: center; padding-bottom: 10px;">
						<button class="login-btn" type="submit" name="pass-btn">Востановить</button>
					</p>
				</form>
		</div>
		<div id="overlay"></div>  
	</body>
</html>
<?php 
if(isset($_POST['pass-btn'])){
	$errors = array();
	if( trim($_POST['user_mail'])=='' ){
			$errors[]='Введите E-mail:';
	}
	if( empty($errors)){
		$login= mysql_fetch_array(mysql_query("SELECT * FROM users WHERE email='".$_POST['user_mail']."'"));
		$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
		$max=10; 
		$size=StrLen($chars)-1; 
		$password=null;
		while($max--) {
			$password.=$chars[rand(0,$size)]; 
		}
		$new_password = md5($password); 
		$new_password = strrev($new_password);
		$new_password = $new_password."b3p6f";

		$message="Здравствуйте, ".$login['login']."! Мы сгененриоровали для Вас пароль, теперь Вы сможете войти на сайт hotel.ua, используя его. После входа желательно его сменить.\n Пароль:\n".$password;//текст сообщения";

		$new_pass = mysql_query("UPDATE users SET password='$new_password' WHERE email='".$_POST['user_mail']."'");
		if($new_pass){
			mail($_POST['user_mail'], "Восстановление пароля", $message, "С уважение команда Radisson");
			echo '<script type="text/javascript">alert("Новый пароль отправлен на Ваш E-mail");</script>';
		}
		else{
			echo '<script type="text/javascript">alert("Ошибка отправки");</script>';
		}
	}
	else{
		echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
	}
}
	if(isset($_POST['find'])){
		$errors = array();
		// if(empty($_SESSION['login'])){
			// $errors[]='Чтобы просмотреть заказ, Вам нужно войти на сайт!';
		// }
		if( trim($_POST['full_name'])=='' ){
			$errors[]='Введите полное имя:';
		}

		if( empty($errors)){	//заповнюємо таблицю
				echo '<script type="text/javascript">
						openinfo("info");
					</script>';

			echo '<script type="text/javascript">
					openinfo("info");
				</script>';

		}
		else{
			echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
		}	
	}
?>