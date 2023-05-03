<?php

session_start();
    include "dbConn.php";

    $book_id=$bookTitle=$category=$price=$result=$errorMessage=null;

    if(isset($_GET["id"])){
        //header("location: storeAdmin.php");
        //exit;
        //get the exact row id
        $book_id = $_GET["id"];
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
        

        if(isset($_POST['btn_update'])){
            //update data using POST method
            $book_id = $_POST['bookid'];
            $bookTitle = $_POST['booktitle'];
            $category = $_POST['category'];
            $price = $_POST['price'];

            //validate text fields
            if(empty($bookTitle) || empty($category) || empty($price)){
                $errorMessage = "Fields cannot be empty";
            }

            $sql = "UPDATE tblbooks SET booktitle='$bookTitle', category='$category', price='$price' WHERE bookid=$book_id";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo "Updated successfully";
                /*echo '<script>alert("Book info has been updated.")</script>';
                echo '<script>window.location="editBook.php"</script>';*/
            }else{
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            //redirect to storeAdmin page
            //header("location: storeAdmin.php");
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
    <title>Edit Book</title>
</head>
<body>
    <form action="storeAdmin.php" method="post">
        <div class="userInfoDiv">
            <?php echo $errorMessage ?><br><br>
            <input type="hidden" name="bookid" value="<?php echo $book_id; ?>" >
            <input type="text" name="booktitle" placeholder="Enter book title" value="<?php echo $bookTitle; ?>"><br><br>
            <input type="text" name="category" placeholder="Enter book category" value="<?php echo $category; ?>"><br><br>
            <input type="text" name="price" placeholder="Enter book price" value="<?php echo $price; ?>" ><br><br>
            <input type="submit" name="btn_update" value="Update">
        </div>
    </form>
</body>
</html>