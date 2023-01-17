<html>
        <head><title>Line Items</title></head>

        <body>
		<!--CSS sheet used -->
                <link rel="stylesheet" href="SalesAssociateStyle.css">
		
		<!--Logins to database -->
                <?php $username = ''; $password = '';
                        try {
                                $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(PDOexception $e) { // handle that exception echo
                                "Connection to database failed: " . $e->getMessage();
                        }
                        session_start();
                        error_reporting(E_ERROR | E_PARSE);
                        $qid = $_SESSION['QuotesId'];
                        $usernameVar = $pdo -> query("SELECT Name FROM SalesAssociate WHERE Password = '".$_SESSION['password']."'");
                        $usernameVar -> execute();
                        $usernameVar = $usernameVar -> fetchColumn();
                ?>
                <header>
                <h1>Plant Repair Services - Line Items</h1>
			<!-- Naviagtion bar to go back, logout, or go to add line item page-->
                        <nav>
                                <ul>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php">Back</a></li>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateAddLineItem.php">Add Line Item</a></li>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateSignIn.php">Logout </a></li>
                                </ul>
                        </nav>
                </header>

                <p>Below are the line items for the quote.</p>
                <br>

                <?php
			//Creates table of line items for the quote selected
                        SELECT *$assocID = $pdo -> query("SELECT AssociateID FROM SalesAssociate WHERE Name = '".$_SESSION['name']."'");
                        $assocID -> execute();
                        $assocID = $assocID -> fetchColumn();
                        $status = "Ordered"; 
                        $rs = $pdo -> query("SELECT LineID, Description, Price From LineItem Where QuoteID = $qid"); 
                        echo "<table border =1 cellspacing =1>"; 
                        echo "<tr><th> Description </th><th> Price </th><th>Edit</th><th>Delete</th>\n</tr>"; 
                        echo "<form action = 'SalesAssociateViewLineItems.php' method = 'POST'>";
			
                        while($row = $rs-> fetch(PDO::FETCH_ASSOC))
                        {
                                $id = $row['LineID'];
                                $fid = $id . 'f';
        
                                echo "<tr><td>" . $row["Description"] . "</td><td>" . $row["Price"]. "</td><td><input type = 'submit' name = $fid value = 'Edit'</td><td><input type = 'submit' name = $id value = 'Delete'</td>\n</tr>";
                                if(isset($_POST[$id]))
                                {
                                        $pdo -> exec("DELETE FROM LineItem Where LineID =  $id");
                                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateViewLineItems.php");
                                }
                                if(isset($_POST[$fid]))
                                {
                                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateUpdateLineItem.php");
                                }

                        }

                        echo "</table>";


			//Displays total price of all quotes in table
                        echo"<p>Total Price of Quote:  </p>";
                        $accuprice = $pdo -> query("SELECT SUM(Price) AS value_sum FROM LineItem Where QuoteID = $qid");
                        $accuprice -> execute();
                        $row = $accuprice->fetch(PDO::FETCH_ASSOC);
                        $sum = $row['value_sum'];
                        echo $row['value_sum'];




                ?>
        </body>
</html>
