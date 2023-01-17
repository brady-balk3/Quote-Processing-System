<html>
        
        <head><title>Sales Associate - Add Line Item</title></head>

        <body>
                <!--Uses css file -->
                <link rel="stylesheet" href="SalesAssociateStyle.css">
                <!--Logins to database-->
                <?php $username = ''; $password = '';
                        try {
                                $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(PDOexception $e) { // handle that exception echo
                        "Connection to database failed: " . $e->getMessage();
                        }
                        session_start();
                        $qid = $_SESSION["QuotesId"];
                        error_reporting(E_ERROR | E_PARSE);
                        ?>
                <header>
                        <h1>Sales Associate - Add Line Items</h1>

                                <!--Navigation bar to go back, logout, and other options -->
                                <nav>
                                        <ul>
                                                <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php">Back</a></li>
                                                <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateAddQuote.php">Add Quote</a></li>
                                                <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateAddCustomer.php">Add Customer</a></li>
                                                <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateSignIn.php">Logout</a></li>
                                        </ul>
                                </nav>
                </header>

                
                <!--Employee enters info about line item to be added into table -->
                <form action = "SalesAssociateAddLineItem.php" method = "POST">
                        Description: <input type ="text" name ="Description"/><br><br>
                        Price: <input type ="integer" name ="Price"/><br><br>

                        <input type = "submit" name = "submit" value = "Submit" />
                </form>

                <!--Info is added into LineItem table -->
                <?php
                        if(isset($_POST['submit']))
                        {
                                $pdo -> exec("INSERT into LineItem(QuoteID, Description, Price)VALUES($qid, '".$_POST['Description']."','".$_POST['Price']."')");
                                header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateViewLineItems.php");

                        }


                ?>
        </body>
</html>
