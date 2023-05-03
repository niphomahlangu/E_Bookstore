<?php
session_start();
    include "dbConn.php";
    if(!isset($_SESSION['stnumber'])){
        header("location:login.php");
    }
    //load books into bookstore database
    //include "loadBooks.php";

    $stnumber = $user = $outputUser= null;

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

    if(isset($_POST['btnLogout'])){
        unset($_SESSION['stnumber']);
        session_destroy ();
        header('location: login.php');
    }

    /*
        This code was obtained from YouTube:
        Author: Daily Tuition
        URL: https://www.youtube.com/watch?v=IO5ezsURqyg
    */
    if(isset($_POST["add"])){
        if(isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id");
            if(!in_array($_GET["bookid"],$item_array_id)){
                $count = count($_SESSION["cart"]);
                $item_array = array(
                    'product_id' => $_GET["bookid"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                echo '<script>alert("Item added to cart.")</script>';
                echo '<script>window.location="index.php"</script>';
            }else{
                echo '<script>alert("Product is already added.")</script>';
                echo '<script>window.location="index.php"</script>';
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["bookid"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }

    if(isset($_GET["action"])){
        if($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $key => $value) {
                if($value['product_id'] == $_GET["bookid"]){
                    unset($_SESSION["cart"][$key]);
                    echo '<script>alert("Product has been removed.")</script>';
                echo '<script>window.location="index.php"</script>';
                }
            }
        }
    }
    if(isset($_POST['btn_checkout'])){
        header('location: checkOut.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <style>
        
        @import url('https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200&display=swap');
        .container{
            font-family: 'Titillium Web', sans-serif;
            background-color: rgba(255, 255, 255, 0.4);
        }
        .product{
            border: 1px solid #eaeaec;
            margin: -1px 19px 3px -1px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
        }
        table, th, tr{
            text-align: center;
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

        .btnLogOut  
        {
            color: white;
            background-color: maroon;
        }
        
        #myBtn{
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: maroon;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
            font-size: 12px;
        }
        .chkOut
       {
            text-align: center;
            padding: 20px;
            background-color: #26c000;
            border-style: none;
            border-radius: 15px;
            font-size: 20px;
            padding: 10px;
            color: white;
       } 
        .indexChkOut
        {
            text-align: center;
        }
    </style>
    <title>Book Cart Second Hand Book Store</title>
</head>
    <header>
        <img src="images/bookCart_logo.png" alt="Book Cart Logo">
    </header>
<body class = "home">  
    <div class="userInfoDiv">
        <?php echo $outputUser?><br><br>
        <form action = "index.php" method = "post">
            <input class="btnLogOut" type="submit" value="logout" name="btnLogout">
        </form>
    </div><br><br>
    <div class = "container">
    <h2 class="title1">Book Cart Store Catalogue</h2>
        <?php
        
        //load book info from database
        $bookQry = "SELECT * FROM tblbooks ORDER BY bookid ASC";
        $result = mysqli_query($conn,$bookQry);

        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)){
                
            ?>
        <div class="col-md-3">
                <form method="post" action="index.php?action=add&bookid=<?php echo $row["bookid"] ?>" >
                    <div class="product">
                        <img src="<?php echo $row["image"]; ?>" alt="" class="img-responsive">
                        <h5 class="text-info"><?php echo $row["booktitle"]; ?></h5>
                        <h5 class="text-danger"><?php echo $row["price"]; ?></h5> 
                        <input type="text" name="quantity" class="form-control" value="1">
                        <input type="hidden" name="hidden_name" value="<?php echo $row["booktitle"]; ?>">
                        <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                        <input type="submit" name ="add" style = "margin-top: 5px;" class="btn btn-success" value="Add to Cart"><br>
                        <a href="#bottom">Go to cart</a>
                    </div>
                </form>
        </div>
        <?php
            }
        }
            ?>

            <div style="clear: both "></div>
            <h3 class="title2">Shopping Cart Details</h3>
            <div class="table-responsive" id = "bottom">
                <a href="bottom">
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
                      </a>
            </div>
    </div>
    <button onclick = "topFunction()" id="myBtn" title="Go to top">Top</button>
    <script>
        mybutton = document.getElementById("myBtn");
        window.onscroll = function() {scrollFunction()};

        function scrollFunction(){
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            }
            else {
                mybutton.style.display = "none";
            }
        }
        function topFunction(){
            document.body.scrollTop = 0
            document.documentElement.scrollTop = 0;
        }
    </script>
    <div class = "indexChkOut">
                <form action="index.php" method="post">
                <input type="submit" class="chkOut" name="btn_checkout" value="Check Out">
                </form>
            </div>

</body> 
</html>

