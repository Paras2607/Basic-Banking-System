<!Doctype HTML>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="HomePage.css">
</head>

<body>
    
<div><a href="HomePage.php"><img src="./images/logo.png" class="img-responsive"  width='5%'  align="center" alt="LOGO"/></a>	
<h1><a  href="HomePage.php" style="text-decoration: none;">THE SPARKS BANK</a>
    
</h1></div>

    <form method="post"> 
        <button  style="background-color: rgb(85, 85, 85);color: white;padding: 16px 20px;border: none;cursor: pointer;opacity: 0.8;position: absolute;display:block; left:10%;" name="View_customer" value="View_customer">View Customer</button> 
          
        </form>
    <form method="post"> 
        <button  style="background-color: rgb(85, 85, 85);color: white;padding: 16px 20px;border: none;cursor: pointer;opacity: 0.8;position: absolute;display:block; left:25%;" name="View_transaction" value="View_transaction">Transaction History</button> 
          
        </form>
    

		<button class="open-button " onclick="Transfer()">Transfer Money</button>
    <div class="form-popup" id="myForm">
    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-container">
        <h1>Transfer Money</h1>
        <table>
        <tr>
        <td><label for="email"><b>Transfer from</b></label></td>
        <td><input type="int" placeholder="" name="Sender" required></td>
        </tr>
        <tr>
        <td><label for="psw"><b>Transfer To</b></label></td>
        <td><input type="int" placeholder=".." name="Receiver" required></td>
        </tr>
        <tr>
        <td><label for="psw"><b>Amount</b></label></td>
        <td><input type="bigint" placeholder="Enter Amount" name="Amount" required></td>
        </tr>
        <tr>
        <td><button type="button" class="btn cancel" onclick="closeForm()">Close</button></td>
        <td><button type="submit" class="btn">Submit</button></td>
        </tr>
        </table>
    </form>
    </div>

<script>
function Transfer() {
  document.getElementById("myForm").style.display = "block";
}
function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

</script>
<footer> 
        <p>Join us on</p>
        <div>
            <b>|</b>&nbsp;<a href="#">GITHUB</a>&nbsp;<b>|</b>&nbsp;
            <a href="#">LINKEDIN</a>&nbsp;<b>|</b>&nbsp;
            <a href="#">FACEBOOK</a>&nbsp;<b>|</b>&nbsp;
            <a href="#">TWITTER</a>&nbsp;<b>|</b>&nbsp;
        </div>
        <p>&copy; Sparks Bank. All rights reserved.</p>
    </footer>
    <?php
    require ("connection.php");
    if (isset($_POST['Sender'])&&isset($_POST['Receiver'])&&isset($_POST['Amount'])){
    $Sender=$_POST['Sender'];
    $Receiver=$_POST['Receiver'];
    $Amount=$_POST['Amount'];
    $sql="select balance from Customer where account_number=".$_POST['Sender'];
    $res=mysqli_query($conn,$sql);
    $arr = mysqli_fetch_row($res);
    
    $sql="select balance from Customer where account_number=".$_POST['Receiver'];
    $res=mysqli_query($conn,$sql);
    $arr1 = mysqli_fetch_row($res);
    
    
    if($arr !=NULL && $arr1 !=NULL ){
    if ($arr[0] < $Amount){
        echo "<script>alert('Insufficient Account Balance')</script>";
    }
    else {  
    $sql="Update Customer Set balance=balance-".$Amount." where account_number=".$_POST['Sender'];
    mysqli_query($conn,$sql);
    $sql="Update Customer Set balance=balance+".$Amount." where account_number=".$Receiver;
    if (mysqli_query($conn,$sql)){
        $sql="insert into transaction (crediter_id,debiter_id,amount)Values(?,?,?)";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "ddd", $Receiver, $Sender,$Amount);
        mysqli_stmt_execute($stmt);      
    
    echo "<script>alert('Money Transfer Successfully')</script>";
    }
    
    }
    }}
    else{
        echo "<script>alert(' Money Not transferred Enter details Correctly')</script>";
    }
    }
    
    if($_GET){
    if(isset($_GET['View_customer'])){
        View_customer();
    }
    }
    
     
     if(isset($_POST['View_customer'])) { 
    $sql="select account_number,name,balance from Customer ";   
    $res = mysqli_query($conn, $sql);
    

    echo"<table class='customer' border='1' >";
    echo "<tr><th>account_number</th><th>Customers</th><th>Balance</th></tr>";
    while ($row=mysqli_fetch_array($res))
       {
         echo"<tr><td>".$row['account_number']." </td>";
         echo"<td>".$row['name']."</td>";
         echo"<td>Rs.".$row['balance']."</td></tr>";

    }
    echo"</table><br>";
    } 
    if(isset($_POST['View_transaction'])) { 
        $sql="select crediter_id,debiter_id,amount from transaction ";   
        $res = mysqli_query($conn, $sql);
        
    
        echo"<table class='customer'  border='1' >";
        echo "<tr><th>Receiver Account no</th><th>Sender Account no</th><th>Amount</th></tr>";
        while ($row=mysqli_fetch_array($res))
           {
             echo"<tr><td>".$row['crediter_id']." </td>";
             echo"<td>".$row['debiter_id']."</td>";
             echo"<td>Rs.".$row['amount']."</td></tr>";
    
        }
        echo"</table><br>";
        } 
            
    ?> 
      


</body>
</html>



