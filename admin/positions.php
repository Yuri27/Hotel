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
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="../js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="../js/pos.js"></script>
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
					<input class="services" type="text" name="" value="Должностя" disabled="disabled">
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
					// $q="SELECT count(*) FROM positions";
					// $res=mysql_query($q);
					// $row=mysql_fetch_row($res);
					// $total_rows=$row[0];
					// echo $total_rows;
				?>
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
				$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM positions LIMIT ?i, ?i";
				$data = $db->getAll($sql, $start, $per_page);
				$rows = $db->getOne("SELECT FOUND_ROWS()");

				//узнаем общее количество страниц и заполняем массив со ссылками
				$num_pages = ceil($rows / $per_page);

				// зададим переменную, которую будем использовать для вывода номеров страниц
				$page = 0;

				//а дальше выводим в шаблоне днные и навигацию:
				?>
				Всего должностей: <b><?=$rows?></b><br>
				<a href=".pos_class" class="open_pos">Добавить</a>
				<button id="refresh_btn" type="submit" name="refresh" onclick="window.location.reload()">Обновить</button>
				<form action="positions.php" method="POST">
					<button id="save_btn" type="submit" name="save">Сохранить</button>
				<? 
				echo '<table class="simple-little-table" style="margin-top: 10px; text-align: center;" width="50%" cellpadding="5" cellspacing="0" align=center>';
				echo '<tr><th><a>Num</a></th>
							<th><a>Должность</a></th>
							<th><a>Заработная плата</a></th></tr>';
				foreach ($data as $row){
						echo '<tr>';
						echo '<td><a>'.$row['id_position'].'</a></td>';
						echo '<td><a>'.$row['name_position'].'</a></td>';
						echo '<td><a>'.$row['salary'].'</a></td>';
						echo '</tr>';
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
			</article>
			<!-- Pushy JS -->
				<script src="../js/pushy.min.js"></script>
		</div>
		<div class="pos_div pos_class">
			<p class="pos_close">X</p>
				<form action="positions.php" method="POST">
					<h3>Добавление должности</h3>
					<p>
						<label for="login">Название</label>
						<input type="text" name="name" size="30" maxlength="40"/>
					</p>
					<p>
						<label for="login">Заработная плата</label>
						<input type=text name=salary  onkeyUp="return proverka(this);" size=30 maxlength=40 />
						<script>
							function proverka(input) {
								ch = input.value.replace(/[^\d,]/g, ''); //разрешаем вводить только числа и запятую
								pos = ch.indexOf(','); // проверяем, есть ли в строке запятая
									if(pos != -1){ // если запятая есть
										if((ch.length-pos)>2){ // проверяем, сколько знаков после запятой, если больше 1го то
											ch = ch.slice(0, -1); // удаляем лишнее
										}
									}
								input.value = ch; // приписываем в инпут новое значение
							};
						</script>
					</p>
					<p style="text-align: center; padding-bottom: 10px;">
						<button class="login-btn" type="submit" id="button" name="pos_add">Добавить</button>
					</p>
				</form>
		</div>
		<div id="overlay"></div>  
	</body>
</html>

<?php 
if(isset($_POST['pos_add'])){
	$errors = array();
	if( trim($_POST['name'])=='' ){
			$errors[]='Введите название:';
		}
	if( trim($_POST['salary']=='' )){
		$errors[]='Введите заработную плату:';
	}
	$result = mysql_query("SELECT id_position FROM positions WHERE name_position='".$_POST['name']."'");
	$myrow = mysql_fetch_array($result);
	if (!empty($myrow['id_position'])) {
		echo '<script type="text/javascript">alert("Такая должность уже существует, пожалуйста, введите другую.");</script>';
		exit ();
	}
	if( empty($errors)){	//заповнюємо таблицю
		mysql_query("INSERT INTO positions (name_position,salary) VALUES 
				('".$_POST['name']."','".$_POST['salary']."')");
			echo '<script type="text/javascript">alert("Должность добавлена!");</script>';
		}
		else{
			echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
		}	
}
?>