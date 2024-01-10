<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information List</title>
</head>
<body>
<?php

function error(){
    header("Location: Modul 7.html?message=Invalid Input");
}

//checks if the input is in special charancters
function validation($input){
    $regex=preg_match("[@_!#$%^&*()<>?/|{}~:;]",$input);
    if($regex)
    {error();}
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = ($_POST["name"]);
    $email = ($_POST["email"]);
    $age = ($_POST["age"]);

    validation($name);
    validation($age);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        echo"Invalid email format";
    }
//This condition check if the email address is correct or valid. If not, the output would be
//an error message which is the Invalid email format
  
    echo "<h2>User Information:</h2>";
    echo "<p>Name: $name</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Age: $age</p>";

  
    $csvData = "$name, $email, $age\n";
    //file put contents allows you to write contents to the file, File append allows you to add contents if the filename existed
    //Lock ex to prevent anyone from editing in the file
    file_put_contents("info.csv", $csvData, FILE_APPEND|LOCK_EX); 
} else {
    header("Location: Modul 7.html");
    exit();
}
?>

<h2>User Information List:</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Age</th>
    </tr>
    <?php
    $file = fopen("info.csv", "r"); //allows you to open the file
    while (($data = fgetcsv($file)) !== false) { //fgetcsv reads a line from the file and parse it as CSV
        echo "<tr>";
        foreach ($data as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    fclose($file); // allows you to close the file
    ?>
</table>
</body>
</html>
  



