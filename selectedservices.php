<?php
	require "connection.php";
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Выбор услуг</title>
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


</head>

	<body>
		<div class="wrapper">
			<header>
				<form id="top_nav" name="search" >
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
					<input class="services" type="text" name="" value="Выбор услуг" onkeyup="check();">
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

			<form method=POST action=selectedservices.php>
			 	<p>
					<title>Дополнительные услуги</title>	

					<?php
						$data = $_POST;
						$aDoor = $_POST['service'];
						$services = mysql_query("SELECT * FROM services");
						$new=mysql_fetch_array($services);
						echo '<div id=sdvig>';
 						echo '<input id="one" type="checkbox" class="checkbox" name="one" value="all" onclick="checkAll(this)" /><label for="one">Выбрать все</label>';
 						echo '</div>';
						echo '<table class="tableservice" style="" align=center >';
						// echo '<input id="one" type="checkbox" class="checkbox" name="one" value="all" onclick="checkAll(this)" /><label for="one">Выбрать все</label>';
						echo '<tr>';

						do {
							$ch++;
							$count++;
							if($count!=3){
								echo '<td width=25% ><input type="checkbox" class="checkbox" id="checkbox'.$ch.'" name="service[]" value='.$new['service_type'].'></input>
									<label for="checkbox'.$ch.'">'.$new['service_type'].' ('.$new['service_cost'].' ₴)</label></td>';
								
							}			
							else{									
								echo '<td width=25% ><input type="checkbox" class="checkbox" id="checkbox'.$ch.'" name="service[]" value='.$new['service_type'].'></input>
									<label for="checkbox'.$ch.'">'.$new['service_type'].' ('.$new['service_cost'].' ₴)</label></td>';
								$count=0;
								echo "<tr></tr>";
							}
					
						}while($new=mysql_fetch_array($services));
         				echo '</tr>';
						echo '</table>';
						echo '</div>';
						$client=mysql_fetch_array(mysql_query("SELECT max(id) FROM  clients"));//виводимо одну клытинку з таблиці
							// echo $client[0].'<br>';

							$zaezd=mysql_fetch_array(mysql_query("SELECT orders.date_issue FROM orders INNER JOIN clients 
							ON orders.id_client = clients.id WHERE orders.id_client =".$client[0].""));
							// echo $zaezd[0].'<br>';
							$otezd=mysql_fetch_array(mysql_query("SELECT orders.issued_by FROM orders INNER JOIN clients 
							ON orders.id_client = clients.id WHERE orders.id_client =".$client[0].""));
							// echo $otezd[0].'<br>';

							$kol= floor((strtotime($otezd[0])-strtotime($zaezd[0]))/(3600*24));/*количество дней перебывани в отеле*/
								//echo 	'<div style="color: black; font-size: 200%;">'.$kol.'</div>';	
							// echo $kol.'<br>';	
						if( isset($data['do_signup'])) 
						{
							//бронирование
							$errors = array();	
							if(empty($aDoor))
							{
								echo '<script type="text/javascript">alert("Вы ничего не выбрали!!!");</script>';
							}
							else
							{
								$N = count($aDoor);
								// echo("Вы выбрали $N улсуги: ");
								for($i=0; $i < $N; $i++)
									{
										// echo($aDoor[$i]. " ");
										mysql_query("INSERT INTO selected_services (id_client,service) VALUES('".$client[0]."','".$aDoor[$i]. " "."')");
									}
							
							echo '</br>';
							/*цена за услугу из списка*/
							$cost=mysql_query('SELECT services.service_cost FROM selected_services
												INNER JOIN services ON selected_services.service = services.service_type
												WHERE selected_services.id_client = '.$client[0].'');
							$costs=mysql_fetch_array($cost);
							if($costs){
									do{			
										$sum+=$costs['service_cost'];/*сумма всех услуг из списка*/
									}while ($costs=mysql_fetch_array($cost));
									// echo '<div style="color: green;font-size: 200%; "><span style="padding-left: 48%;">	'.$sum.'!!<br/></div>';
								}
							else{
							 	$errors[]='Нет цены на услугу';
							}
							/*цена за номер*/
							$cost_number=mysql_fetch_array(mysql_query("SELECT categories.cost FROM orders INNER JOIN clients ON orders.id_client = clients.id
								INNER JOIN state_room ON orders.id_status = state_room.id_status INNER JOIN rooms
								ON state_room.id_room = rooms.id_room INNER JOIN categories ON rooms.id_category = categories.id_category
								WHERE rooms.id_category = categories.id_category AND state_room.id_status = state_room.id_status AND orders.id_status = state_room.id_status
								AND orders.id_client = ".$client[0].""));
								// echo $cost_number[0];

							$sumser=$sum*$kol;
							$all_sum=($sum+$cost_number[0])*$kol;
							
							// echo 	'<div style="color: black; font-size: 200%;">'.$all_sum.'</div>'; 
							
							mysql_query("UPDATE orders SET cost_services='$sumser' WHERE id_client = ".$client[0]."");
							mysql_query("UPDATE orders SET all_cost='$all_sum' WHERE id_client = ".$client[0]."");

							
							$paid="Не оплочен";
							mysql_query("UPDATE orders SET status='$paid' WHERE id_client = ".$client[0]."");
							
							echo '<script>location.replace("check.php");</script>';
							}
						}
						?>
						
					<script type="text/javascript">
					function checkAll(obj) {
						'use strict';
						// Получаем NodeList дочерних элементов input формы: 
						var items = obj.form.getElementsByTagName("input"), 
						len, i;
						// Здесь, увы цикл по элементам формы:
						for (i = 0, len = items.length; i < len; i += 1) {
							// Если текущий элемент является чекбоксом...
							if (items.item(i).type && items.item(i).type === "checkbox") {
							// Дальше логика простая: если checkbox "Выбрать всё" - отмечен            
								if (obj.checked) {
								// Отмечаем все чекбоксы...
									items.item(i).checked = true;
								} 
								else {
									// Иначе снимаем отметки со всех чекбоксов:
									items.item(i).checked = false;
								}
							}
						}
					}
					</script>						
				</p>
				<button class="service-btn" type="submit" id="button" name="do_signup">Заказать</button>
			</form>
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