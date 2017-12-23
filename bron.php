<?php
	require "connection.php";
	if(empty($_SESSION['login']))
		$user="NULL";
	else 
		$user = $_SESSION['id'];

	echo $user;
	$data = $_POST;

if( isset($data['zakaz'])) {
	// //бронирование
	
	$errors = array();
	if( trim($data['full_name'])=='' )
	{
		$errors[]='Введите полное имя!';
	}
	if( trim($data['pasport'])=='' )
	{
		$errors[]='Введите серию и номер паспорта!';
	}
	if( trim($data['num_phone'])=='' )
	{
		$errors[]='Введите номер телефона!';
	}
	if( $data['date_issue']=='' )
	{
		$errors[]='Введите дату заезда!';
	}
	if( $data['issued_by']=='' )
	{
		$errors[]='Введите дату отъезда!';
	}
	if( $data['category']=='' )
	{
		$errors[]='Выберете категорию!';
	}

	$categories = mysql_query("SELECT state_room.id_status FROM state_room INNER JOIN rooms ON state_room.id_room = rooms.id_room INNER JOIN categories ON rooms.id_category = categories.id_category WHERE state_room.id_room = rooms.id_room AND rooms.id_category = ".$data['category']." AND state_room.freely = 'N' AND state_room.booked = 'N'");	
	$new=mysql_fetch_array($categories);
	if($new){
		mysql_query("update state_room set freely='Y' where id_status=".$new['id_status']."");//змінюємо статус номеру
		mysql_query("update state_room set booked='Y' where id_status=".$new['id_status']."");
	}
	else{
		$errors[]='В даной категории свободных номеров';
	}
	if( empty($errors))
	{	
		//заповнюємо таблицю
		mysql_query("INSERT INTO clients (full_name_client,number_passport,phone,id_user) VALUES 
		('".$data['full_name']."','".$data['pasport']."','".$data['num_phone']."',".$user.")");

		mysql_query("UPDATE state_room SET settlement='".$data['date_issue']."' WHERE id_status=".$new['id_status']."");//змінюємо статус номеру
		mysql_query("UPDATE state_room SET eviction='".$data['issued_by']."' WHERE id_status=".$new['id_status']."");//змінюємо статус 

		$max=mysql_query("SELECT max(id) FROM clients");
		$new_max=mysql_fetch_row($max);
		$client = $new_max[0];
		mysql_query("INSERT INTO orders (id_status,name_city,id_client,grown,child,date_issue,issued_by,order_date) VALUES
		('".$new['id_status']."','".$_SESSION['name']."','".$client."','".$data['grown']."','".$data['child']."','".$data['date_issue']."','".$data['issued_by']."','".date('Y-m-d H:i:s')."')");

		mysql_query("INSERT INTO booking (id_status,name_clients) VALUES ('".$new['id_status']."','".$client."')");
		echo '<script type="text/javascript">alert("Вы успешно Забронировали номер!");</script>';
		//Можете перейти на <a href="/">главную </a>страницу</div><hr>';		
	}
	else
	{
		echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
	}	
	echo '<script>location.replace("selectedservices.php");</script>';	
}
?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Бронирование номера</title>
		<link rel="shortcut icon" href="images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="css/slider.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
		<script src="js/jquery-3.2.1.js"></script>
		<!-- Подключение библиотеки jQuery -->
		<!-- Подключение jQuery плагина Masked Input -->
		<script src="js/jquery.maskedinput.min.js"></script>
		<script src="js/date.format.js"></script>
		<script type="text/javascript" src="js/login.js"></script><!-- всплывающее окно -->
		<script type="text/javascript" src="js/phone.js"></script>
		<script type="text/javascript" src="js/newpass.js"></script><!-- всплывающее окно -->
	</head>
	<body>
		<div class="wrapper">
			<header>					
				<form id="top_nav" name="search" action="bron.php" method="POST" onSubmit="myButton.disabled = true; return true;">
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
					<input  class="search" type="text" name="n_city" maxsize="60" value="Вы отправлятесь в <?php echo $_GET['city_name']; ?>" disabled>
					<!-- <input type="hidden" name="city" value="<?php echo $_GET['city_name']; ?>"> -->
					<button class="search-btn" type="submit" id="button" name="search_btn" disabled="disabled">ПОИСК</button>
				</form>
					<?php
						//echo "City".$_GET['city_name'];
						$_SESSION['name']=$_GET['city_name'];
					?>
			</header>		
			<div id="top_nav">
				<button class="menu-btn">&#9776; Меню</button>
				<!-- <button onClick="formWind();">&#9776; окно</button> -->
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
				<div id="bokaroom">
				<form action="bron.php" name="Test" method="POST">
					<p>
						<?php
							if (!empty($_SESSION['login'])){
								$name=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE login='".$_SESSION['login']."'"));
								$full_name_user=$name['name'];
							}
							else
								$full_name_user="";
						?>
						<label for="phone" style='padding-top: 40px;'>Ваше полное имя: </label>
						<input type="text" name="full_name" id="name_user" maxsize="60" value="<?php echo $full_name_user;?>" placeholder="Иванов Иван Иваныч" ><!-- required -->
					</p>
					<p>
						<label for="phone">Серия паспорта: </label>
						<input type="text" name="pasport" maxsize="60" maxlength="10" placeholder="AO123456" style='width:216px;'>
						<label for="phone" style="position: absolute; margin-top: -81px; margin-left: 275px;">Взрослые: </label>
						<input type="Number" name="grown" min="1" max="8" value="1" style='margin-left: 0px; width:136px;'>
						<label for="phone" style="position: absolute; margin-top: -81px; margin-left: 420px;">Дети: </label>
						<input type="Number" name="child" min="0" max="8" value="0" style='margin-left: 0px; width:136px;'>
					</p>
					<p>
						<label for="phone">Телефон: </label>
						<select id="country" class="form-control" style='width:216px' >
							<option value="+380">Украина +380</option>														
							<option value="+375">Белорусь +375</option>
							<option value="+1">США +1</option>
							<option value="+44">Англия +44</option>
							<option value="+90">Турция +90</option>
							<option value="+34">Испания +34</option>
							<option value="+7">Россия +7</option>
						</select>
						<input id="phone" for="phones" name="num_phone" type="text" class="form-control" style='width:280px; margin-left: 0px;'>
					</p>
					<p>
						<label for="phone">Заезд/Отъезд:</label>
						<input  type="date" name="date_issue" class="form-control" min="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d');?>" style='width: 246px;'>
						<input  type="date" name="issued_by" class="form-control" min="<?php echo  date("Y-m-d", (time()+3600*24));?>" value="<?php echo  date("Y-m-d", (time()+3600*24));?>" style="width: 246px; margin-left: 0px;">
					</p>
					<P>
						<label for="category">Категория: </label>
						<select name="category" id="country" class="form-control" style='width:500px' >
							<?php
							$result=mysql_query("SELECT * from categories",$db) or die(mysql_error());
							$myrow=mysql_fetch_array($result);
							do
							{
								echo '<option value='.$myrow['id_category'].'>'.$myrow['name_category'].'</option>';
							}
								while($myrow=mysql_fetch_array($result));

							?>
						</select>
						<button class="zakaz-btn" type="submit" id="button" name="zakaz">Заказать</button><!-- onClick="forma();"  -->
					</P>

					
					</form>
					<img src="images/bron_page.jpg" alt="" height="268px">
					<h5>Знаковый, элегантный и изысканный бренд Radisson Blu создает восхитительно оригинальные отели, отвечающие потребностям каждого гостя. Искушенным современным гостям нравится наша неповторимая располагающая атмосфера.Мы стремимся понравиться каждому гостю, предлагая целый ряд комплексных инновационных удобств и услуг, включая бесплатный высокоскоростной доступ в Интернет. Мы собрали воедино все необходимое благодаря нашей уникальной философии обслуживания «Я все смогу!»SM и 100%-ной гарантии качества.</h5>

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