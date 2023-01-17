<html>

  <link rel="stylesheet" href="SalesAssociateStyle.css">


  <?php

  //file adds a discount to the quote and sets the status of the quote to processed(didn't implement the part to send the order to the external system)

 $username = ''; $password = '';
                        try {
                        $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(PDOexception $e) {
                        "Connection to database failed: " . $e->getMessage();
                        }
    $username2 = '';
    $password2 = '';


  session_start();
  $qid = $_SESSION['QuotesId'];
  //prints customer name
  $Customername = $pdo -> query("SELECT Name FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid");
  $Customername -> execute();
  $Customername = $Customername -> fetchColumn();

  echo "<h1>Quote for: $Customername</h1>";
  //prints customer street
  $customeraddress = $pdo -> query("SELECT Street FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid");
  $customeraddress -> execute();
  $customeraddress = $customeraddress -> fetchColumn();

  echo "<h2>$customeraddress</h2>";
  //prints customer city
  $customeraddress = $pdo -> query("SELECT City FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid");
  $customeraddress -> execute();
  $customeraddress = $customeraddress -> fetchColumn();

  echo "<h2>$customeraddress</h2>";

  $customeremail = $pdo -> query("SELECT Email FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid");
  $customeremail -> execute();
  $customeremail = $customeremail -> fetchColumn();
  //prints customer contact
  echo "<p>Email: $customeremail</p>";

  echo "<p><u>Line Items</u></p>";

  $rs = $pdo -> query("SELECT LineID, Description, Price From LineItem Where QuoteID = $qid");
  echo "<table border =1 cellspacing =0>";
  echo "<tr><th> Description </th><th> Price </th>\n</tr>";

  while($row = $rs-> fetch(PDO::FETCH_ASSOC))
  {

    echo "<tr><td>" . $row["Description"] . "</td><td>" . $row["Price"]. "</td>\n</tr>";

  }

  echo "</table>";

  //prints notes
  echo "<p><u>Secret Notes</u></p>";

  $rs = $pdo -> query("SELECT Note From Quotes Where QuoteID = $qid");
  echo "<table border =1 cellspacing =0>";
  echo "<tr><th> Description </th>\n</tr>";

  while($row = $rs-> fetch(PDO::FETCH_ASSOC))
  {

    echo "<tr><td>" . $row["Note"] . "</td></tr>";

  }

  echo "</table>";

  $QuoteTotal = $pdo -> query("SELECT SUM(Price) AS value_sum FROM LineItem WHERE QuoteId = $qid");
  $QuoteTotal -> execute();
  $row = $QuoteTotal -> fetch(PDO::FETCH_ASSOC);
  $sum = $row['value_sum'];
  //radio buttons to calculate sum
  echo "<p><u>Discount</u></p><form type = 'submit' action='Order.php' method='POST'> <input type='text' name='discount'><input type='radio' id='1' name='amount' value='amount' checked>amount</input><input type='radio' id='2' name='amount' value='percent'>percentage</input>";
  echo "<input type='submit' name='submit' value='Calculate' /></p>";

  if(isset($_POST['discount']))
  {
    $discountnum = $_POST['discount'];
  }
  if(isset($_POST['amount']))
  {
    $type = $_POST['amount'];

    if($_POST['amount'] == 'amount')
    {
     $sum = $sum - $discountnum;
    }
    else if($_POST['amount'] == 'percent')
    {
      $originalprice = $sum;
      $sum = $sum - ($originalprice * ($discountnum/100));
    }
  }

  $format_sum = number_format($sum, 2);

  echo "<p> Total Quote Price: $". $format_sum . "</p>";


  echo "<br></br>";

  //buttons to submit the process. it changes the status to Processed when it should be sending to an external processing system which is an easy fix but i cant change the code
  echo "<form type='submit' action='Process.php' method='POST'> <input type = 'submit' name='back' value='Cancel'><input type = 'submit' name='Processed' value='Process PO'> </form>";
  if(isset($_POST['back']))
  {
    header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/Process.php");
  }
  if(isset($_POST['Processed']))
  {
    $pdo -> exec("UPDATE Quotes SET Status = 'Processed' WHERE QuoteId = $qid");
    header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/Process.php");
  }


 ?>








</html>
