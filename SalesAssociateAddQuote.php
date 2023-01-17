<html>

        
        <head><title>Sales Associate - Add Quotes</title></head>

        <!-- Refers to css sheet -->
        <body>
                <link rel="stylesheet" href="SalesAssociateStyle.css">
                <?php $username = ''; $password = '';
                //Logins into database -->
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
                <h1>Plant Repair Services Portal - Add Quote</h1>
                        <!--Navigation to go back or log out -->
                        <nav>
                                <ul>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php">Go Back</a></li>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/salesAssociateInterface.php">Logout</a></li>
                                </ul>
                        </nav>
        </header>

        <br>
        <p>Fill in information about the new quote below.</p>
        <br>
        <!-- Form for sales associate to add quotes using the customer contact -->
        <form action = "SalesAssociateAddQuote.php" method = "POST">
                Customer Contact: <input type = "text" name ="Email"/><br><br>
                Quote Name:       <input type = "text" name ="QuoteName"/><br><br>
                Quote Note:       <input type = "text" name ="Note"/><br><br>
                <input type = "submit" name = "submit" value = "Submit" />
        </form>

                <!--Sends information put in to the table to be updated -->
        <?php
                $custID = $pdo -> query("SELECT CustId FROM Customers WHERE Email = '".$_POST['Email']."'");
                $custID -> execute();
                $custID = $custID -> fetchColumn();
                $assocID = $pdo -> query("SELECT AssociateID FROM SalesAssociate WHERE name = '".$_SESSION['name']."'");
                $assocID -> execute();
                $assocID = $assocID -> fetchColumn();
                $viewQ = $pdo -> query("SELECT * from Quotes where AssociateID = $assocID AND Status = 'Ordered'");
                $viewQ -> execute();
                $viewQ = $viewQ -> fetchAll(PDO::FETCH_ASSOC);

                $status = "Ordered";

                if(isset($_POST['Email']))
                {
                        $pdo->exec("INSERT INTO Quotes(CustId, AssociateID, QuoteName, Note,Status)VALUES('$custID', '$assocID', '".$_POST['QuoteName']."','".$_POST['Note']."','$status')");
                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php");

                }

?>

        </body>
</html>
</html>
