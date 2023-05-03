<?php
    session_start();
    include "dbConn.php";
    
    $row = $output = $results = $book_id = null;
    $bookTitle=$category=$image=$price=$qnty=$img=$title=$cost=$delete=$rowid=$delResult=$cmdResult = null;
    
    
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
    

    $qry = "SELECT bookid, booktitle, price FROM tblbooks WHERE image = 'images/coming-soon.png' ";
    $results = mysqli_query($conn,$qry);
        
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
            <input type="text" name="booktitle" placeholder="Enter book title" ><br><br>
            <input type="text" name="category" placeholder="Enter book category"><br><br>
            <input type="text" name="price" placeholder="Enter book price" ><br><br>
            <input type="submit" name="btn_addBook" value="Add">
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
    if(mysqli_num_rows($results) > 0){
        while ($row = mysqli_fetch_array($results)) {
            $book_id = $row['bookid'];
            $title = $row['booktitle'];
            $cost = $row['price'];?>
            <tr>
                <td><?php echo $title; ?></td>
                <td><?php echo $cost; ?></td>
                <td>
                    <a class="btn-edit" href="editBook.php?id=<?php echo $book_id; ?>">Edit</a>
                </td>
                <td>
                <a class="btn-delete" href="">Delete</a>
                </td>
            </tr>
    <?php    }
    }?>
        </table>
    </div>
</body>
</html>