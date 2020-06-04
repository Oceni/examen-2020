<?php

include 'header2.php';
include 'dbco.php';



/*
// Check connection
if (!$mysqli) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT Personeelid, Voornaam, Achternaam FROM personeel";
$result = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "id: " . $row["Personeelid"]. " - Name: " . $row["Voornaam"]. " " . $row["Achternaam"]. "<br>";
  }
} else {
  echo "0 results";
}

mysqli_close($mysqli);
*/




if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // gebruik concat mysql function
    $query = "SELECT * FROM `klantcursist` WHERE CONCAT(`klantCursistid`, `Voornaam`, `Achternaam`, `Email`,'Woonplaats','Adres','Geboortedatum') LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `klantcursist`";
    $search_result = filterTable($query);
}

// functie voor connectie en query uitvoeren
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "karten");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP HTML TABLE DATA SEARCH</title>
        <style>
            table,tr,th,td
            {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        
        <form action="cursisten.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
            <input type="submit" name="search" value="Filter"><br><br>
            
            <table>
                <tr>
                    <th>Klantcursusid</th>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>Email</th>
					<th>Woonplaats</th>
					<th>Adres</th>
					<th>Geboortedatum</th>
					<th>verwijderen</th>
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php //echo $row['klantCursistid'];?></td>
                    <td><?php echo $row['Voornaam'];?></td>
                    <td><?php echo $row['Achternaam'];?></td>
                    <td><?php echo $row['Email'];?></td>
					<td><?php echo $row['Woonplaats'];?></td>
					<td><?php echo $row['Adres'];?></td>
					<td><?php echo $row['Geboortedatum'];?></td>
					<td><a href="?verwijder-id=<?php echo $row['klantCursistid'];?>">Verwijderen</a></td>
					
					
					
				<a href="process.php?verwijderen=<?php echo $row['klantCursistid']; ?>"
				class="btn btn-danger">Verwijderen</a>
				
                </tr>
                <?php endwhile;?>
            </table>
        </form>
        
    </body>
</html>

<?php

if($_GET['verwijder-id']){
	$id = $_GET['verwijder-id'];	
	
			
	$query2 = "DELETE FROM klantcursist WHERE klantCursistid = '$id'";
		
	$data2 = mysqli_query($mysqli, $query2);

	if($data2) echo "Data is verwijderd";
		
	else echo "verwijderen gefaald";
}
	


?>



<?php

include 'footer.php';

?>