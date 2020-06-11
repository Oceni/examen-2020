<?php

include_once("dbco.php");

$select = "DELETE from kart where Kartid='".$_GET['verwijder-id']."'";
$query = mysqli_query($mysqli, $select) or die($select);
header("location: karts.php");

?>