<?php

include 'header2.php';
include 'dbco.php';




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


//net gedaan $query = "SELECT * from karten inner join cursus on karten.Kartid = cursus.Cursusid ";


if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // gebruik concat mysql function
	// merk type cursusomschrijving en status columm hebben
	
	//$sql = $conn->query("SELECT * FROM karten k 
                     //LEFT JOIN users u 
                     //ON t.allowed_countries LIKE concat('%',u.country,'%')
                    // WHERE u.username = '$username'");
					 
					 
					 
	
	
   //$query = "SELECT * from karten inner join cursus on karten.Kartid = cursus.Cursusid  LIKE %.$valueToSearch.%";
	
  // $query = "SELECT merk, type, Cursusomschrijving, status FROM `karten`, `cursus`, `kartcursus` 
   //WHERE karten.Kartid = kartcursus.Kartid AND cursus.Cursusid = kartcursus.Cursusid
   //LIKE   '%".$valueToSearch."%'" ;
   
   // echte code werkt SELECT merk, type, Cursusomschrijving, status FROM `karten` 
   //INNER JOIN `kartcursus` 
   //ON karten.Kartid = kartcursus.Kartid
   //INNER JOIN cursus
   //ON cursus.Cursusid = kartcursus.Cursusid
   
   
   
   $query = "SELECT * from Kartcursus LEFT JOIN cursus ON Kartcursus.cursusid = cursus.cursusid 
   JOIN kart ON Kartcursus.kartid = kart.kartid;
   LIKE   '%".$valueToSearch."%'" ;
   
   
   
	
    $search_result = filterTable($query);
    
	
}
 else {
    //$query = "SELECT * from `karten`";
   $query = "SELECT * from Kartcursus RIGHT JOIN cursus ON Kartcursus.cursusid = cursus.cursusid 
    RIGHT JOIN kart ON Kartcursus.kartid = kart.kartid;";
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
        
        <form action="karts.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
            <input type="submit" name="search" value="Filter"><br><br>
            
            <table>
                <tr>
                    <th>Kartid</th>
                    <th>Merk</th>
                    <th>Type</th>
					<th>Cursusomschrijving</th>
					<th>Status</th>
					<th>verwijderen</th>
					<th>verwijderen metlink</th>
					
					
					
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    
					<td><?php echo $row['Kartid'];?></td>
                    <td><?php echo $row['merk'];?></td>
                    <td><?php echo $row['type'];?></td>
					<td><?php echo $row['Cursusomschrijving'];?></td>
					<td><?php echo $row['status'];?></td>
					<td><a href="?verwijder-id=<?php echo $row['Kartid'];?>">Verwijderen</a></td>
					
				
					<!-- Delete button-->
					
					
					<td><a href="karts.php?verwijder-id=<?php echo $row['Kartid']; ?>" onClick='return deleteme()'>Delete</a></td>

					
				
                </tr>
				
					
				
                <?php endwhile;?>
            </table>
        </form>
        
    </body>
</html>



<!DOCTYPE html>
<html>
    <head>
        <title>Toevoegen</title>
        <style>
           
        </style>
    </head>
    <body>
<form action="" method="GET">
id <input type="Text" name="id" value=""/><br>
Merk <input type="Text" name="merk" value=""/><br>
Type <input type="Text" name="type" value=""/><br>
Cursusomschrijving <input type="cursus" name="cursus" value=""/>
<label for="cars">Kies een cursus</label>
<select name="cars" id="cars">
<?php
    $querycursus = "SELECT * FROM cursus;";
	$cursus = mysqli_query($mysqli, $querycursus);
		
	while($row = mysqli_fetch_array($search_result)) {
		echo '<option value="volvo">'.$row["Cursusomschrijving"].'</option>';
	}
?>
</select>


<br>
Status <input type="Text" name="status" value=""/><br>
<input type = "submit" name="submit"  value="toevoegen"/>
<input type = "submit" name="wijzigen"  value="wijzigen"/>
<input type = "submit" name="verwijderen"  value="Verwijderen"/>


</form>

</body>
</html>

<?php

include 'dbco.php';
error_reporting(0);


if($_GET['wijzigen']){
	
	$id = $_GET['id'];	
	$merk = $_GET['merk'];
	$type = $_GET['type'];
	$cursus = $_GET['cursus'];
	$status = $_GET['status'];

	if($id!="" && $merk!="" && $type!="" && $cursus!=""&& $status!=""){
		$query1 = "UPDATE kart SET Kartid = '$id',merk = '$merk',type = '$type',status='$status'
		WHERE Kartid = '$id' ";
			
		$data1 = mysqli_query($mysqli, $query1);

		 if($data1)	echo "Data is gewijzig";	
		else echo "wijzigen gefaald";
	}
	else echo "All fields are required";
}
	
if($_GET['verwijder-id']){
	$id = $_GET['verwijder-id'];	
	$merk = $_GET['merk'];
	$type = $_GET['type'];
	$cursus = $_GET['cursus'];
	$status = $_GET['status'];
			
	$query2 = "DELETE FROM kart WHERE Kartid = '$id'";
		
	$data2 = mysqli_query($mysqli, $query2);

	if($data2) echo "Data is verwijderd";
		
	else echo "insert failed";
}
	
if($_GET['submit'])
{
	$id = $_GET['id'];	
	$merk = $_GET['merk'];
	$type = $_GET['type'];
	$cursus = $_GET['cursus'];
	$status = $_GET['status'];

	if($id!="" && $merk!="" && $type!="" && $cursus!=""&& $status!=""){		
		$query = "INSERT INTO kart (Kartid,merk,type,status) VALUES('$id','$merk','$type','$status')";
		
		$data = mysqli_query($mysqli, $query);

		if($data) echo "Data inserted into Database";
		else echo "insert failed";
	}
	else echo "All fields are required";
}

include 'footer.php';
?>