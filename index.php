<?php
	require "connection.php";
	$tod = date('Y.m.d'); 
	//$today=date("d/m/Y", strtotime($tod));
	// echo $tod; 
	mysql_query("UPDATE state_room SET eviction=null WHERE eviction<'$tod'");    
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Отель</title>
		<link rel="shortcut icon" href="images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="css/slider.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="js/login.js"></script><!-- всплывающее окно -->
        <script type="text/javascript" src="js/newpass.js"></script><!-- всплывающее окно -->
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
			<div class="qwert">
								
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
			</div>
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
				<div class="main">
					<div class="slider">
						<ul>
							<li>
								<img src="img/1.jpg" />
								<!-- <img src="img/slide02.png" /> -->
							</li>
							<li>
								<!-- <img src="img/slide01.png" /> -->
								<img src="img/2.jpg" />
								<span>
									<h4>ВЕСЕННЯЯ ЖАЖДА СТРАНСТВИЙ</h4>
									<p>ПОДАРИТЕ СЕБЕ НЕЗАБЫВАЕМЫЕ ВЫХОДНЫЕ...</p>
								</span>
							</li>
							<li>
								<!-- <img src="img/slide03.png" /> -->
								<img src="img/3.jpg" />
								<span>
									<h4>Another caption title</h4>
									<p>More lorem ipsum dolor...</p>
								</span>
							</li>
						</ul>
					</div>
				</div>
				<p>Сеть отелей Radisson – один из всемирно известных отельных брендов, который пришел в мировую гостиничную индустрию из США. 
					Отели Radisson можно сегодня 	встретить практически на всех популярных курортах Европы, Азии, Африки и Америки. Полное название сети – Radisson Hotels & Resorts.</p>
					<p>Отели Radisson в большинстве своем предоставляют высококлассный сервис 4-5*. Рыночная ниша компании – это роскошные отели, а также крупные гостиничные курортные комплексы.
					На рынке сеть Radisson выступает под двумя марками – Radisson в США и Radisson SAS для остального мира. Последний бренд был запущен в сотрудничестве со скандинавской авиакомпанией SAS. Отсюда и второе имя в названии отелей. Под брендом Radisson SAS сегодня открыто свыше 150 гостиниц. Управление отелями Radisson SAS в Европе осуществляет компания Rezidor Hotel Group со штаб-квартирой в Брюсселе.
					Владельцами сети Radisson, начиная с 1962 года, является семейство Карлсон. Один из богатейших кланов США управляет 450 отелями Radisson в более чем 60 странах мира.
					</p>
					<p>Radisson динамично осваивает новые рынки. В частности, Radisson стала одной из первых гостиничных сетей в мире, пришедших на рынок России и СНГ. Radisson сегодня управляет одним из лучших отелей Сочи – Radisson SAS Лазурная, который принадлежит «Газпрому».
					Radisson активно использует современные механизмы привлечения и удержания клиентов. Программа лояльности в отелях Radisson – один из наиболее эффективных инструментов. Новейшая версия системы скидок и бонусов для постояльцев отелей Radisson называется Radisson goldpoints plus. goldpoints plus предусматривает накопление баллов клиентом за пользование услугами отелей Radisson. Впоследствии эти балы можно использовать в качестве премальных бонусов при аренде номеров в отелях Radisson. В системе скидок также участвуют и отели других сетей, находящихся в управлении Carlson Companies: Park Plaza, Country Inns, Park Inn, Regent. Кроме того, Radisson является единственной отельной сетью, которая предлагает отдельную программу лояльности для туроператоров - Look To Book.</p>
					<p>Среди последних инноваций Radisson – особо комфортные номера Sleep Numbers со специально разработанными кроватями Select Comfort. Такие номера доступны в отелях США, Канады и в отелях на курортах Карибского моря. Собственно, кровати в номерах Radisson всегда были одним из главных достоинств отелей сети, вне зависимости от уровня отеля.
					На сегодняшний день среди основных конкурентов сети Radisson – Hilton, Sheraton и Marriott.</p>
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