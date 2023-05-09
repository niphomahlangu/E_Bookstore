<?php
    session_start();
    include "dbConn.php";
    
    $row = $output = $results = $book_id = null;
    $bookTitle=$category=$image=$price=$qnty=$img=$cost=$delete=$rowid=$delResult=$cmdResult = null;
    $update = false;
    
    //log user out
    if(isset($_POST['btnLogout'])){
        unset($_SESSION['email']);
        unset($_SESSION['user']);
        session_destroy ();
        header('location: admin.php');
    }

    //add new book
    if(isset($_POST['btn_addBook'])){

        $bookTitle = $_POST['booktitle'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $image = "\images/coming-soon.png";
        $qnty = 10;

        $insert = "INSERT INTO tblbooks (booktitle, category, image, price, qnty) VALUES ('$bookTitle','$category','$image','$price','$qnty')";
        $insertResult = mysqli_query($conn,$insert);

            //check if row was affected
            if($insertResult){
                $output = "Book inserted successfully";
                
            }else{
                $output = "<br>ERROR. Row NOT Inserted!!!";
            }
    }
    
    //row to be edited
    if(isset($_GET['edit'])){
        

        $update = true;
        //get row id
        $book_id = $_GET['edit'];

        //read data of the selected row
        $sql = "SELECT booktitle, category, price FROM tblbooks WHERE bookid=$book_id";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);

        if($row){
            $bookTitle = $row["booktitle"];
            $category = $row["category"];
            $price = $row["price"];
        }else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    //update the record
    if(isset($_POST['btn_update'])){
        
        $book_id = $_POST['bookid'];
        $bookTitle = $_POST['booktitle'];
        $category = $_POST['category'];
        $price = $_POST['price'];

        $sql = "UPDATE tblbooks SET booktitle='$bookTitle', category='$category', price='$price'  WHERE bookid=$book_id";
        $result = mysqli_query($conn,$sql);
        if($result){
            header("location: storeAdmin.php");
        }else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    //delete a row
    if(isset($_GET['del'])){
        $book_id= $_GET['del'];
        $sql = "DELETE FROM tblbooks WHERE bookid=$book_id";
        $result = mysqli_query($conn,$sql);
        if($result){
            header("location: storeAdmin.php");
        }else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book Cart Store Admin</title>

    <style>
        h1{
            color: white;
        }
        h2{
            color: white;
        }
        table{
            width: 50%;
            margin: 30px auto;
            border-collapse: collapse;
            text-align: left;
            color: white;
        }
        tr {
            border-bottom: 1px solid #cbcbcb;
        }
        th, td{
            border: none;
            height: 30px;
            padding: 2px;
        }
        tr:hover {
            background: gray;
        }

        .btn-edit{
            padding: 5px;
            border-radius: 3px;
            background-color: blue;
            color: white;
            text-decoration: none;
        }

        .btn-delete{
            padding: 5px;
            border-radius: 3px;
            background-color: red;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <form action="storeAdmin.php" method="post" >
        <div class="userInfoDiv">
            <?php 
            echo "Admnin has logged in.<br><br>";
             ?>
            <input type="submit" class = "btn" value="logout" name="btnLogout">
        </div>
    </form>
    <br>
    
    <div style="text-align: center;" class = "userbox">
        <h1>Manage Users</h1>
        <h2>Unverified users</h2>
        
        <h2>Verified users</h2>
    </div>
    <div style="text-align: center;" class = "bookbox">
        <h1>Manage Books</h1>
        <form action="storeAdmin.php" method="post">
        <div class="userInfoDiv">
            <?php echo $output?><br><br>
            <input type="hidden" name="bookid"  >
            <input type="text" name="booktitle" placeholder="Enter book title" value="<?php echo $bookTitle; ?>" ><br><br>
            <input type="text" name="category" placeholder="Enter book category" value="<?php echo $category; ?>"><br><br>
            <input type="text" name="price" placeholder="Enter book price" value="<?php echo $price; ?>" ><br><br>
            <?php if($update == true): ?>
                <input type="submit" name="btn_update" value="Update">
                <?php else: ?>
            <input type="submit" name="btn_addBook" value="Add">
            <?php endif ?>
        </div>
        </form>
        <div style="background-color: rgba(0, 0, 0, 0.75);">
            <?php echo $cmdResult; ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Price</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
    <?php
    $qry = "SELECT bookid, booktitle, price FROM tblbooks WHERE image = 'images/coming-soon.png' ";
    $results = mysqli_query($conn,$qry);

    if(mysqli_num_rows($results) > 0){
        while ($row = mysqli_fetch_array($results)) {
            $book_id = $row['bookid'];
            $title = $row['booktitle'];
            $cost = $row['price'];?>
            <tr>
                <td><?php echo $title; ?></td>
                <td><?php echo $cost; ?></td>
                <td>
                    <a class="btn-edit" href="storeAdmin.php?edit=<?php echo $book_id; ?>">Edit</a>
                </td>
                <td>
                <a class="btn-delete" href="storeAdmin.php?del=<?php echo $book_id; ?>">Delete</a>
                </td>
            </tr>
    <?php    }
    }?>
        </table>
    </div>
</body>
</html>