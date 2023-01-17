<html>

        
        <head><title>Plant Repair Services - Edit Line Item</title></head>
        <!--Uses css sheet -->
        <body>
                <link rel="stylesheet" href="SalesAssociateStyle.css">
                <!--Logins into database -->
                <?php $username = ''; $password = '';
                        try {
                        $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(PDOexception $e) { // handle that exception echo
                        "Connection to database failed: " . $e->getMessage();
                        }

                        session_start();
                        error_reporting(E_ERROR | E_PARSE);
                        $qid = $_SESSION["QuotesId"];
                ?>

                <header>
                        <!--Navigation bar to logout or go back -->
                        <h1>Edit Line Item</h1>

                                <nav>
                                        <ul>
                                                <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateViewLineItems.php">Back</a></li>
                                                <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateSignIn.php">Logout</a></li>
                                        </ul>
                                </nav>
                </header>

                <p> Enter updated price and description of line item. </p>
                
                <!-- Sales associate enters updated information into form -->
                <form action = "SalesAssociateUpdateLineItem.php" method = "POST">
                        Description: <input type ="text" name ="Description"/><br><br>
                        Price: <input type ="integer" name ="Price"/><br><br>

                        <input type = "submit" name = "submit" value = "Submit" />
                </form>

                <!--Changes the description or price of line item -->
                <?php
                if(isset($_POST['submit']))
                {
                        $pdo -> exec("UPDATE LineItem Set Description = '".$_POST['Description']."' WHERE QuoteId = $qid");
                        $pdo -> exec("UPDATE LineItem Set Price ='".$_POST['Price']."' WHERE QuoteId = $qid");
                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateViewLineItems.php");

                }


                ?>
        </body>
</html>
