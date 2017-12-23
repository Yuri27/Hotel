<?php
	require "connection.php";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Кривой Рог</title>
		<link rel="shortcut icon" href="images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="css/slider.css">
		<link rel="stylesheet" href="css/mini_slider.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.js"></script>
		<script type="text/javascript" src="js/login.js"></script><!-- всплывающее окно -->
		<script type="text/javascript" src="js/newpass.js"></script><!-- всплывающее окно -->
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
					<a href="/"><img class="search" src="images/logo/logo.png" alt="Radissonblu logo"></a>					
					<!--input class="search" type="text" name="city_name" placeholder="Куда желаете отправиться?" onkeyup="check();"-->
					<select class="search" type="text" name="city_name">
							<option selected value="Кривой Рог">Кривой Рог</option>														
							<option value="Киев">Киев</option>
							<option value="Буковель">Буковель</option>
					</select>
					<!-- <input class="search-btn" type="submit" id="button" name="myButton" disabled="disabled" value="ПОИСК"> -->
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
				<div id="main">
					<div class="slider">
						<ul>
							<li>
								<img src="img/kr/1.jpg" />
								<span>
									<h4>Radisson Krivoy Rog</h4>
								</span>
							</li>
							<li>
								<img src="img/kr/2.jpg" />
								<span>
									<h4>Radisson Krivoy Rog</h4>
								</span>
							</li>
							<li>
								<img src="img/kr/3.jpg" />
								<span>
									<h4>Radisson Krivoy Rog</h4>
								</span>
							</li>
						</ul>
					</div>
				</div>
				<div class="blocks">
						<div class="block1">
							<h1 style="text-align: left;">ОТЕЛЬ В ЦЕНТРЕ КИЕВА ПРИГЛАШАЕТ ПОЗНАКОМИТЬСЯ С БОГАТОЙ ИСТОРИЕЙ УКРАИНЫ</h1>
							<p>Отель Radisson Blu Hotel, Krivoy Rog расположен в безопасной дипломатической части Кривого Рога, недалёко от основных культурных и исторических достопримечательностей столицы металургии. Короткая прогулка – и вы уже возле памятников XI века - Золотые Ворота и Собор Святой Софии. Национальная опера Украины, расположенная в 5 минутах от отеля, очарует вас классическими и современными постановками. Любители шоппинга также останутся довольны покупками в новом классическом Универмаге на центральной улице Киева - Крещатик. Она находится в 15 минутах ходьбы от отеля, а в выходные дни становится пешеходной. На Крещатике часто проводят концерты или организовывают развлечения для гостей и жителей Киева. Спрячьтесь от шума и городской суеты в одном из зеленых оазисов мегаполиса – ландшафтных парках Киева или его пригорода. Гостям отеля, которые приехали в Киев с бизнес-визитом, понравится близкое расположение отеля к деловой и административной части. Станция метро Золотые ворота находится в 450 м. от отеля, недалеко также есть остановки троллейбуса и железнодорожный вокзал. До Международного аэропорта «Киев» (Жуляны) - всего 8 км.
							<input type="button" id="ggt" value="Показать" onclick="dawn(this,'bla')">
							<script type="text/javascript">function dawn(input,id){
								input.value =   input.value != 'Скрыть' ?  'Скрыть' : 'Показать'
								document.getElementById(id).style.display = document.getElementById(id).style.display == 'none' ? 'block' : 'none';
							}</script>
							<p id="bla" style="display: none">Наши 255 номеров и апартаментов предоставляют все необходимые удобства, в том числе бесплатный высокоскоростной беспроводной Интернет. Попробуйте традиционный блюда Италии в ресторане – винотеке Mille Miglia Ristorante & Enoteca или отдохните в конце рабочего дня с коктейлем в лаундж баре K-Largo. Продолжайте тренировки благодаря нашему фитнес-центру Pace. Полностью восстановиться после длинного дня помогут сауна или парная, массаж или услуги салона красоты. Отель идеально подходит для проведения конференций или деловых мероприятий. Наш большой конференц-зал Embassy Suite и переговорные комнаты могут принять большие бизнес-мероприятия, совещания или презентации.</p>
						</div>
						<div class="block2">
							<p style="text-align: left; margin-left: 42px;margin-bottom: -20px;">От<h2 style="text-align: left; margin-left: 42px;">EUR 133.33 в./ночь</h2>
							<form action="bron.php" method="GET">
								<input type="hidden" name="city_name" value="Кривой Рог">
								<button class="search-btn" type="submit" id="zabron" name="zabron" >Забронировать</button>
							</form>

								<p style="text-align: left; margin-left: 42px;margin-bottom: -15px;">НАЙТИ НАС:</p>
								<a href="https://www.facebook.com/RadissonBluHotelKyiv" class="sprite sprite-facebook"></a> 
								<a href="https://plus.google.com/u/0/108696314446683360143/about/p/pub" class="sprite sprite-google-plus"></a> 
								<a href="https://www.instagram.com/millemigliarestaurant/" class="sprite sprite-instagram"></a> 
								<a href="https://twitter.com/Radisson_Podil" class="sprite sprite-twitter"></a>
						</div>
						<div class="block3">
							<div id="mini_main">
								<div class="mini_slider">
									<ul>
										<li>
											<img src="img/kr/1.png" />
												<p>Сертификат отличия портала</p>
												<p>TripAdvisor</p>
										</li>
										<li>
											<img src="img/kr/2.png" />
										</li>
										<li>
											<img src="img/kr/3.png" />
												<p>Отель сертифицирован по </p>
												<p>глобальному стандарту </p>
												<p>безопасности отелей Global </p>
												<p>Hotel Security Standard©</p>
										</li>
										<li>
											<img src="img/kr/4.png" />
										</li>
									</ul>
								</div>
							</div>
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
 ?>