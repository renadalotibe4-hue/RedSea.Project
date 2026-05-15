<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل البحر الأحمر السياحي</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav>
        <div class="nav-container">
            <img src="images/logo.png" alt="Red Sea Logo">
            <a href="index.html">الرئيسية</a>
            <a href="pages/about.html">من نحن</a>
            <a href="pages/admin_panel.html">لوحة التحكم</a>
        </div>
    </nav>

    <div class="container">
        <header>
            <h1>مرحباً بكم في دليل البحر الأحمر السياحي</h1>
            <p>هذه الصفحة هي الواجهة الرئيسية للموقع، ومن هنا تبدأ رحلة الزوار.</p>
        </header>
        
    <main>
    <div class="items-grid">
        <?php
        
        $conn = mysqli_connect("localhost", "root", "", "redsea_db");

        // Check connection 
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        
        $sql = "SELECT * FROM Item";
        $result = mysqli_query($conn, $sql);

        // 3. Loop the database 
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<a href="item_profile.php?id=' . $row["ID"] . '" class="item-card">';
                echo '<img src="images/' . $row["logo"] . '" alt="' . $row["name"] . '">';
                echo '<h3>' . $row["name"] . '</h3>';
                echo '<p>' . $row["description"] . '</p>';
                echo '</a>';
            }
        } else {
            // If database is empty
            echo "<p style='text-align: center;'>لا توجد معالم سياحية مضافة حالياً.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</main>
        
    </div>

</body>
</html>