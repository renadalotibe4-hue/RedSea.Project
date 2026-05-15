<?php
include 'db.php';
$id = $_GET['id'];
$catResult = mysqli_query($conn, "SELECT * FROM category WHERE ID = $id");
$category = mysqli_fetch_assoc($catResult);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category['name']; ?> - دليل البحر الأحمر</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <img src="images/logo.png" alt="Red Sea Logo">
            <a href="index.php">الرئيسية</a>
            <a href="about.html">من نحن</a>
            <a href="admin_login.html">لوحة التحكم</a>
        </div>
    </nav>
    <div class="container">
        <header>
            <h1><?php echo $category['name']; ?></h1>
            <p><?php echo $category['description']; ?></p>
        </header>
        <main>
            <div class="items-grid">
                <?php
                $items = mysqli_query($conn, "SELECT * FROM item WHERE categoryID = $id");
                while ($row = mysqli_fetch_assoc($items)) {
                    $itemID = $row['ID'];
                    $name = $row['name'];
                    $logo = $row['logo'];
                    $desc = $row['description'];
                    echo "
                    <a href='item_profile.php?id=$itemID' class='item-card'>
                        <img src='images/$logo' alt='$name'>
                        <h3>$name</h3>
                        <p>$desc</p>
                    </a>";
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>