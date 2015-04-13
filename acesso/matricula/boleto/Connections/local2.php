<?php require_once('local.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_Recordset1 = 1000;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['curso'])) {
  $colname_Recordset1 = $_GET['curso'];
}
mysql_select_db($database_local, $local);
$query_Recordset1 = sprintf("SELECT *
FROM tb_tcc_proj ");
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $local) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../shadowbox.css">
<script type="text/javascript" src="../shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<link rel="stylesheet" type="text/css" href="../shadowbox.css">
<script type="text/javascript" src="../shadowbox.js"></script>
<script type="text/javascript">
Shadowbox.init({
    handleOversize: "drag",
    modal: true
});
</script>
<meta http-equiv=”Content-Type” content=”text/html; charset=iso-8859-1” />
<title>CEDTEC Virtual - Inovaçao Tecnológica</title>
<!-- <link href="styles.css" rel="stylesheet" type="text/css" media="screen" /> -->
<style type="text/css">
#content #back #main #left #valr tablex {
	font-weight: bold;
}
#content #back #main #left #valr table tr tdz {
	font-weight: bold;
}
#content #back #header #menu ul li #camada1 b font {
	color: #CCCCCC;
}
.c {
	font-family: "Lucida Console", Monaco, monospace;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
</head>
<body>
				<form action="consult_info.php" method="post" id="valr">
				<strong>Filtro Detalhado:</strong>  
<p>Curso:
  <select name="curso" id="curso" class="textBox" >
      <option value="*">Todos</option>
      <?php
mysql_connect('dbmy0062.whservidor.com', 'cedtecvirt_2', 'Marcelo2');
mysql_select_db('cedtecvirt_2');?>
      <?php
$sql = "SELECT distinct curso FROM tb_tcc_proj";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['curso'] . "'>" . $row['curso'] . "</option>";
}
?>
    </select>
    Polo:
    <select name="polo" id="polo" class="textBox" >
      <option value="*">Todos</option>
    <?php
			
mysql_connect('dbmy0062.whservidor.com', 'cedtecvirt_2', 'Marcelo2');
mysql_select_db('cedtecvirt_2');?>
    <?php
$sql = "SELECT distinct polo FROM tb_tcc_proj";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['polo'] . "'>" . $row['polo'] . "</option>";
}
?>
  </select>
  Ano 
  <select name="ano" id="ano" class="textBox" >
    <option value="*">Todos</option>
    <?php
			
mysql_connect('dbmy0062.whservidor.com', 'cedtecvirt_2', 'Marcelo2');
mysql_select_db('cedtecvirt_2');?>
    <?php
$sql = "SELECT distinct ano FROM tb_tcc_proj";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ano'] . "'>" . $row['ano'] . "</option>";
}
?>
  </select>
<input type="submit" name="busca" id="busca" value="Buscar" />
  </p>
  <p class="c">&nbsp;</p></p>
		</ul>
	</div>
	<div id="left">
		
<form action="../consult.php" method="post" id="valr">
  <div align="center">
  <table width="100%" border="0" cellspacing="1">
    <tr>
      <td width="15" align="center" style="border-style: ridge; border-width: 1px"><b>C&oacute;digo</b></td>
      <td width="130" align="center" style="border-style: ridge; border-width: 1px"><b>Curso</b></td>
      <td width="20" align="center" style="border-style: ridge; border-width: 1px"><b>Polo</b></td>
      <td width="20" align="center" style="border-style: ridge; border-width: 1px"><b>Ano</b></td>
      <td width="144" align="center" style="border-style: ridge; border-width: 1px"><b>Descri&ccedil;&atilde;o</b></td>
      <td width="68" align="center" style="border-style: ridge; border-width: 1px"><b>Projeto</b></td>
      </tr>
    <?php do { ?>
    <tr>
      <td style="border-style: ridge; border-width: 1px; text-align: center;"><div align="center"><?php echo $row_Recordset1['codigo']; ?></div></td>
      <td style="border-style: ridge; border-width: 1px"><div align="center"><?php echo strtoupper($row_Recordset1['curso']); ?></div></td>
      <td style="border-style: ridge; border-width: 1px"><div align="center"><?php echo strtoupper($row_Recordset1['polo']); ?></div></td>
      <td style="border-style: ridge; border-width: 1px"><div align="center"><?php echo $row_Recordset1['ano']; ?></div></td>
      <td style="border-style: ridge; border-width: 1px; text-align: center;"><div align="center"><?php echo strtoupper($row_Recordset1['descricao']); ?></div></td>
    
    <td style="border-style: ridge; border-width: 1px"><div align="center"><a rel="shadowbox[Mixed];width=900;height=650"  href="<?php echo $row_Recordset1['../link']; ?>">  Projeto </a></div> 
      </td>
      </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
  </div>
  <p style="text-align: center">&nbsp;</p>
	<p style="text-align: center">&nbsp;</p>
	<p style="text-align: center">&nbsp;</p>
	<p style="text-align: center">&nbsp;</p>
</form></body>