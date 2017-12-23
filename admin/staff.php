<?php
	require "../connection.php";
?>

<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<title>Заказы</title>
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
		<script type="text/javascript" src="../js/staff.js"></script><!-- всплывающее окно -->
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
					<input class="services" type="text" name="" value="Сотрудники" disabled="disabled">
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

				$per_page = 10;

				//получаем номер страницы и значение для лимита 
				$cur_page = 1;
				if (isset($_GET['page']) && $_GET['page'] > 0) 
				{
				    $cur_page = $_GET['page'];
				}
				$start = ($cur_page - 1) * $per_page;

				//выполняем запрос и получаем данные для вывода
				$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM staff LIMIT ?i, ?i";
				$data = $db->getAll($sql, $start, $per_page);
				$rows = $db->getOne("SELECT FOUND_ROWS()");

				//узнаем общее количество страниц и заполняем массив со ссылками
				$num_pages = ceil($rows / $per_page);

				// зададим переменную, которую будем использовать для вывода номеров страниц
				$page = 0;

				//а дальше выводим в шаблоне днные и навигацию:
				?>
				Всего сотрудников: <b><?=$rows?></b><br>
				<a href=".staff_class" class="open_staff">Добавить</a>
				<button id="refresh_btn" type="submit" name="refresh" onclick="window.location.reload()">Обновить</button>
				<form action="staff.php" method="POST">
					<button id="save_btn" type="submit" name="save">Сохранить</button>
				<? 
				echo '<table class="simple-little-table" style="margin-top: 10px; text-align: center;" width="100%" cellpadding="5" cellspacing="0" align=center >';
				echo '<tr><th width=70px ><a>Полное имя</a></th>
							<th width=60px ><a>Номер</a></th>
							<th width=60px ><a>Адресс</a></th>
							<th width=30px ><a>Возраст</a></th>
							<th width=60px ><a>Дата приема</a></th>
							<th width=60px ><a>Должность</a></th>
							<th width=60px ><a>Стаж</a></th>
							<th width=60px ><a>Уволен</a></th></tr>';
				foreach ($data as $row){
					$posit = mysql_query("SELECT * FROM positions WHERE id_position='".$row['id_position']."'");
					$name_posit=mysql_fetch_array($posit);
						echo '<tr>';
						echo '<td><a>'.$row['full_name_employee'].'</a></td>';
						echo '<td><a>'.$row['phone'].'</a></td>';
						echo '<td><a>'.$row['adress'].'</a></td>';
						echo '<td><a>'.$row['age'].'</a></td>';
						echo '<td><a>'.$row['date_admission'].'</a></td>';
						echo '<td><a>'.$name_posit['name_position'].'</a></td>';
						echo '<td><a>'.$row['experience'].'</a></td>';
						if ($row['status']=='Y')
							echo '<td><a><input type="checkbox" name="status[]" value='.$row['id_employee'].'></input></a></td>';
						else
							echo '<td><a><input type="checkbox" name="status[]" value='.$row['id_employee'].' checked></input></a></td>';
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
				</form>	
			</article>
			<!-- Pushy JS -->
				<script src="../js/pushy.min.js"></script>
		</div>
		<div class="staff_div staff_class">
			<p class="staff_close">X</p>
				<form action="staff.php" method="POST">
					<h3>Добавить сотрудника</h3>
				<div id="blok_1">
					<p><label for="staff"><font size="3" color="red" face="Arial">*</font>Имя</label>
					<input name="full_name" type="text" size="15" maxlength="40" value="<?php echo @$_POST['full_name'];?>"></p>
					<p>
					<label for="staff">Телефон: </label>
					<select id="country" style='width:165px;  margin-left: 0px;' >
						<option value="+380">Украина +380</option>														
						<option value="+375">Белорусь +375</option>
						<option value="+1">США +1</option>
						<option value="+44">Англия +44</option>
						<option value="+90">Турция +90</option>
						<option value="+34">Испания +34</option>
						<option value="+7">Россия +7</option>
					</select>
					<input id="phone" for="phones" name="num_phone" type="text" class="form-control" value="<?php echo @$_POST['num_phone'];?>" style='width:200px; margin-left: 0px;'>
					</p>
					<p>
						<label for="staff" >Пол</label>
						<select type="text" name="gender" style='width:190px; margin-left: -178px;'>												
								<option value="Мужской">Мужской</option>
								<option value="Женский">Женский</option>
						</select>
						<label for="staff1"><font size="3" color="red" face="Arial">*</font>Дата рождения</label>
						<input style='width:170px; margin-right: -199px; height: 32px;' max="<?php echo date('Y-m-d', (time()-568080000));?>" name="birth" type="date" value="<?php echo @$_POST['birth'];?>" title="Возраст сотрудника от 18 до 50 лет"> 
					</p>
				</div>
				<div id="blok_2">
					<p>
						<label for="staff"><font size="3" color="red" face="Arial">*</font>Адресс</label>
						<select style='width:85px' name="street">
							<option value="ул.">ул.</option>														
							<option value="просп.">просп.</option>
							<option value="б-р">б-р</option>
							<option value="пл.">пл.</option>
							<option value="пер.">пер.</option>
						</select>
						<input style='width:280px' id="street" name="adress" type="text" size="15" maxlength="60" value="<?php echo @$_POST['adress'];?>">
					</p>
					<p>
						<label for="staff"><font size="3" color="red" face="Arial">*</font>Должность</label>
						<select name=posit style='width:370px'>
						<?php
							$result=mysql_query("SELECT * from positions");
							$myrow=mysql_fetch_array($result);
							do{
								echo '<option value='.$myrow['name_position'].'>'.$myrow['name_position'].'</option>';
							}
							while($myrow=mysql_fetch_array($result));
						?>
						</select>
					</p>
					<p>
						<label for="staff"><font size="3" color="red" face="Arial">*</font>Паспорт</label>
						<input style='width:115px; margin-left: -250px;' name="pasport" type="text" value="<?php echo @$_POST['pasport'];?>" placeholder="AK123456"> 
						
						<label style='margin-left: 140px;' for="staff1"><font size="3" color="red" face="Arial">*</font>Дата приема</label>
						<input style='width:180px; margin-left: 65px; height: 32px;' max="<?php echo date('Y-m-d');?>" name="admission" type="date" value="<?php echo @$_POST['admission'];?>" > 
						
						<label style='margin-left: 330px;' for="staff1">Стаж</label>
						<input style='width:50px; margin-right: -315px;' name="stage" type="number" value="1" min="1" max="50" value="<?php echo @$_POST['stage'];?>"> 
					</p>
				</div>
					<button id="staff-btn" type="submit" name="reg_btn" onClick="validate(this.form)" >Добавить</button>				
				</form>
		</div>
		<div id="overlay"></div>
	</body>
</html>
<?php 
	// if(isset($_POST['save'])){
		
	// 	if (isset($_POST['status'])) {
	// 		foreach($_POST['status'] as $key=>$value){ 
	// 			//mysql_query("UPDATE staff SET status='Y' WHERE id_employee='$value'");
	// 			$status=mysql_query("SELECT status FROM staff WHERE id_employee='$value'");
	// 			$st=mysql_fetch_array($status);
	// 			// do{
	// 			// 	//echo $st[0];
	// 			// 	if($st['status']=='N')
	// 			// 		mysql_query("UPDATE staff SET status='Y' WHERE id_employee='$value'");
	// 			// 	else
	// 			// 		mysql_query("UPDATE staff SET status='N' WHERE id_employee='$value'");
	// 			// }while($st=mysql_fetch_array($status));
	// 			if($st['status']=='Y')
	// 				mysql_query("UPDATE staff SET status='N' WHERE id_employee='$value'");
	// 			else
	// 				mysql_query("UPDATE staff SET status='Y' WHERE id_employee='$value'");
	// 		}
	// 	}
		

		// if(empty($_POST['status'])){
		// 		mysql_query("UPDATE staff SET status='Y' WHERE id_employee='$value'");
		// 		//echo $value.'<br>';
		// 	}
		
		// $is_checked = FALSE;

		// if (!empty($_POST['status'])) {
		// 	$is_checked = TRUE;
		// 	foreach($_POST['status'] as $key=>$value){ 
		// 		//mysql_query("UPDATE staff SET status='Y' WHERE id_employee='$value'");
		// 		mysql_query("UPDATE staff SET status='N' WHERE id_employee='$value'");
		// 		//echo $value.'<br>';
		// 	}
		// }
    	// $aDoor = $_POST['status'];
		// $N = count($aDoor);

		// echo("Вы выбрали $N здание(й): ");
		// // echo '<script type="text/javascript">alert("Вы выбрали $N здание(й)");</script>';
		// for($i=0; $i < $N; $i++)
		// {
		// // echo '<script type="text/javascript">alert($aDoor[$i] . " ");</script>'; 
		// 	echo($aDoor[$i] . " ");
		// 	mysql_query("UPDATE state_room SET settlement='".$data['date_issue']."' WHERE id_status=".$new['id_status']."");
		// }
	// }
	if(isset($_POST['reg_btn'])){
		$errors = array();
		$adress = $_POST['street'].$_POST['adress'];
		// echo $adress;
		$age = floor((strtotime(date('Y-m-d'))-strtotime($_POST['birth']))/(3600*24*365));
		// echo 'age = '.$age;
		if( trim($_POST['full_name'])=='' ){
			$errors[]='Введите полное имя:';
		}
		if( trim($_POST['adress']=='' )){
			$errors[]='Введите адресс:';
		}
		if( trim($_POST['birth'])=='' ){
			$errors[]='Введите дату рождения:';
		}
		if( trim($_POST['pasport'])=='' ){
			$errors[]='Введите паспорт:';
		}
		if( trim($_POST['admission'])=='' ){
			$errors[]='Вы забыли указать дату приема:';
		}
		if( trim($_POST['posit'])=='' ){
			$errors[]='Выберете должность:';
		}

		if( empty($errors)){	//заповнюємо таблицю
			$posit=mysql_fetch_array(mysql_query("SELECT id_position FROM positions WHERE name_position='".$_POST['posit']."'"));
			// echo $posit;
			// $pos=mysql_fetch_array($posit);
			// var_dump($pos); 
			// $pos=mysql_fetch_array($posit);
			$pos = $posit['id_position'];
			// do{
			// 	echo $pos['id_position'];
			// }while($pos=mysql_fetch_array($posit));
			mysql_query("INSERT INTO staff (full_name_employee,sex,phone,pasport,adress,birth,age,date_admission,id_position,experience,status) VALUES 
			('".$_POST['full_name']."','".$_POST['gender']."','".$_POST['num_phone']."','".$_POST['pasport']."','".$adress."','".$_POST['birth']."','".$age."','".$_POST['admission']."','$pos','".$_POST['stage']."','Y')");


			echo '<script type="text/javascript">alert("Сотрудник добавлен!");</script>';
		}
		else{
			echo '<script type="text/javascript">alert("'.array_shift($errors).'");</script>';
		}	
	}
?>