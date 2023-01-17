<html><head><title>Admin Page</title>
<style>
</style>

</head><body><h1>Admin Page</h1>
<?php
    error_reporting(E_ALL); //reorts errors for ideal effor checking

    include("library.php"); //includes my user data and the function that displays the tables

    try {
        //logs into my sql database
        $dsn = "mysql:host=;dbname=";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        //query of the entire customers table
        $sql = "SELECT * FROM customers LIMIT 5;";
        $result = $pdo->query($sql);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Customers</h2>";
        display_table($rows);


    }
    catch(PDOexception $e) { //checks for connection problems
        echo "Connection to database failed: " . $e->getMessage();
    }
?>
</body></html>
