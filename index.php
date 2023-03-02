<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$con = mysqli_connect("localhost","root","","moja_baza");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} else {
  echo "CONNECTION OK";
}
// DELETE
if(isset($_POST['del'])){
echo "<h1>USUWANIE" . $_POST['del'] . "</h1>";
$delsql = "DELETE FROM moja_tabela WHERE Id=". $_POST['del'];
            
if(mysqli_query($con,$delsql)){
    echo "RECORD DELETED";
} else {
    echo "DELETE ERROR";
};
}
//UPDATE
if(isset($_POST['update'])){
    if(!empty($_POST['Imię']) && !empty($_POST['Nazwisko']) && !empty($_POST['Wiek'])){
        echo 'POPRAWIANIE' . $_POST['Imię'] . $_POST['Nazwisko'] . $_POST['Wiek'];
        
        $updsql = "UPDATE moja_tabela SET imie = '". $_POST['Imię']."', nazwisko = '". $_POST['Nazwisko']."', wiek = '". $_POST['Wiek']."' WHERE id = " .$_POST['Id'];
        if(mysqli_query($con,$updsql)){
            echo "RECORD UPDATED";
       } else {
            echo "ADD ERROR";
       };
    }
}


// CREATE
if(isset($_POST['add'])){
    if(!empty($_POST['Imię']) && !empty($_POST['Nazwisko']) && !empty($_POST['Wiek'])){
        echo 'DODAWANIE ' . $_POST['Imię'] . $_POST['Nazwisko'] . $_POST['Wiek'];
    
$addsql = "INSERT INTO moja_tabela (Id, Imię, Nazwisko, Wiek) VALUES (NULL,'" . $_POST['Imię'] ."','" . $_POST['Nazwisko'] . "','" . $_POST['Wiek'] ."')";
    
        if(mysqli_query($con,$addsql)){
            echo "RECORD ADDED";
        } else {
            echo "ADD ERROR";
        };
    } else {
        echo '<p style="color:red">Wypełnij wszystkie pola</p>';
    }
}

// READ
$sql = "SELECT * FROM moja_tabela";

$result = mysqli_query($con,$sql);

echo '<form method="post">';
echo '<table border="1">';
while($row = mysqli_fetch_assoc($result)){

        echo "<tr>";
    echo '<form method="post">';
    echo '<td>' . $row['Id'] . '"<input name ="id" type = "hidden" value="' . $row['Id'].'"></td>
        echo '<td><input name="imie" value="' . $row['Imię'] .'"</td>';
        echo '<td><input name="nazwisko" value="' . $row['Nazwisko'] .'"</td>';
        echo '<td><input type="number" value="' . $row['Wiek'] .'"</td>';
        echo '<td><button type="submit" name="del" value="'. $row['Id'] . '">x</button>';
        echo '<td><button type="submit" name="update" value="'. $row['Id'] . '">Zmień</button>'; 
        echo "</form>";
    echo "</tr>";
}
echo "</table>";
echo <<<EOL
<form method="post">
echo '<input type="submit" name="update" value="ZAPISZ ZMIANY">';
<div style="display:flex;flex-direction:column;;width300px">
<input name="Imię" placeholder="Imię">
<input name="Nazwisko" placeholder="Nazwisko">
<input name="Wiek" placeholder="Wiek" type="number">
<input name="add" type="submit" value="Dodaj">
</form>
EOL;
?>