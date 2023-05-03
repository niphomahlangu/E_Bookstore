<?php

$bookid = null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Cart Second Hand Book Store</title>
</head>
<body>
    <header>

    </header>
    <main>
        <h1>Latest Products</h1>
        <div class="products">
        <div class="box-container">
            <?php
                $selectProduct = mysqli_query($conn,"SELECT * FROM 'tblbooks' WHERE $bookid = 'bookid'") or die('query failed');
                if(mysqli_num_rows($selectProduct)>0){
                    while($fetchProduct = mysqli_fetch_assoc($selectProduct)){
            ?>
                <form action="">
                    <img src="images/<?php echo $fetch_product['image']; ?>" alt="">
                </form>
                
            <?php
                };
            };

            ?>


            ?>
        </div>
        </div>
    </main>
    <footer>
        
    </footer>
</body>
</html>