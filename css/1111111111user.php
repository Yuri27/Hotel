<?php
	require "connection.php";
	// Проверяем, пусты ли переменные логина и id пользователя
    
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Готель</title>
		<link rel="shortcut icon" href="images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<link rel="stylesheet" href="css/user.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="css/slider.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="js/login.js"></script><!-- всплывающее окно -->

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
						$result = mysql_query("SELECT * FROM users WHERE login='$login'"); 
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
					<input class="services" type="text" name="" value="Аккаунт пользователя <?php echo $_SESSION['login'];?>" disabled="disabled">
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
							<li class="pushy-link"><a href="#">Бронирование</a></li>
							<li class="pushy-link"><a href="#">Встречи и мероприятия</a></li>
							<li class="pushy-link"><a href="#">Услуги</a></li>
							<li class="pushy-link"><a href="contact_us.php">Контакты</a></li>
						</ul>
					</div>
				</nav>
			</aside>
			<article>
				<div class="user_login">
					<div class="block1">
						<form action="user.php" method="POST" >
	<!-- 						<p>
								<label for="user">Ваш логин: </label>
								<?php echo $_SESSION['login']; ?>
							</p> -->
							
								<label for="user">Изменить логин:</label>
								<input name="login" type="text" value="<?php echo $_SESSION['login']; ?>">
								<button type="submit" name="submit">изменить</button>
							
						</form>
					</div>
					<div class="block2">
						<form action="user.php" method="POST">
							<!-- <p>
								<label for="user">Ваше имя: </label>
								<?php echo $myrow['name']; ?>
							</p> -->
							
								<label for="user">Изменить имя:</label>
								<input name="full_name" type="text" value="<?php echo $myrow['name']; ?>">
								<!-- <input type="submit" name="submit" value="изменить"> -->
								<button type="submit" name="submit">изменить</button>
							
						</form>
					</div>
					<br>
					<form action="user.php" method="POST">
<!-- 						<p>
							<label for="user">Ваш телефон: </label>
							<?php echo $myrow['phone']; ?>
						</p> -->
						<p>
							<label for="user">Изменить телефон:</label>
							<input name="phone" type="text" value="<?php echo $myrow['phone']; ?>">
							<button type="submit" name="submit">изменить</button>
						</p>
					</form>
					<br>
					<form action="user.php" method="POST">
<!-- 						<p>
							<label for="user">Ваш E-mail: </label>
							<?php echo $myrow['email']; ?>
						</p> -->
						<p>
							<label for="user">Изменить E-mail:</label>
							<input name="mail" type="text" value="<?php echo $myrow['email']; ?>">
							<button type="submit" name="submit">изменить</button>
						</p>
					</form>
					<br>
					<form action="user.php" method="POST">
						<p>
							<label for="user">Изменить пароль:</label>
							<input name="password" type="password">
							<button type="submit" name="submit">изменить</button>
						</p>
					</form>
					<br>
					<form action="user.php" method="POST" enctype=multipart/form-data>
						<p>
							<label for="user">Ваш аватар:</label>
							<img alt="аватар"  src=<?php echo $myrow['avatar']; ?> >
						</p>
						<p>
							<label >Выберите аватар. Изображение должно быть формата jpg, gif или png:<br></label>
							<!-- <input type="FILE" name="fupload">
							<button type="submit" name="submit">изменить</button> -->
							<div class="file_upload">
								<button type="button">Выбрать</button>
								<div>Файл не выбран</div>
								<input name="fupload" type="FILE">
							</div>
							<button type="submit" name="submit">изменить</button>
						</p>
					</form>
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
	</body>
</html>





<?php 
	$old_login = $_SESSION['login']; //Старый логин нам    пригодиться

	$id = $_SESSION['id'];//идентификатор пользователя тоже нужен
	$ava = "avatars/avatar.png";//стандартное    изображение будет кстати
	if(isset($_POST['submit'])){
		if (isset($_POST['login'])){
			$login = $_POST['login'];
			$login = stripslashes($login); $login =    htmlspecialchars($login); $login = trim($login);//удаляем все лишнее 
			if ($login == '') {
				exit("Вы не ввели логин");
			} //Если    логин пустой, то останавливаем 
			if (strlen($login) < 3 or strlen($login) > 15) {//проверяем    дину 
				exit ("Логин должен состоять не менее чем из 3 символов и не более чем из 15."); //останавливаем выполнение сценариев
			}
			//проверка на существование пользователя с таким же логином
			$result = mysql_query("SELECT id FROM    users WHERE login='$login'");
			$myrow = mysql_fetch_array($result);
			if (!empty($myrow['id'])) {
				exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин."); //останавливаем выполнение сценариев
			}
			$result4 = mysql_query("UPDATE users SET login='$login' WHERE login='$old_login'");//обновляем в базе логин пользователя 

			if ($result4=='TRUE') {//если выполнено верно, то обновляем все сообщения,    которые отправлены ему
				mysql_query("UPDATE messages SET    author='$login' WHERE author='$old_login'");
				$_SESSION['login'] = $login;//Обновляем логин в сессии 				
				echo '<script type="text/javascript">alert("Ваш логин изменен!");</script>';
				// echo "<html><head><meta    http-equiv='Refresh' content='5;    URL=page.php?id=".$_SESSION['id']."'></head><body>Ваш логин изменен! Вы    будете перемещены через 5 сек. Если не хотите ждать, то <a    href='page.php?id=".$_SESSION['id']."'>нажмите    сюда.</a></body></html>";
			}//отправляем    пользователя назад
		}

		else if (isset($_POST['full_name'])){
			$full_name = $_POST['full_name'];
			$full_name = stripslashes($full_name);
			$full_name = htmlspecialchars($full_name);
			$full_name = trim($full_name);//удаляем все лишнее 
			if ($full_name == '') {
				exit("Вы не ввели новое имя");
			} //если    пароль не введен, то выдаем ошибку
			

			$result4 = mysql_query("UPDATE users SET name='$full_name' WHERE login='$old_login'");//обновляем пароль 

			if ($result4=='TRUE') {//если верно, то обновляем его в сессии
			echo '<script type="text/javascript">alert("Ваше имя изменено!");</script>';
			// echo "<html><head><meta    http-equiv='Refresh' content='5;    URL=page.php?id=".$_SESSION['id']."'></head><body>Ваш пароль изменен! Вы    будете перемещены через 5 сек. Если не хотите ждать, то <a    href='page.php?id=".$_SESSION['id']."'>нажмите    сюда.</a></body></html>";}//отправляем    обратно на его страницу
			}
		}

		else if (isset($_POST['phone'])){
			$phone = $_POST['phone'];
			$phone = stripslashes($phone);
			$phone = htmlspecialchars($phone);
			$phone = trim($phone);//удаляем все лишнее 
			if ($phone == '') {
				exit("Вы не ввели новый телефон");
			} //если    пароль не введен, то выдаем ошибку
			

			$result4 = mysql_query("UPDATE users SET phone='$phone' WHERE login='$old_login'");//обновляем пароль 

			if ($result4=='TRUE') {//если верно, то обновляем его в сессии
			echo '<script type="text/javascript">alert("Ваш телефон изменен!");</script>';
			// echo "<html><head><meta    http-equiv='Refresh' content='5;    URL=page.php?id=".$_SESSION['id']."'></head><body>Ваш пароль изменен! Вы    будете перемещены через 5 сек. Если не хотите ждать, то <a    href='page.php?id=".$_SESSION['id']."'>нажмите    сюда.</a></body></html>";}//отправляем    обратно на его страницу
			}
		}

		else if (isset($_POST['mail'])){
			$mail = $_POST['mail'];
			$mail = stripslashes($mail);
			$mail = htmlspecialchars($mail);
			$mail = trim($mail);//удаляем все лишнее 
			if ($mail == '') {
				exit("Вы не ввели новый E-mail");
			} //если    пароль не введен, то выдаем ошибку
			

			$result4 = mysql_query("UPDATE users SET email='$mail' WHERE login='$old_login'");//обновляем пароль 

			if ($result4=='TRUE') {//если верно, то обновляем его в сессии
			echo '<script type="text/javascript">alert("Ваш E-mail изменен!");</script>';
			// echo "<html><head><meta    http-equiv='Refresh' content='5;    URL=page.php?id=".$_SESSION['id']."'></head><body>Ваш пароль изменен! Вы    будете перемещены через 5 сек. Если не хотите ждать, то <a    href='page.php?id=".$_SESSION['id']."'>нажмите    сюда.</a></body></html>";}//отправляем    обратно на его страницу
			}
		}

		else if (isset($_POST['password'])){
			$password = $_POST['password'];
			$password = stripslashes($password);$password    = htmlspecialchars($password);$password = trim($password);//удаляем все лишнее 
			if ($password == '') {
				exit("Вы не ввели пароль");
			} //если    пароль не введен, то выдаем ошибку
			if (strlen($password) < 3 or strlen($password) > 15) {//проверка на    количество символов
				exit ("Пароль должен состоять не менее чем из 3 символов и не более чем из 15."); //останавливаем выполнение сценариев
			}
			$password = md5($password);//шифруем пароль
			$password = strrev($password);// для надежности добавим реверс
			$password = $password."b3p6f";

			$result4 = mysql_query("UPDATE users SET password='$password' WHERE login='$old_login'");//обновляем пароль 

			if ($result4=='TRUE') {//если верно, то обновляем его в сессии
			$_SESSION['password'] = $password;
			echo '<script type="text/javascript">alert("Ваш пароль изменен!");</script>';
			// echo "<html><head><meta    http-equiv='Refresh' content='5;    URL=page.php?id=".$_SESSION['id']."'></head><body>Ваш пароль изменен! Вы    будете перемещены через 5 сек. Если не хотите ждать, то <a    href='page.php?id=".$_SESSION['id']."'>нажмите    сюда.</a></body></html>";}//отправляем    обратно на его страницу
			}
		}

		else if (isset($_FILES['fupload']['name'])){ //отправлялась    ли переменная	
			if (empty($_FILES['fupload']['name'])){
				//если    переменная пустая (пользователь не отправил изображение),то присваиваем ему    заранее приготовленную картинку с надписью "нет аватара"
				$avatar = "avatars/avatar.png"; //можете    нарисовать avatar.png или взять в исходниках
				$result7 = mysql_query("SELECT avatar FROM users WHERE login='$old_login'");//извлекаем текущий аватар 
				$myrow7 = mysql_fetch_array($result7);
				if ($myrow7['avatar'] == $ava){//если аватар был стандартный, то не удаляем    его, ведь у на одна картинка на всех.
					$ava = 1;
				}
				else {
					unlink($myrow7['avatar']);
				}//если аватар был свой, то    удаляем его, затем поставим стандарт
			}
			else {
			//иначе    - загружаем изображение пользователя для обновления
				$path_to_directory ='avatars/';//папка, куда будет загружаться    начальная картинка и ее сжатая копия
				if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name'])){//проверка формата исходного изображения
					$filename = $_FILES['fupload']['name'];
					$source = $_FILES['fupload']['tmp_name'];
					$target = $path_to_directory . $filename;
					move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_90_directory 
					if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
						$im = imagecreatefromgif($path_to_directory.$filename) ; //если оригинал был в формате gif, то создаем    изображение в этом же формате. Необходимо для последующего сжатия
					}
					if(preg_match('/[.](PNG)|(png)$/', $filename)) {
						$im = imagecreatefrompng($path_to_directory.$filename) ;//если    оригинал был в формате png, то создаем изображение в этом же 	формате.    Необходимо для последующего сжатия
					}

					if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
						$im = imagecreatefromjpeg($path_to_directory.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же    формате. Необходимо для последующего сжатия
					}

					//СОЗДАНИЕ    КВАДРАТНОГО ИЗОБРАЖЕНИЯ И ЕГО ПОСЛЕДУЮЩЕЕ СЖАТИЕ ВЗЯТО С САЙТА www.codenet.ru
					//    Создание квадрата 90x90 //    dest - результирующее изображение //    w - ширина изображения 
					//    ratio - коэффициент пропорциональности 
					$w = 100;  // квадратная    90x90. Можно поставить и другой размер.
					//    создаём исходное изображение на основе 
					//    исходного файла и определяем его размеры 
					$w_src = imagesx($im); //вычисляем ширину
					$h_src = imagesy($im); //вычисляем высоту изображения
					//    создаём пустую квадратную картинку 
					// важно именно truecolor!, иначе    будем иметь 8-битный результат 
					$dest = imagecreatetruecolor($w,$w); 
					nbsp;        //    вырезаем квадратную серединку по x, если фото горизонтальное 
					if ($w_src>$h_src) 
						imagecopyresampled($dest, $im, 0, 0,round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $w, $w,min($w_src,$h_src), min($w_src,$h_src)); 
						// вырезаем квадратную верхушку по    y, 
						// если фото вертикальное (хотя    можно тоже серединку) 
					if ($w_src<$h_src) 
						imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,min($w_src,$h_src),min($w_src,$h_src)); 
						//    квадратная картинка масштабируется без вырезок 
					if ($w_src==$h_src) 
						imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 

					$date=time(); //вычисляем время в настоящий момент.
					imagejpeg($dest, $path_to_directory.$date.".jpg");//сохраняем изображение формата jpg в нужную папку,    именем будет текущее время. Сделано, чтобы у аватаров не было одинаковых    имен.
					//почему    именно jpg? Он занимает очень мало места + уничтожается анимирование gif    изображения, которое отвлекает пользователя. Не очень приятно читать его    комментарий, когда краем глаза замечаешь какое-то движение.
					$avatar = $path_to_directory.$date.".jpg";//заносим в переменную путь до аватара.
					$delfull = $path_to_directory.$filename; 
					unlink ($delfull);//удаляем оригинал загруженного изображения, он нам    больше не нужен. Задачей было - получить миниатюру.
					$result7 = mysql_query("SELECT avatar FROM users WHERE login='$old_login'");//извлекаем текущий аватар пользователя

					$myrow7 = mysql_fetch_array($result7);
					if ($myrow7['avatar'] == $ava) {//если он стандартный, то не удаляем его, ведь у    нас одна картинка на всех.
						$ava = 1;
					}
					else {
						unlink($myrow7['avatar']);
					}//если аватар был свой, то    удаляем его

				}
				else {
				//в    случае несоответствия формата, выдаем соответствующее сообщение
					echo '<script type="text/javascript">alert("Аватар должен быть в формате JPG,GIF или PNG!");</script>';
					// exit ("Аватар должен быть в формате <strong>JPG,GIF или PNG</strong>");
				}
			}

			$result4 = mysql_query("UPDATE users SET avatar='$avatar' WHERE login='$old_login'");//обновляем аватар в базе 
			echo '$old_login='.$old_login;
			if ($result4=='TRUE') {//если верно, то отправляем на личную страничку
			echo '<script type="text/javascript">alert("Ваша аватарка изменена!");</script>';
			// echo "<html><head><meta    http-equiv='Refresh' content='5;    URL=index.php?id=".$_SESSION['id']."'></head><body>Ваша аватарка изменена! Вы    будете перемещены через 5 сек. Если не хотите ждать, то <a href='index.php?id=".$_SESSION['id']."'>нажмите    сюда.</a></body></html>";
			}
		}
	}
?>



style{
	
	.file_upload{
	position: relative;
	overflow: hidden;
	font-size: 1em;
	height: 2em;
	line-height: 2em;
	border: 1px solid #e7e7e7;
	width: 50%;
}

.file_upload button{
	/*float: right;*/
	width: 8em;
	height: 100%;
}
.file_upload > div{
    padding-left: 1em;
}

.file_upload input[type=file]{
	position: absolute;
/*	left: 0;
	top: 0;*/
	transform: scale(20);
	letter-spacing: 10em;     /* IE 9 fix */
	-ms-transform: scale(20); /* IE 9 fix */
	opacity: 0;
	cursor: pointer;
}
}