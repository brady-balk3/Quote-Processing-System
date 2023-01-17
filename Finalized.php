<html>

  <link rel="stylesheet" href="SalesAssociateStyle.css">


  <?php

	$username = ''; $password = ''; //connect to database
        try 
		{
            $dsn = "mysql:host=;dbname="; $pdo = new PDO($dsn, $username, $password); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOexception $e) //error catch
		{
            "Connection to database failed: " . $e->getMessage();
        }
    $username2 = ''; //get legacy database
    $password2 = '';


  session_start(); //start session
  $qid = $_SESSION['QuotesId']; //

  $Customername = $pdo -> query("SELECT Name FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid"); //get customer name
  $Customername -> execute();
  $Customername = $Customername -> fetchColumn();
  echo "<h1>Quote for: $Customername</h1>"; //display customer name

  $customeraddress = $pdo -> query("SELECT Street FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid"); //get address
  $customeraddress -> execute();
  $customeraddress = $customeraddress -> fetchColumn();
  echo "<h2>$customeraddress</h2>"; //display address

  $customeraddress = $pdo -> query("SELECT City FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid"); //get address
  $customeraddress -> execute();
  $customeraddress = $customeraddress -> fetchColumn();
  echo "<h2>$customeraddress</h2>"; //display address

  $customeremail = $pdo -> query("SELECT Email FROM Customers JOIN Quotes ON Customers.CustId = Quotes.CustId WHERE Quotes.QuoteId = $qid"); //get email
  $customeremail -> execute();
  $customeremail = $customeremail -> fetchColumn();
  echo "<p>Email: $customeremail</p>"; //display email

  echo "<p><u>Line Items</u></p>"; //start of line items

  $rs = $pdo -> query("SELECT LineID, Description, Price From LineItem Where QuoteID = $qid"); //get line items
  echo "<table border =1 cellspacing =0>";
  echo "<tr><th> Description </th><th> Price </th>\n</tr>"; //display with price

  while($row = $rs-> fetch(PDO::FETCH_ASSOC))
  {

    echo "<tr><td>" . $row["Description"] . "</td><td>" . $row["Price"]. "</td>\n</tr>"; //build table

  }

  echo "</table>";


  echo "<p><u>Secret Notes</u></p>"; //start of notes

  $rs = $pdo -> query("SELECT Note From Quotes Where QuoteID = $qid"); //get notes
  echo "<table border =1 cellspacing =0>";
  echo "<tr><th> Description </th>\n</tr>"; //display descriptions

  while($row = $rs-> fetch(PDO::FETCH_ASSOC))
  {

    echo "<tr><td>" . $row["Note"] . "</td></tr>"; //build table

  }

  echo "</table>";

  $QuoteTotal = $pdo -> query("SELECT SUM(Price) AS value_sum FROM LineItem WHERE QuoteId = $qid"); //get price
  $QuoteTotal -> execute();
  $row = $QuoteTotal -> fetch(PDO::FETCH_ASSOC);
  $sum = $row['value_sum']; //sum up all line items

  echo "<p><u>Discount</u></p><form type = 'submit' action='Finalized.php' method='POST'> <input type='text' name='discount'><input type='radio' id='1' name='amount' value='amount' checked>amount</input><input type='radio' id='2' name='amount' value='percent'>percentage</input>";
  echo "<input type='submit' name='submit' value='Calculate' /></p>"; //choose discount method

  if(isset($_POST['discount']))
  {
    $discountnum = $_POST['discount']; //discount form
  }
  if(isset($_POST['amount']))
  {
    $type = $_POST['amount']; //for amount 

    if($_POST['amount'] == 'amount')
    {
     $sum = $sum - $discountnum; //subtract amount and return value
    }
    else if($_POST['amount'] == 'percent') //for percent
    {
      $originalprice = $sum;
      $sum = $sum - ($originalprice * ($discountnum/100)); //get percentage taken off and then return value
    }
  }

  $format_sum = number_format($sum, 2); //format

  echo "<p> Total Quote Price: $". $format_sum . "</p>"; //give new price


  echo "<br></br>";

  echo "<form type='submit' action='Sanction.php' method='POST'> <input type = 'submit' name='back' value='Cancel'><input type = 'submit' name='Sanctioned' value='Sanction'> </form>"; //form to go back
  if(isset($_POST['back']))
  {
    header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/Sanction.php"); //back to sanction
  }
  if(isset($_POST['Sanctioned']))
  {
	
    $pdo -> exec("UPDATE Quotes SET Status = 'Sanctioned' WHERE QuoteId = $qid"); //form to update quote
    header("Location: http://students.cs.niu.edu/~z1900324/GroupProject3B/Sanction.php");
  }


 ?>








</html>