<?php
	require "../connection.php";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=windows-1251">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Заказы</title>
		<link rel="shortcut icon" href="../images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="../css/styles.css" type="text/css">
		<link rel="stylesheet" href="../css/table.css" type="text/css">

		<!-- Pushy CSS -->
		<link rel="stylesheet" href="../css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="../css/slider.css">
		<link rel="stylesheet" href="../css/categories.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="../js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="../js/cat.js"></script>
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
							$login = $_SESSION['phone'];
							$password = $_SESSION['pass'];
							if (empty($_SESSION['phone']) or empty($_SESSION['id_employee'])){// Если пусты, то мы не выводим ссылку
								// echo '<div id="user"><h3>Авторизируйтесь</h3></div><a href=".login_class" class="open_login"></a><a href="registration.php"></a>';
								echo '<script>location.replace("index.php");</script>';
							}
							else{// Если не пусты, то мы выводим ссылку
								echo '<div id="user"><h4 title="пользователь '.$login.'">'.$login.'</h4></div><a href="exit.php">Выйти</a>';
							}
						?>	
					</div>
					<a href="/"><img class="search" src="../images/logo/logos.png" alt="Radissonblu logo"></a>					
					<input class="services" type="text" name="" value="Категории" disabled="disabled">
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
								<button id="first-link">Бронирование</button>
								<ul>
									<li class="pushy-link"><a href="clients.php">Клиенты</a></li>
									<li class="pushy-link"><a href="orders.php">Заказы</a></li>
								</ul>
							</li>
							<li class="pushy-submenu">
							<button>Сотрудники</button>
								<ul>
									<li class="pushy-link"><a href="staff.php">Сотрудники</a></li>
									<li class="pushy-link"><a href="positions.php">Должности</a></li>
								</ul>
							</li>
							<li class="pushy-submenu">
								<button>Номера</button>
								<ul>
									<li class="pushy-link"><a href="rooms.php">Номера</a></li>
									<li class="pushy-link"><a href="category.php">Категории</a></li>
								</ul>
							</li>							
							<li class="pushy-link"><a href="users.php">Пользователи</a></li>
							<li class="pushy-link"><a href="reports.php">Отчет</a></li>
						</ul>
					</div>
				</nav>
			</aside>
			<article>
				<?php
				include 'safemysql.class.php';
				$db = new safeMysql();

				$per_page = 15;

				//получаем номер страницы и значение для лимита 
				$cur_page = 1;
				if (isset($_GET['page']) && $_GET['page'] > 0) 
				{
				    $cur_page = $_GET['page'];
				}
				$start = ($cur_page - 1) * $per_page;

				//выполняем запрос и получаем данные для вывода
				$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM categories LIMIT ?i, ?i";
				$data = $db->getAll($sql, $start, $per_page);
				$rows = $db->getOne("SELECT FOUND_ROWS()");

				//узнаем общее количество страниц и заполняем массив со ссылками
				$num_pages = ceil($rows / $per_page);

				// зададим переменную, которую будем использовать для вывода номеров страниц
				$page = 0;

				//а дальше выводим в шаблоне днные и навигацию:
				?>
				Всего категорий: <b><?=$rows?></b><br>
				<!-- <textarea rows='1' name="aboutcat" placeholder='Auto-Expanding Textarea'></textarea> -->
				<a href=".cat_class" class="open_cat">Добавить</a>
				<button id="refresh_btn" type="submit" name="refresh" onclick="window.location.reload()">Обновить</button>
				<form action="category.php" method="POST" enctype=multipart/form-data>
					<table cellspacing="0" align=center class="simple-little-table">
					<tr><th><a><font size="3" color="red" face="Arial">*</font>№</a></th>
					<th><a>Название</a></th>
							<th><a>Количество номеров</a></th>
							<th><a>Количество комнат</a></th>
							<th><a>Цена</a></th>
							<th><a>О категории</a></th>
							<th><a>Фото</a></th></tr>
					<tr><td><input style="width:60px" type="text" name="id_cat" placeholder="id_cat"></td>
					<td><input type="text" name="name_cat" placeholder="name_cat"></td>
					<td><input style="width:60px" type="text" name="num_rooms" placeholder="num_rooms"></td>
					<td><input style="width:60px" type="text" name="quant_rooms" placeholder="quant_rooms"></td>
					<td><input style="width:60px" type="text" name="cost_cat" placeholder="cost_cat"></td>
					<td><input style="width:300px" type="text" name="about_cat" placeholder="about_cat"></td>
					<!-- <input type="file" name="fupload" placeholder="image_cat"> -->
					<td><input style="width:215px" type="FILE" name="fupload" id="file" class="inputfile" /></td></tr>	
					</table>
					<button id="save_btn" type="submit" name="save">Сохранить</button>


				<? 
				echo '<table class="simple-little-table" cellpadding="5" cellspacing="0" align=center>';
				echo '<tr><th><a>Название</a></th>
							<th><a>Количество номеров</a></th>
							<th><a>Количество комнат</a></th>
							<th><a>Цена</a></th>
							<th><a>О категории</a></th>
							<th><a>Фото</a></th></tr>';
				foreach ($data as $row){
						echo '<tr>';
						echo '<td><input style="width:150px;" type="text" name="name_category" value="'.$row['name_category'].'" ></td>';
						echo '<td><input style="width:50px;" type="text" name="number_rooms" value="'.$row['number_rooms'].'"></td>';
						echo '<td><input style="width:50px;" type="text" name="quantity_rooms" value="'.$row['quantity_rooms'].'"></td>';
						echo '<td><input style="width:50px;" type="text" name="cost" value="'.$row['cost'].'"></td>';
						echo '<td><textarea rows="5" name="about">'; 
							$path='../'.$row['about'];
							// echo '<script type="text/javascript">alert($path);</script>';
							print file_get_contents($path); echo '</textarea></td>';
							echo '<td><img src=../'.$row['images'].' </td>';
						// echo '<td><img src=../'.$row['images'].'><input type="file" name="images" value="'.$row['images'].'"></td>';
						echo '</tr>';
						$path=0;
				}
				echo '</table>';
				echo 'Страницы:';
				while ($page++ < $num_pages): ?>
				<? if ($page == $cur_page): ?>
				<b><?=$page?></b>
				<? else: ?> 
				<a href="?page=<?=$page?>"><?=$page?></a>
				<? endif ?> 
				<? endwhile ?>
				</form>
			</article>
			<!-- Pushy JS -->
				<script src="../js/pushy.min.js"></script>
		</div>
			<div class="cat_div cat_class">
			<p class="cat_close">X</p>
				<form action="category.php" method="POST" enctype=multipart/form-data>
					<h3>Добавить категорию</h3>
					<div id="bl1">
						<label for="cat"><font size="3" color="red" face="Arial">*</font>Название</label>
						<input type="text" name="namecat" placeholder="name_cat">
						<p>
						<label for="cat"><font size="3" color="red" face="Arial">*</font>Кол.номеров</label>
						<input style="width:115px; margin-left: 0px;" type="text" name="numrooms" placeholder="num_rooms">
						<label for="cat1"><font size="3" color="red" face="Arial">*</font>Кол.комнат</label>
						<input style="width:115px; margin-left: 0px;" type="text" name="quantrooms" placeholder="quant_rooms">
						<label for="cat1"><font size="3" color="red" face="Arial">*</font>Цена</label>
						<input style="width:120px" type="text" name="costcat" placeholder="costcat">
						</p>
						<label for="cat"><font size="3" color="red" face="Arial">*</font>Фото</label>
						<input type="FILE" name="uploadfile" id="file" class="inputfile" />	
					</div>

					<div id="bl2">
						<label for="cat"><font size="3" color="red" face="Arial">*</font>Описание</label>
						<textarea rows="8" name="aboutcat" placeholder='Auto-Expanding Textarea'></textarea>
						<script>
							var textarea = document.querySelector('textarea');

							textarea.addEventListener('keydown', autosize);

								function autosize(){
								var el = this;
								setTimeout(function(){
								el.style.cssText = 'height:auto; padding:0';
								// for box-sizing other than "content-box" use:
								// el.style.cssText = '-moz-box-sizing:content-box';
								el.style.cssText = 'height:' + el.scrollHeight + 'px';
								},0);
							}
						</script>
						
						
					</div>
					<button id="cat-btn" type="submit" name="insert" >Добавить</button>				
				</form>
		</div>
		<div id="overlay"></div>
	</body>
</html>

<?php 
	if(isset($_POST['insert'])){
		// if(isset($_FILES['uploadfile']['name'])){
		// 	$uploaddir= '../photo/'; 
		// 	$fot = $_FILES['uploadfile']['name'];
		// 	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $fot)) {;
		// 	$res= mysql_query ("INSERT INTO categories (images) VALUES ('$fot')");
		// 		if($res)
		// 			echo "Файл упешно загружен";
		// 		else
		// 			echo "Путь не добавлен в базу данных, но файл загружен";
		// 	}
		// }

		if( trim($_POST['namecat'])=='' ){
			$errors[]='Введите категорию:';
		}
		if( trim($_POST['numrooms']=='' )){
			$errors[]='Введите количество номеров:';
		}
		if( trim($_POST['quantrooms'])=='' ){
			$errors[]='Введите количество комнат:';
		}
		if( trim($_POST['costcat'])=='' ){
			$errors[]='Введите цену:';
		}
		if( trim($_POST['aboutcat'])=='' ){
			$errors[]='Введите описание:';
		}

		if (isset($_FILES['uploadfile']['name'])){ //отправлялась    ли переменная	
			$path_to_directory ='../photo/';//папка, куда будет загружаться    начальная картинка и ее сжатая копия
			if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['uploadfile']['name'])){//проверка формата исходного изображения
				$filename = $_FILES['uploadfile']['name'];
				$source = $_FILES['uploadfile']['tmp_name'];
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

				$w = 640;
				$h = 480;  
				$w_src = imagesx($im); //вычисляем ширину
				$h_src = imagesy($im); //вычисляем высоту изображения
				//    создаём пустую квадратную картинку 
				// важно именно truecolor!, иначе будем иметь 8-битный результат 
				$dest = imagecreatetruecolor($w,$h); 
				nbsp;        //вырезаем квадратную серединку по x, если фото горизонтальное 
				if ($w_src>$h_src) 
					imagecopyresampled($dest, $im, 0, 0,round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $w, $h,min($w_src,$h_src), min($w_src,$h_src)); 
					// вырезаем квадратную верхушку по y, 
					// если фото вертикальное (хотя    можно тоже серединку) 
				if ($w_src<$h_src) 
					imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h,min($w_src,$h_src),min($w_src,$h_src)); 
					//    квадратная картинка масштабируется без вырезок 
				if ($w_src==$h_src) 
					imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h, $w_src, $w_src); 

					$date=time(); //вычисляем время в настоящий момент.
					imagejpeg($dest, $path_to_directory.$date.".jpg");
					$avatar = $path_to_directory.$date.".jpg";
					$delfull = $path_to_directory.$filename; 
					unlink ($delfull);//удаляем оригинал загруженного изображения

			}
			else {
			
				$errors[]='Аватар должен быть в формате JPG,GIF или PNG!';
				
			}
		}

		if( empty($errors)){
			$uploaddir= '../about/';
			$name = $_POST['namecat'];
			$path = $uploaddir.$name.".txt";
			$fp = fopen($uploaddir.($name).".txt", "a"); // Открываем файл в режиме записи 
			$mytext = $_POST['aboutcat']; // Исходная строка
			$test = fwrite($fp, $mytext); // Запись в файл
			$result4 = mysql_query("INSERT INTO categories (name_category,number_rooms,quantity_rooms,cost,about,images) VALUES ('".$_POST['namecat']."','".$_POST['numrooms']."','".$_POST['quantrooms']."','".$_POST['costcat']."','$path','$avatar')");//обновляем аватар в базе 
		
			echo '<script type="text/javascript">alert("Категория добавлена!");</script>';
		}
		else{
			echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
		}	
	}
	if(isset($_POST['save'])){
		if( trim($_POST['id_cat'])=='' ){
			$errors[]='Введите номер категории для редактирования!';
		}

		if( empty($errors)){
			$id = $_POST['id_cat'];
			// if (isset($_POST['name_cat'])){
			// 	$result4 = mysql_query("UPDATE categories SET name_category='".$_POST['name_cat']."' WHERE id_category='$id'");
			// 	if ($result4=='TRUE') {
			// 		echo '<script type="text/javascript">alert("Изменения сохранены!");</script>';
			// 	}
			// 	else{
			// 		echo '<script type="text/javascript">alert("Введите name_cat!");</script>';
			// 	}
			// }

			// if (isset($_POST['num_rooms'])){
			// 	$result4 = mysql_query("UPDATE categories SET name_category='".$_POST['num_rooms']."' WHERE id_category='$id'");
			// 	if ($result4=='TRUE') {
			// 		echo '<script type="text/javascript">alert("Изменения сохранены!");</script>';
			// 	}
			// 	else{
			// 		echo '<script type="text/javascript">alert("Введите num_rooms!");</script>';
			// 	}
			// }

			// if (isset($_POST['quant_rooms'])){
			// 	$result4 = mysql_query("UPDATE categories SET name_category='".$_POST['quant_rooms']."' WHERE id_category='$id'");
			// 	if ($result4=='TRUE') {
			// 		echo '<script type="text/javascript">alert("Изменения сохранены!");</script>';
			// 	}
			// 	else{
			// 		echo '<script type="text/javascript">alert("Введите quant_rooms!");</script>';
			// 	}
			// }

			// if (isset($_POST['cost_cat'])){
			// 	$result4 = mysql_query("UPDATE categories SET name_category='".$_POST['cost_cat']."' WHERE id_category='$id'");
			// 	if ($result4=='TRUE') {
			// 		echo '<script type="text/javascript">alert("Изменения сохранены!");</script>';
			// 	}
			// 	else{
			// 		echo '<script type="text/javascript">alert("Введите cost_cat!");</script>';
			// 	}
			// }
			if (isset($_POST['about_cat'])){
				$file=mysql_fetch_array(mysql_query("SELECT about FROM categories WHERE id_category='$id'"));
					echo '<script type="text/javascript">alert("'.$file['about'].'");</script>';

					$t=$_POST['about_cat'];
                     if(!empty($t)) 
                     	file_put_contents($file['about'],$t);

				// $result4 = mysql_query("UPDATE categories SET name_category='".$_POST['about_cat']."' WHERE id_category='$id'");
				// if ($result4=='TRUE') {
				// 	echo '<script type="text/javascript">alert("Изменения сохранены!");</script>';
				// }
				// else{
				// 	echo '<script type="text/javascript">alert("Введите about_cat!");</script>';
				// }
			}

		//  if (isset($_FILES['fupload']['name'])){ //отправлялась    ли переменная	
		// 	if (empty($_FILES['fupload']['name'])){
		// 		//если    переменная пустая (пользователь не отправил изображение),то присваиваем ему    заранее приготовленную картинку с надписью "нет аватара"
		// 		$avatar = "../photo/thumb03.jpg"; //можете    нарисовать avatar.png или взять в исходниках
		// 		$result7 = mysql_query("SELECT images FROM categories WHERE id_category='$id'");//извлекаем текущий аватар 
		// 		$myrow7 = mysql_fetch_array($result7);
		// 		if ($myrow7['images'] == $ava){//если аватар был стандартный, то не удаляем    его, ведь у на одна картинка на всех.
		// 			$ava = 1;
		// 		}
		// 		else {
		// 			unlink($myrow7['images']);
		// 		}//если аватар был свой, то    удаляем его, затем поставим стандарт
		// 	}
		// 	else {
		// 	//иначе    - загружаем изображение пользователя для обновления
		// 		$path_to_directory ='../photo/';//папка, куда будет загружаться    начальная картинка и ее сжатая копия
		// 		if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name'])){//проверка формата исходного изображения
		// 			$filename = $_FILES['fupload']['name'];
		// 			$source = $_FILES['fupload']['tmp_name'];
		// 			$target = $path_to_directory . $filename;
		// 			move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_90_directory 
		// 			if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
		// 				$im = imagecreatefromgif($path_to_directory.$filename) ; //если оригинал был в формате gif, то создаем    изображение в этом же формате. Необходимо для последующего сжатия
		// 			}
		// 			if(preg_match('/[.](PNG)|(png)$/', $filename)) {
		// 				$im = imagecreatefrompng($path_to_directory.$filename) ;//если    оригинал был в формате png, то создаем изображение в этом же 	формате.    Необходимо для последующего сжатия
		// 			}

		// 			if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
		// 				$im = imagecreatefromjpeg($path_to_directory.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же    формате. Необходимо для последующего сжатия
		// 			}

		// 			$w = 640;
		// 			$h = 480;  
		// 			$w_src = imagesx($im); //вычисляем ширину
		// 			$h_src = imagesy($im); //вычисляем высоту изображения
		// 			//    создаём пустую квадратную картинку 
		// 			// важно именно truecolor!, иначе будем иметь 8-битный результат 
		// 			$dest = imagecreatetruecolor($w,$h); 
		// 			nbsp;        //вырезаем квадратную серединку по x, если фото горизонтальное 
		// 			if ($w_src>$h_src) 
		// 				imagecopyresampled($dest, $im, 0, 0,round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $w, $h,min($w_src,$h_src), min($w_src,$h_src)); 
		// 				// вырезаем квадратную верхушку по y, 
		// 				// если фото вертикальное (хотя    можно тоже серединку) 
		// 			if ($w_src<$h_src) 
		// 				imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h,min($w_src,$h_src),min($w_src,$h_src)); 
		// 				//    квадратная картинка масштабируется без вырезок 
		// 			if ($w_src==$h_src) 
		// 				imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h, $w_src, $w_src); 

		// 				$date=time(); //вычисляем время в настоящий момент.
		// 				imagejpeg($dest, $path_to_directory.$date.".jpg");
		// 				$avatar = $path_to_directory.$date.".jpg";
		// 				$delfull = $path_to_directory.$filename; 
		// 				unlink ($delfull);//удаляем оригинал загруженного изображения

		// 		}
		// 		else {
				
		// 			echo '<script type="text/javascript">alert("Аватар должен быть в формате JPG,GIF или PNG!");</script>';
					
		// 		}
		// 	}

		// 	$result4 = mysql_query("UPDATE categories SET images='$avatar' WHERE id_category='$id'");//обновляем аватар в базе 
			
		// 		if ($result4=='TRUE') {
		// 			echo '<script type="text/javascript">alert("Ваша аватарка изменена!");</script>';
		// 		}
		// }
		}

		else{
			echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
		}
	}
?>