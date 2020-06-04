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





if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // gebruik concat mysql function
	
	
    $query = "SELECT * FROM `cursus` WHERE CONCAT(`Cursusid`, `Cursusomschrijving`, `Begindatum`, `Einddatum`,`Prijs`) LIKE   '%".$valueToSearch."%' ORDER BY Cursusomschrijving" ;
    $search_result = filterTable($query);
    
	Var_dump($query);
}
 else {
    $query = "SELECT * FROM `cursus`";
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
        
        <form action="cursus.php" method="post">
            <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
            <input type="submit" name="search" value="Filter"><br><br>
            
            <table>
                <tr>
                    <th>Id</th>
                    <th>Cursusomschrijving</th>
                    <th>Begindatum</th>
                    <th>Einddatum</th>
					<th>Prijs</th>
                </tr>

      <!-- populate table from mysql database -->
                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php echo $row['Cursusid'];?></td>
                    <td><?php echo $row['Cursusomschrijving'];?></td>
                    <td><?php echo $row['Begindatum'];?></td>
                    <td><?php echo $row['Einddatum'];?></td>
					<td><?php echo $row['Prijs'];?></td>
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
<form action="cursus.php" method="">
Roll no <input type="Text" name="rollno" value=""/><br>
name <input type="Text" name="studentnaam" value=""/><br>
class <input type="Text" name="class" value=""/><br>
<input type = "submit" name="submit"  value="toevoegen"/>
<input type = "submit" name="submit"  value="wijzigen"/>
<input type = "submit" name="submit"  value="verwijderen"/>


</form>

</body>
</html>


<?php
//$query = "ÏNSERT INTO cursus Values('7','Oceni cavanel','WWW')";
//$data = mysqli_query($mysqli, $query);

//if($data)
{
	
	//echo "Data inserted into Database";
}

?>




<?php


session_start();
$mysqli = new mysqli('localhost','root','','karten') or die(mysqli_error($mysqli));

$id = 0;
$name = '';
$location = '';
$update = false;


// save button
if (isset($_POST['toevoegen'])){
$name = $_POST['name'];
$location = $_POST['location'];

$mysqli->query("INSERT INTO data (name, location) VALUES ('$name','$location')") or die($mysqli->error);

$_SESSION['message'] = "Record is toegevoegd";
$_SESSION['msg_type'] = "succes";

header("location: index.php");
}



//edit button
if (isset($_GET['wijzigen'])){
$id = $_GET['wijzigen'];
$update = true;
}
//$result = $mysqli->query("UPDATE data SET name='$name', location='$location' WHERE id=$id") or die($mysqli->error);

//$result = $result -> fetch_assoc();






// knop die veranderd na het klikken van wijzigen na het invullen updaten
if (isset($_POST['wijzigen'])){
	
$id = $_POST['id'];
$name = $_POST['name'];
$location = $_POST['location'];

$name2 ='bart';
echo $name2;

$result = $mysqli->query("UPDATE data SET name='$name', location='$location' WHERE id=$id") or die($mysqli->error);
	var_dump($result);
	
	$_SESSION['message'] = "Record has been updated";
	$_SESSION['msg_type'] = "warning";
	
	header('location: index.php');
}


//delete button
if (isset($_GET['verwijderen'])){
	$id = $_GET['verwijderen'];
	
	$mysqli->query("DELETE FROM data WHERE id=$id")or die($mysqli->error);
	
	$_SESSION['message'] = "Record is verwijderd";
	$_SESSION['msg_type'] = "danger";
	
	header("location: index.php");
}
?>

<?php

include 'footer.php';

?>