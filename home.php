<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

    $resources_name = $_POST['resources_name'];
    //    $product_price = $_POST['product_price'];
    $resources_item = $_POST['resources_item'];
    //    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `selected` WHERE name = '$resources_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already selected!';
    } else {
        mysqli_query($conn, "INSERT INTO `selected`(user_id, name, item) VALUES('$user_id', '$resources_name', '$resources_item')") or die('query failed');
        $message[] = 'Resources Added!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <section class="home">

        <div class="content">
            <h3>Official Engineering School Resource website</h3>
            <a href="about.php" class="white-btn">discover more</a>
        </div>

    </section>

    <section class="products">

        <h1 class="title">Latest Resources</h1>

        <div class="box-container">

            <?php
            $select_resources = mysqli_query($conn, "SELECT * FROM `resources` LIMIT 6") or die('query failed');
            if (mysqli_num_rows($select_resources) > 0) {
                while ($fetch_resources = mysqli_fetch_assoc($select_resources)) {
            ?>
            <form action="" method="post" class="box">
                <img class="image" src="resources/<?php echo $fetch_resources['item']; ?>" alt="">
                <div class="name"><?php echo $fetch_resources['name']; ?></div>
                <input type="hidden" name="product_name" value="<?php echo $fetch_resources['name']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_resources['item']; ?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">No books added yet!</p>';
            }
            ?>
        </div>

        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="shop.php" class="option-btn">load more</a>
        </div>

    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/esug.jpg" alt="">
            </div>

            <div class="content">
                <h3>about us</h3>
                <p>Welcome to the School of Engineering Sciences at University of Ghana. The School of Engineering
                    Sciences was established as the Faculty of Engineering Sciences (FES) in the 2003/2004 Academic Year
                    and welcomed its pioneering batch of 31 students, comprising 26 male and 5 females in August 2004.
                    FES attained its current status as the School of Engineering Sciences (SES) when the University
                    adopted the Collegiate System of Governance in 2014.</p>
                <a href="about.php" class="btn">read more</a>
            </div>

        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>have any questions?</h3>
            <a href="contact.php" class="white-btn">contact us</a>
        </div>

    </section>





    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>