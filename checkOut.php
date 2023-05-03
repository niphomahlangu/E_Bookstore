<?php
    session_start();
    include "dbConn.php";
    $outputUser = null;

    if(isset($_SESSION['stnumber'])){
        $stnumber = $_SESSION['stnumber'];
        $qry = "SELECT fname, lname FROM tblusers WHERE stnumber='$stnumber'";
        $qryResult = mysqli_query($conn,$qry);
        //place query result in array
        $user = mysqli_fetch_assoc($qryResult);
        if($user){
            $outputUser = "User " .$user['fname']." ".$user['lname']." is logged in";
        }
        
    }

    if(isset($_POST['btn_place_order'])){
        header('location: done.php');
    }

    if(isset($_POST['btnLogout'])){
        unset($_SESSION['stnumber']);
        session_destroy ();
        header('location: login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200&display=swap');
        table, th, tr{
            text-align: center;
            background-color: #efefef;
        }
        .title1{
            text-align: center;
            color: black;
            style: bold;
            background-color: #efefef;
            padding: 2%;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        table th{
            background-color: #efefef;
        }
        .block1{
            color: white;
            background-color: rgba(0, 0, 0, 0.75);
            text-align: center;
        }

        .order
        {
            padding: 15px;
            background-color: #26c000;
            border-style: none;
            border-radius: 15px;
            font-size: 20px;
            color: white;
        }
        .orderDiv{
            text-align: center;
        }
        .btnLogOut
        {
            background-color: maroon;
            color: white;
        }
        table
        {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="userInfoDiv">
        <?php echo $outputUser?><br><br>
        <form action = "index.php" method = "post">
            <input class="btnLogOut" type="submit" value="logout" name="btnLogout">
        </form>
    </div>
<div class="block1">
<h1>Check Out Zone</h1>
</div>
    
    <h3 class="title2">Shopping Cart Details</h3>

            <div class="table-responsive" id = "bottom">
                
                <table class="table table-bordered">
                <tr>
                    <th width="30%">Product Name</th>
                    <th width="10%">Quantity</th>
                    <th width="13%">Price Details</th>
                    <th width="10%">Total Price</th>
                    <th width="17%">Remove Item</th>
                </tr>
                <?php
                    if(!empty($_SESSION["cart"])){
                        $total = 0;
                        foreach ($_SESSION["cart"] as $key => $value) {
                            ?>
                      <tr>
                          <td><?php echo $value["item_name"]; ?></td>
                          <td><?php echo $value["item_quantity"]; ?></td>
                          <td>R <?php echo $value["product_price"]; ?></td>
                          <td>R <?php echo number_format($value["item_quantity"] * $value["product_price"],2); ?></td>
                          <td> <a href = "index.php?action=delete&bookid=<?php echo $value["product_id"]; ?>"><span class="text-danger">Remove Item</span></a></td>
                      </tr>
                      <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                        }
                      ?>
                      <tr>
                          <td colspan="3" align="right">Total</td>
                          <th align="right">R <?php echo number_format($total,2); ?></th>
                          <td></td>
                          <?php
                        }
                        ?>
                      </tr>
                      </table>
            </div><br><br>
            <div class="orderDiv">
                <form action="checkOut.php" method="post">
                        <input type="submit" class="order" value="Place Order" name="btn_place_order">
                </form>       
            </div>
            
</body>
</html>