<!DOCTYPE html>
<html>

<link rel="stylesheet" href="SalesAssociateStyle.css">

  <head><title>Plant Repair Services</title></head>
  <body>
   <header>
    <h1>Plant Repair Services: Headquarters</h1>
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
  <p><u>List of Sanctioned quotes:</u></p>
  <br>
<?php
  //prints out quotes that need to be processed and takes you to Order.php to process the quote into a purchase order

 $username = ''; $password = '';
 try {
 $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOexception $e) { // handle that exception echo
   "Connection to database failed: " . $e->getMessage();
 }
 $username2 = '';
    $password2 = '';
   try {
        //logs into my sql database
        $dsn = "mysql:host=;dbname=";
        $pdo2 = new PDO($dsn, $username2, $password2);
        $pdo2->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOexception $e){
      echo "Connection to database failed: " . $e->getMessage();
    }


 session_start();
 error_reporting(E_ERROR | E_PARSE);


 $rs = $pdo -> query("SELECT Quotes.QuoteID, Quotes.DateTime, SalesAssociate.Name, Customers.Name AS custname, SUM(Price) AS value_total, Quotes.Status FROM Quotes JOIN Customers ON Customers.CustId = Quotes.CustId JOIN LineItem ON LineItem.QuoteId = Quotes.QuoteId JOIN SalesAssociate ON SalesAssociate.AssociateId = Quotes.AssociateId WHERE (Quotes.Status = 'Sanctioned') GROUP BY Quotes.QuoteId ORDER BY DateTime DESC;");


 echo "<table border =2 cell spacing =2>";
 //if there is something in the select statement
 if($rs->rowCount() >0)
 {
   echo "<tr><th>Quote Id </th><th>Date</th><th>Sales Associate </th><th>Customer </th><th>Quote Total </th><th>Process Orders</th></tr>";
 }
 //prints quotes
 while($row = $rs-> fetch(PDO::FETCH_BOTH))
 {
   $id = $row['QuoteID'];

   echo "<tr><td>" . $row["QuoteID"]. "</td><td>" . $row["DateTime"]. "</td><td>" . $row['Name']. "</td><td>" . $row['custname'] . "</td><td>" . $row['value_total'] . "</td><td><form action = 'Process.php' method = 'POST'><input type='submit' name=$id value='Process Order'></form></td>\n</tr>";

  //if process order button is clicked
  if(isset($_POST[$id]))
  {
   echo $id;

    session_start();
    $_SESSION['QuotesId'] = $id;
    header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/Order.php");

  }

 }

if($rs->rowCount() <= 0)
  {
     echo "There currently are no quotes that need to be converted to a purchase order";
  }



 echo "</table>";
?>

</body>
</html>
