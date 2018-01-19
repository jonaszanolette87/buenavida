<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>

<body>
<table border="1">
  <tbody>
<?php 

for ($m=1;$m<15;$m++) {

	echo "<tr>";


for ($l=1;$l<31;$l++){

echo "<td>". date("d")+$l ."/".date("m")."  </td>";	
	$total_dias = cal_days_in_month(CAL_GREGORIAN, 08, 2015);

echo "O mês de Agosto de 2015 terá ".$total_dias;
	
	
	}
	
echo "</tr>";	
}
?>
 <tbody>
</table>
</body>
</html>
