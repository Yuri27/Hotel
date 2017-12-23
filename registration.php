<?php
	require "connection1.php";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Регистрация</title>
		<link rel="shortcut icon" href="images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="css/slider.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.js"></script>
		<script src="js/main.js"></script><!-- proverka -->
		<script src="js/valid.js"></script><!-- pustota form -->
		<script type="text/javascript" src="js/newpass.js"></script><!-- всплывающее окно -->
		<script src="js/pass.js" type="text/javascript"></script><!-- password -->
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
		<script type="text/javascript" src="js/login.js"></script><!-- всплывающее окно -->
			
	</head>
	<body>


		<div class="wrapper">
				
			<header id="top_nav" >
					<div class="register_signup">
						<a href=".login_class" class="open_login">Войти</a>
					</div>
					<a href="/"><img class="search" src="images/logo/logos.png" alt="Radissonblu logo"></a>					
					<input class="services" type="text" name="city_name" placeholder="Введите пожалуйста свои данные" disabled="disabled" ">					
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
				<div id="registrate">
					<form action="registration.php" method="POST">
						<p>
							<label style='padding-top: 40px;'>Ваш логин:</label>
							<input name="login" type="text" size="15" maxlength="40">
						</p>
						<p>
							<label>Ваш пароль:</label>
							<input name="password1" id="pass" type="password" size="15" maxlength="40">
							<div id="result"></div>
							<div id="bg_res"></div>	
						</p>

						<p>
							<label>Ваш пароль:</label>
							<input name="password2" type="password" size="15" maxlength="40">
						</p>
<!-- 						<p>
							<label>Выберите аватар:</label>
							<input type="FILE" name="fupload">
						</p>	 -->					
						<div id="boxcaptcha" class="captcha" >
							<h3>Введите код с картинки</h3>
								<div>
									<p><img style="width: 200px; height: 50px;" class="cap" src="captcha.php?sid=<?php echo rand(10000, 99999); ?>" width="120" height="20" alt="" /></p>
									<input style="width: 200px;" type="text" name="captcha" /><br />
								</div>
						</div>
						<p>
							<button id="regist-btn" type="submit" name="reg_btn" onClick="validate(this.form)" >Зарегистрироваться</button>
						</p>
					</form>
				</div>
			</article>
			<footer>
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
				<script type="text/javascript">



</script>

		</div>
		<div class="login_div login_class">
			<p class="login_close">X</p>
				<form action="login.php" method="POST">
					<h3>Вход</h3>
					<p>
						<label for="login">Логин/E-mail</label>
						<input type="text" name="login" size="30" maxlength="40"/>
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
if(isset($_POST['reg_btn'])){
	$login = $_POST['login']; 
	$password1=$_POST['password1'];
	$password2=$_POST['password2'];
	
	// если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
	$login = stripslashes($login);
	$login = htmlspecialchars($login);
	$password1 = stripslashes($password1);
	$password1 = htmlspecialchars($password1);
	$password2 = stripslashes($password2);
	$password2 = htmlspecialchars($password2);
	//удаляем лишние пробелы
	$login = trim($login);
	$password1 = trim($password1);
	$password2 = trim($password2);
	//шифруем пароль
	$md5_password = md5($password2);       
	$md5_password = strrev($md5_password);// для надежности добавим реверс          
	$md5_password = $md5_password."b3p6f";

	$avatar = "avatars/avatar.png";
	

	// проверка на существование пользователя с таким же логином
	$result = mysql_query("SELECT id FROM users WHERE login='$login'");
	$myrow = mysql_fetch_array($result);
	if (!empty($myrow['id'])) {
		echo '<script type="text/javascript">alert("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");</script>';
		exit ();
	}

	if($password1==$password2){
		if (isset($_POST['captcha'])){
			
			$code = $_POST['captcha']; //--Получаем введенную пользователем капчу
			if ( isset($_SESSION['captcha']) && strtoupper($_SESSION['captcha']) == strtoupper($code) ){
					
					echo '<script type="text/javascript">alert("OK");</script>';//--Сравниваем
					// если такого нет, то сохраняем данные
					$new_user = mysql_query("INSERT INTO users (login,password,signup_date,avatar) VALUES ('$login','$md5_password','".date('Y-m-d H:i:s')."','$avatar')");
					// Проверяем, есть ли ошибки
					if ($new_user=='TRUE')
					{
						echo '<script type="text/javascript">alert("Вы успешно зарегистрированы! Теперь вы можете зайти на сайт.");</script>';
					}
					else {
						echo '<script type="text/javascript">alert("Ошибка! Вы не зарегистрированы.");</script>';
					}
			}
			else{
				echo '<script type="text/javascript">alert("Неправильно введен код с картинки!");</script>';
			}
				unset($_SESSION['captcha']);
				exit();
		}
	}
}

?>