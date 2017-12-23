<?php
	require "../connection.php";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=windows-1251">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Отчетность</title>
		<link rel="shortcut icon" href="../images/rad.ico" type="image/x-icon">
		<link rel="stylesheet" href="../css/styles.css" type="text/css">
		<link rel="stylesheet" href="../css/table.css" type="text/css">
		<!-- Pushy CSS -->
		<link rel="stylesheet" href="../css/pushy.css" type="text/css"> 

		<link rel="stylesheet" href="../css/slider.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">       
        <!-- jQuery -->
        <script src="../js/jquery-3.2.1.js"></script>
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
					<input class="services" type="text" name="" value="Отчет" disabled="disabled">
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
				<form action="reports.php" method="POST" id="reports">
				<h2>Выберете период (с ... по ...)</h2>
					<p>
						<input type="date" name="data_s" value="<?php echo date('Y-m-d');?>">
						<input type="date" name="data_po" value="<?php echo  date("Y-m-d", (time()+3600*24));?>">
					</p>
					<button type="submit" name="report-btn">показать</button>
						
				</form>
			</article>
			<!-- Pushy JS -->
				<script src="../js/pushy.min.js"></script>
		</div>
	</body>
</html>
<?php
					$data = $_POST;
					$orders = mysql_query("SELECT * FROM orders WHERE date_issue>='".$_POST['data_s']."' AND date_issue <='".$_POST['data_po']."'");
					$new=mysql_fetch_array($orders);
					$clients = mysql_query("SELECT * FROM clients WHERE id='".$new['id_client']."'");
					$name_client=mysql_fetch_array($clients);
					echo '<table class="simple-little-table" style="margin-top: 100px; text-align: center;" width="100%" cellpadding="5" cellspacing="0" align=center>';	
					echo '<tr><th width=30px ><a>Заказ</a></th>
							<th width=30px ><a>Комната</a></th>
							<th width=60px ><a>Город</a></th>
							<th width=60px ><a>Клиент</a></th>
							<th width=60px ><a>Дети</a></th>
							<th width=60px ><a>Взрослые</a></th>
							<th width=60px ><a>Метод оплаты</a></th>
							<th width=60px ><a>Цена за услуги</a></th>
							<th width=60px ><a>Общая сумма</a></th>
							<th width=60px ><a>Дата заезда</a></th>
							<th width=60px ><a>Дата отъезда</a></th>
							<th width=60px ><a>Дата заказа</a></th></tr>';					
						do{						
					$clients = mysql_query("SELECT * FROM clients WHERE id='".$new['id_client']."'");
					$name_client=mysql_fetch_array($clients);
						echo '<tr>';
						echo '<td><a>'.$new['id_order'].'</a></td>';
						echo '<td><a>'.$new['id_status'].'</a></td>';
						echo '<td><a>'.$new['name_city'].'</a></td>';
						echo '<td><a>'.$name_client['full_name_client'].'</a></td>';
						echo '<td><a>'.$new['child'].'</a></td>';
						echo '<td><a>'.$new['grown'].'</a></td>';
						echo '<td><a>'.$new['status'].'</a></td>';
						echo '<td><a>'.$new['cost_services'].'</a></td>';
						echo '<td><a>'.$new['all_cost'].'</a></td>';
						echo '<td><a>'.$new['date_issue'].'</a></td>';
						echo '<td><a>'.$new['issued_by'].'</a></td>';
						echo '<td><a>'.$new['order_date'].'</a></td>';
						echo '</tr>';
						$sum=$sum+$new['all_cost'];
					}while ($new=mysql_fetch_array($orders));
						echo '</table>';
				?>
				<h2 align="center"> Всего было заработано в период с <?php echo $_POST['data_s']; ?> по <?php echo $_POST['data_po']; ?><br>

				<?php echo $sum; ?> грн.</h2>