<?php
	require "../connection.php";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Номера</title>
		<link rel="shortcut icon" href="../images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="../css/styles.css" type="text/css">
		<link rel="stylesheet" href="../css/staff.css" type="text/css">
		<link rel="stylesheet" href="../css/table.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="../css/pushy.css" type="text/css"> 
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="../js/jquery-3.2.1.js"></script>
        <script src="../js/jquery.maskedinput.min.js"></script>
		<script src="../js/date.format.js"></script>
		<script type="text/javascript" src="../js/login.js"></script><!-- всплывающее окно -->
		<script type="text/javascript" src="../js/room.js"></script><!-- всплывающее окно -->
		<script type="text/javascript" src="../js/phone.js"></script>
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
					<input class="services" type="text" name="" value="Номера" disabled="disabled">
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

				$per_page = 50;

				//получаем номер страницы и значение для лимита 
				$cur_page = 1;
				if (isset($_GET['page']) && $_GET['page'] > 0) 
				{
				    $cur_page = $_GET['page'];
				}
				$start = ($cur_page - 1) * $per_page;

				//выполняем запрос и получаем данные для вывода
				$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM rooms LIMIT ?i, ?i";
				$data = $db->getAll($sql, $start, $per_page);
				$rows = $db->getOne("SELECT FOUND_ROWS()");

				//узнаем общее количество страниц и заполняем массив со ссылками
				$num_pages = ceil($rows / $per_page);

				// зададим переменную, которую будем использовать для вывода номеров страниц
				$page = 0;

				//а дальше выводим в шаблоне днные и навигацию:
				?>
				Всего номеров: <b><?=$rows?></b><br>
				<a href=".room_class" class="open_room">Добавить</a>
				<button id="refresh_btn" type="submit" name="refresh" onclick="window.location.reload()">Обновить</button>
				<form action="rooms.php" method="POST">
					<table cellspacing="0" align=center class="simple-little-table">
						<tr><th><a><font size="3" color="red" face="Arial">*</font>№</a></th>
						
								<th><a>Фото</a></th></tr>
						<tr><td><input style="width:60px" type="text" name="id_categ" placeholder="id_cat"></td>
						<td>
						<select name=categ>
								<?php 
								$cat = mysql_query("SELECT name_category FROM categories");
								$name_cat=mysql_fetch_array($cat);
								do{
									echo '<option value='.$name_cat['name_category'].'>'.$name_cat['name_category'].'</option>';
								}while($name_cat=mysql_fetch_array($cat));
								 ?>
						 </select></td></tr>
					</table>
					<button id="save_btn" type="submit" name="save">Сохранить</button>
				<? 
				echo '<table class="simple-little-table" style="margin-top: 10px; text-align: center;" width="100%" cellpadding="5" cellspacing="0" align=center>';
				echo '<tr><th ><a>Полное имя</a></th>
						<th ><a>Номер</a></th>
						<th  ><a>Полное имя</a></th>
						<th ><a>Номер</a></th>
						<th ><a>Полное имя</a></th>
						<th  ><a>Номер</a></th>
						<th ><a>Полное имя</a></th>
						<th  ><a>Номер</a></th>
						<th ><a>Полное имя</a></th>
						<th  ><a>Номер</a></th></tr>';
				foreach ($data as $row){
					$count++;
					$posit = mysql_query("SELECT name_category FROM categories WHERE id_category='".$row['id_category']."'");
					$name_posit=mysql_fetch_array($posit);
					if($count!=5){
						echo '<td><a>'.$row['name_room'].'</a></td>';
						echo '<td><a>'.$name_posit['name_category'].'</a></td>';
					}
										else{
						echo '<td><a>'.$row['name_room'].'</a></td>';
						echo '<td><a>'.$name_posit['name_category'].'</a></td>';
						$count=0;
								echo "<tr></tr>";}
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
		<div class="room_div room_class">
			<p class="room_close">X</p>
				<form action="rooms.php" method="POST">
					<h3>Добавить номер</h3>
					<p>
						<label for="login">Комната под номером</label>
						<input type="number" name="num" min="371" value="371" size="30" maxlength="40"/>
					</p>
					<p>
						<label for="login">Категория номера</label>
						<select name=cat>
						<?php 
						$cat = mysql_query("SELECT name_category FROM categories");
						$name_cat=mysql_fetch_array($cat);
						do{
						echo '<option value='.$name_cat['name_category'].'>'.$name_cat['name_category'].'</option>';
					}while($name_cat=mysql_fetch_array($cat));
						 ?>
						 </select>
					</p>
					<button id="staff-btn" type="submit" name="rooms_add" onClick="validate(this.form)">Добавить</button>				
				</form>
		</div>
		<div id="overlay"></div>
	</body>
</html>
<?php 
if(isset($_POST['save'])){
	$result = mysql_fetch_array(mysql_query("SELECT * FROM categories WHERE name_category='".$_POST['categ']."'"));
	$update=mysql_query("UPDATE rooms SET id_category='$result[0]' WHERE name_room='".$_POST['id_categ']."'");

	if($update){
		echo '<script type="text/javascript">alert("Сотрудник добавлен!");</script>';
	}
		
	else{
		echo '<script type="text/javascript">alert("sasa");</script>';
	}	
}
	if(isset($_POST['rooms_add'])){
		echo $_POST['cat'];
			$result = mysql_fetch_array(mysql_query("SELECT * FROM categories WHERE name_category='".$_POST['cat']."'"));
			// print $result[0];
			$insert=mysql_query("INSERT INTO rooms (name_room,id_category) VALUES 
			('".$_POST['num']."','$result[0]')");

			if($insert){
				echo '<script type="text/javascript">alert("Сотрудник добавлен!");</script>';
			}
		
		else{
			echo '<script type="text/javascript">alert("sasa");</script>';
		}	
	}
?>