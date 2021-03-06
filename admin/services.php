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
        <script type="text/javascript" src="../js/ser.js"></script>
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
				$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM services LIMIT ?i, ?i";
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
				<a href=".ser_class" class="open_ser">Добавить</a>
				<button id="refresh_btn" type="submit" name="refresh" onclick="window.location.reload()">Обновить</button>
				<form action="services.php" method="POST" enctype=multipart/form-data>
					<table cellspacing="0" align=center class="simple-little-table">
					<tr><th><a><font size="3" color="red" face="Arial">*</font>№</a></th>
					<th><a>Название</a></th>
					</tr>
					<tr><td><input type="text" name="id_cat" placeholder="id_cat"></td>
					<td><input type="text" name="name_cat" placeholder="name_cat"></td></tr>	
					</table>
					<button id="save_btn" type="submit" name="save">Сохранить</button>


				<? 
				echo '<table class="simple-little-table" cellpadding="5" cellspacing="0" align=center>';
				echo '<tr><th><a>Название</a></th>
						<th><a>Цена</a></th></tr>';
				foreach ($data as $row){
						echo '<tr>';
						echo '<td><input style="width:150px;" type="text" name="name_category" value="'.$row['service_type'].'" ></td>';
						echo '<td><input style="width:50px;" type="text" name="number_rooms" value="'.$row['service_cost'].'"></td>';
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
			<div class="ser_div ser_class">
			<p class="ser_close">X</p>
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
	if(isset($_POST['save'])){
		if( trim($_POST['id_cat'])=='' ){
			$errors[]='Введите номер категории для редактирования!';
		}

		if( empty($errors)){
			$id = $_POST['id_cat'];

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

		}

		else{
			echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
		}
	}
?>