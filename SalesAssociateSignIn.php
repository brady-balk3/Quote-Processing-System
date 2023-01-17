<html>

        
        <head><title>Sales Associate - Sign In</title></head>
        <body>
                <!--Uses css sheet -->
                <link rel="stylesheet" href="SalesAssociateStyle.css">
                <!--Logs into database-->
                <?php $username = ''; $password = '';
                try { //exception
                        $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(PDOexception $e) { // handle that exception echo
                        "Connection to database failed: " . $e->getMessage();
                }
                error_reporting(E_ERROR | E_PARSE);
                session_start();
                ?>
                <header>
                        <h1>Plant Repair Services Portal</h1>

                </header>

                <br>
                <br>

                <p><b>Please Sign In</b></p>
                
                <!--Sales associate enters login information into a form -->
                <form action = "SalesAssociateSignIn.php" method = "POST">

                Name: <input type ="text" name ="Name"/><br><br>
                Password: <input type ="password" name ="Password"/><br><br>

                <input type = "submit" name = "submit" value = "Submit" />
                </form>

                //If the name and password match in the database, they are sent to their own session of the interface
                <?php
                        $_SESSION["name"] = $_POST['Name'];
                        $password = $pdo -> query("SELECT Password FROM SalesAssociate WHERE Name = '".$_POST['Name']."'");
                        $password -> execute();
                        $password = $password -> fetchColumn();
                        if(strcmp($password, $_POST['Password']) == 0 && $password != null)
                        {
                                header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php");
                        }
    
                ?>
        </body>
</html>
