<?php
	require "connection.php";
	?>
  <!doctype html>
<html>
<body>
<style>
    table.bottomBorder { 
    border-collapse: collapse; 
  }
  table.bottomBorder td, 
  table.bottomBorder th { 
    border-bottom: 1px solid black; 
    padding: 10px; 
    text-align: left;
  }
</style>
<h3><center>  Фискальный чек </center> </h3>
<?php
$today=date('d.m.Y H:m:s');
$client=mysql_fetch_array(mysql_query("SELECT max(id) FROM  clients"));
$zaezd=mysql_fetch_array(mysql_query("SELECT orders.date_issue FROM orders INNER JOIN clients 
	ON orders.id_client = clients.id WHERE orders.id_client =".$client[0].""));
$otezd=mysql_fetch_array(mysql_query("SELECT orders.issued_by FROM orders INNER JOIN clients 
	ON orders.id_client = clients.id WHERE orders.id_client =".$client[0].""));
$kol= floor((strtotime($otezd[0])-strtotime($zaezd[0]))/(3600*24));
	// echo 	'<div style="color: black; font-size: 200%;">$kol'.$kol.'</div>';

$ord=mysql_fetch_array(mysql_query("SELECT MAX(id_order) FROM orders"));
$orders=mysql_query("SELECT * FROM  orders WHERE id_order=".$ord[0]."");
$order=mysql_fetch_array($orders);

$staff=mysql_fetch_array(mysql_query("SELECT staff.full_name_employee FROM staff WHERE staff.id_position = 3"));
// echo "Sotrudnik",$staff[0];

$services=mysql_query("SELECT selected_services.service,services.service_cost
FROM orders INNER JOIN clients ON orders.id_client = clients.id INNER JOIN selected_services
    ON selected_services.id_client = clients.id INNER JOIN services ON selected_services.service = services.service_type
WHERE selected_services.service = services.service_type AND selected_services.id_client = clients.id AND orders.id_client = clients.id
AND clients.id =".$order['id_client']."");

$cost_servis=mysql_fetch_array(mysql_query("SELECT orders.cost_services FROM orders WHERE orders.id_client =".$client[0].""));
$cost_all=mysql_fetch_array(mysql_query("SELECT orders.all_cost FROM orders WHERE orders.id_client =".$client[0].""));
$name_category=mysql_fetch_array(mysql_query("SELECT categories.name_category FROM orders INNER JOIN state_room
    ON orders.id_status = state_room.id_status INNER JOIN rooms ON state_room.id_room = rooms.id_room
  INNER JOIN categories ON rooms.id_category = categories.id_category WHERE rooms.id_category = categories.id_category
AND state_room.id_room = rooms.id_room AND orders.id_status = state_room.id_status
AND orders.id_client =".$client[0].""));
$cost_room=$cost_all[0]-$cost_servis[0];

echo '<table width=30% align=center>';
echo "<tr><td><p align=left ><font size=+1>Заказ #</font> ".$order['id_order']."</p></td></tr>";
echo "<tr><td><p align=left >Дата: $today;</td></tr>";
echo "<tr><td><p align=left >Категория: ".$name_category[0]."   <br> Комната №".$order['id_status']."</td></tr>";
echo "<tr><td><p align=left >Гости: <br> Взрослые: ".$order['grown']."<br> Дети:".$order['child']."</td></tr>";
echo "<tr><td><p align=left >Кассир: ".$staff[0]."</td></tr>";
echo "<tr><td><p align=left >Дата заезда: ".$zaezd[0]."</td></tr>";
echo "<tr><td><p align=left >Дата отъезда: ".$otezd[0]."</td></tr>";
echo '</table>';
echo '<table class="bottomBorder" width=30% align=center>';
echo '<tr><td>Услуга</td><td>Количество</td><td>Цена в ₴</td>';
echo '<tr><td>'.$name_category[0].'</td><td>1</td><td>'.$cost_room.'</td>';
$service=mysql_fetch_array($services);
do {		
		echo '<tr><td width=20%>'.$service['service'].'</td>';        
		echo '<td width=20%>'.$kol.'</td>';
		echo '<td width=20%>'.$service['service_cost']*$kol.'</td>';
		$count ++;
}while($service=mysql_fetch_array($services));
$sum_count=$kol*$count+1;//сумма всех услуг
echo '<tr><td width=20%>Сумма<td width=20%>'.$sum_count.'<td width=20%></td></td></td>';
echo '<tr><td width=20% align=center >К оплате: <td width=20% align=center ><td width=20% align=center >'.$cost_all[0].' грн </td></td></td>';
echo '</tr></table>';
echo '<table width=30% align=center>';
echo '<tr><td> <font style="font-family:Monotype Corsiva; font-size:20pt;"><p align="right">Radisson </p></font></td></tr>';
echo '</table>';

?>
<p class="forgot-password"><span style="padding-left: 35%;"><a href="index.php">Вернуться на главную</a></p>
</body>
</html>