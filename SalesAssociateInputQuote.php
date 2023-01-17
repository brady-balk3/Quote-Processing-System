<html>

        
        <head><title>Sales Associate Hub</title></head>

        <body>
                <!-- makes css sheet active on page  -->
                <link rel="stylesheet" href="SalesAssociateStyle.css">
                 <!--Signing into database -->
                <?php $username = ''; $password = '';
                        try {
                        $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(PDOexception $e) {
                        "Connection to database failed: " . $e->getMessage();
                        }

                        session_start();
                        error_reporting(E_ERROR | E_PARSE);

                        $nameVar = $pdo -> query("SELECT Name FROM SalesAssociate WHERE Password = '".$_SESSION['SalesPassword']."'");
                        $nameVar -> execute();
                        $nameVar = $nameVar -> fetchColumn();
                ?>
                <header>

                        <h1>Plant Repair Services Portal <?php echo $nameVar?></h1>
                        <!--Links to go back or to other pages in navigation bar -->
                        <nav>
                                <ul>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateAddQuote.php">Add Quote</a></li>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateAddCustomer.php">Add Customer</a></li>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/Sanction.php">Sanction Quotes</a></li>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/Process.php">Process Quotes</a></li>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateSignIn.php">Logout</a></li>
                                </ul>
                        </nav>
                </header>

<br>
<p><u>Current Active Quotes</u></p>
<br>

<!-- Table displays all quotes for only quotes made by the sales associate logged in -->

<?php

$assocID = $pdo -> query("SELECT AssociateID FROM SalesAssociate WHERE Name = '".$_SESSION['name']."'");
$assocID -> execute();
$assocID = $assocID -> fetchColumn();
$status = "Ordered";


$rs = $pdo -> query("SELECT Quotes.QuoteID, Customers.Email, Quotes.QuoteName, Quotes.Note, Quotes.Status, Quotes.DateTime, Quotes.Commission, Customers.Name FROM Customers, Quotes WHERE AssociateID = '$assocID' AND Quotes.CustId = Customers.CustId ORDER BY DateTime DESC;"); 

//Quotes are displayed on table and can be deleted or finalized by sales associate 


echo "<table border =2 cellspacing =2>"; 
echo "<tr><th>Quote Name </th><th> Note </th><th> Status </th><th>Date Stamp </th><th> Customer of Quote's  Name </th><th>Finalize</th><th>Delete</th><th>Add Line Item</th>\n</tr>"; 
echo "<form action = 'SalesAssociateInputQuote.php' method = 'POST'>";

//Loop to get each row of table put in neatly
        while($row = $rs-> fetch(PDO::FETCH_ASSOC))
        {
                $id = $row['QuoteID'];
                $fid = $id . 'f';
                $vid = $id . 'v';
                //$row = $rs->fetch(PDO::FETCH_ASSOC);
                echo "<tr><td>" . $row["QuoteName"]. "</td><td>" . $row["Note"] . "</td><td>" . $row["Status"] . "</td><td>" . $row["DateTime"] . "</td><td>" . $row["Name"] . "</td><td><input type = 'submit' name = $fid value = 'Finalize'</td><td><input type = 'submit' name = $id value = 'Delete'</td><td><input type = 'submit' name = $vid value = 'View Line Items'</td>\n</tr>";

                if(isset($_POST[$id]))
                {
                        $pdo -> exec("DELETE FROM Quotes WHERE QuoteId =  $id");
                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php");
                }
                if(isset($_POST[$fid]))
                {
                        $pdo -> exec("UPDATE Quotes SET Status = 'Finalized' WHERE QuoteId = $id");
                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php");
                }
                if(isset($_POST[$vid]))
                {
                        session_start();
                        $_SESSION['QuotesId'] = $id;
                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateViewLineItems.php");
                }


        }

        echo "</table>";

//Table displays the customer database
        echo"<p>List of Current Customers</p>";
        echo"<br>";

        $rs = $pdo -> query("SELECT Customers.Name, Customers.City, Customers.Street, Customers.Email
FROM Customers;"); 

echo "<table border =2 cellspacing =2>"; 

echo "<tr><th>Customer Name </th><th> City </th><th> Street </th><th>Contact </th><th> \n</tr>"; 

echo "<form action = 'SalesAssociateInputQuote.php' method = 'POST'>";





        while($row = $rs-> fetch(PDO::FETCH_ASSOC))

        {

                $id = $row['QuoteID'];

                $fid = $id . 'f';

                $vid = $id . 'v';


                echo "<tr><td>" . $row["Name"]. "</td><td>" . $row["City"] . "</td><td>" . $row["Street"] . "</td><td>" . $row["Email"] . "</td>\n</tr>";



        }



?>
</body>
</html>
