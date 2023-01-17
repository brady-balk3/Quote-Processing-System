<html>
<!--  Page to add customers from database into the system -->
        <head><title>Sales Associate Add Customer</title></head>

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
                        error_reporting(E_ERROR | E_PARSE);
                ?>
                <header>
                        <h1>Add A New Customer</h1>

                        <!--Links to go back or to other pages in navigation bar -->
                        <nav>
                                <ul>
                                        <li><a href="http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php">Back</a></li>
                                </ul>
                        </nav>
                </header>

<!--Form for customer to insert info into Customers table -->
<p>Insert information on customer  below.</p>
<br>
                <form action = "SalesAssociateAddCustomer.php" method = "POST">
                        Customer Contact: <input type = "text" name ="CEmail"/><br><br>
                        Customer Name <input type = "text" name ="Name"/><br><br>
                        City: <input type = "text" name="City"/><br><br>
                        Street:<input type = "text" name="Street"/><br><br>
                        <input type = "submit" name "submit" value = "Submit" />
                </form>

<!--Info from the form gets put into the database -->
                <?php
                        if(isset($_POST['CEmail']))
                        {
                         $pdo->exec("INSERT INTO Customers(Name, Email, City, Street)VALUES('".$_POST['Name']."','".$_POST['CEmail']."','".$_POST['City']."','".$_POST['Street']."')");

                        header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/SalesAssociateInputQuote.php");
                        }
?>
        </body>
</html>
