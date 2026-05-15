<?php
include 'db.php';
$id = $_GET['id'];

// إضافة ريفيو جديد
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = mysqli_real_escape_string($conn, $_POST['name']);
    $body   = mysqli_real_escape_string($conn, $_POST['body']);
    $rating = $_POST['rating'];
    mysqli_query($conn, "INSERT INTO review (item_id, name, body, rating) VALUES ($id, '$name', '$body', '$rating')");
}

// جلب بيانات العنصر
$itemResult = mysqli_query($conn, "SELECT * FROM item WHERE ID = $id");
$item = mysqli_fetch_assoc($itemResult);

// جلب متوسط التقييم
$ratingResult = mysqli_query($conn, "SELECT AVG(rating) as avg_rating, COUNT(*) as count FROM review WHERE item_id = $id");
$ratingData   = mysqli_fetch_assoc($ratingResult);
$avgRating    = round($ratingData['avg_rating'], 1);
$reviewCount  = $ratingData['count'];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item['name']; ?> - دليل البحر الأحمر</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .item-header {
            background: linear-gradient(135deg, #005f73, #0a9396);
            color: white; border-radius: 20px; padding: 40px;
            margin: 30px auto; max-width: 900px;
            display: flex; align-items: center; gap: 30px;
            box-shadow: 0 10px 30px rgba(0,95,115,0.2);
        }
        .item-logo {
            width: 130px; height: 130px; object-fit: cover;
            border-radius: 16px; border: 4px solid rgba(255,255,255,0.3); flex-shrink: 0;
        }
        .item-info h1 { margin: 0 0 8px 0; font-size: 26px; }
        .item-info p  { margin: 0 0 15px 0; opacity: 0.9; line-height: 1.7; }
        .stars-display { color: #f4d03f; font-size: 22px; letter-spacing: 2px; }

        .breadcrumb {
            max-width: 900px; margin: 20px auto 0 auto;
            font-size: 14px; color: #888;
        }
        .breadcrumb a { color: #0a9396; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        .section-wrap { max-width: 900px; margin: 0 auto 30px auto; }
        .section-title {
            color: #005f73; font-size: 20px;
            border-bottom: 3px solid #0a9396; padding-bottom: 10px; margin-bottom: 20px;
        }
        .review-card {
            background: white; border-radius: 14px; padding: 20px 25px;
            margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border-right: 5px solid #0a9396;
        }
        .review-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .reviewer-name { font-weight: bold; color: #005f73; font-size: 16px; }
        .review-stars  { color: #f4d03f; font-size: 16px; }
        .review-body   { color: #444; line-height: 1.7; font-size: 15px; margin: 0; }

        .no-reviews {
            text-align: center; padding: 40px; color: #aaa;
            background: white; border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-size: 15px;
        }

        .add-review-box {
            background: white; border-radius: 20px; padding: 30px 35px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06); margin-bottom: 60px;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 7px; font-weight: bold; color: #005f73; }
        .form-group input,
        .form-group textarea {
            width: 100%; padding: 11px 14px; border: 1px solid #ddd;
            border-radius: 10px; box-sizing: border-box;
            font-family: inherit; font-size: 15px; transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group textarea:focus { outline: none; border-color: #0a9396; }
        .form-group textarea { height: 110px; resize: vertical; }

        /* النجوم التفاعلية */
        .star-rating-input { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px; }
        .star-rating-input input { display: none; }
        .star-rating-input label { font-size: 30px; color: #ccc; cursor: pointer; transition: color 0.2s; margin-bottom: 0; }
        .star-rating-input input:checked ~ label,
        .star-rating-input label:hover,
        .star-rating-input label:hover ~ label { color: #f4d03f; }

        .btn-submit {
            background-color: #005f73; color: white; border: none;
            padding: 13px 35px; border-radius: 10px; cursor: pointer;
            font-size: 17px; font-weight: bold; transition: background-color 0.3s; margin-top: 8px;
        }
        .btn-submit:hover { background-color: #0a9396; }

        @media (max-width: 600px) {
            .item-header { flex-direction: column; text-align: center; padding: 25px; }
        }
    </style>
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

    <!-- معلومات العنصر -->
    <div class="item-header">
        <img src="images/<?php echo $item['logo']; ?>" alt="<?php echo $item['name']; ?>" class="item-logo">
        <div class="item-info">
            <h1><?php echo $item['name']; ?></h1>
            <p><?php echo $item['description']; ?></p>
            <span class="stars-display">
                <?php
                $full  = floor($avgRating);
                $empty = 5 - $full;
                echo str_repeat('★', $full) . str_repeat('☆', $empty);
                ?>
            </span>
            <?php if ($reviewCount > 0): ?>
                <span style="opacity:0.8"> <?php echo $avgRating; ?> / 5 (<?php echo $reviewCount; ?> تقييمات)</span>
            <?php else: ?>
                <span style="opacity:0.8"> لا يوجد تقييم بعد</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- الريفيوهات -->
    <div class="section-wrap">
        <h2 class="section-title">💬 آراء الزوار</h2>
        <?php
        $reviews = mysqli_query($conn, "SELECT * FROM review WHERE item_id = $id");
        if (mysqli_num_rows($reviews) == 0) {
            echo "<div class='no-reviews'>لا توجد تقييمات بعد — كن أول من يقيّم!</div>";
        } else {
            while ($review = mysqli_fetch_assoc($reviews)) {
                $stars = str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']);
                echo "
                <div class='review-card'>
                    <div class='review-header'>
                        <span class='reviewer-name'>{$review['name']}</span>
                        <span class='review-stars'>$stars</span>
                    </div>
                    <p class='review-body'>{$review['body']}</p>
                </div>";
            }
        }
        ?>
    </div>

    <!-- فورم إضافة ريفيو -->
    <div class="section-wrap">
        <div class="add-review-box">
            <h2 class="section-title">✍️ أضف تقييمك</h2>
            <form method="POST">
                <div class="form-group">
                    <label>اسمك:</label>
                    <input type="text" name="name" placeholder="أدخل اسمك" required>
                </div>
                <div class="form-group">
                    <label>تقييمك:</label>
                    <div class="star-rating-input">
                        <input type="radio" name="rating" id="star5" value="5" required>
                        <label for="star5">★</label>
                        <input type="radio" name="rating" id="star4" value="4">
                        <label for="star4">★</label>
                        <input type="radio" name="rating" id="star3" value="3">
                        <label for="star3">★</label>
                        <input type="radio" name="rating" id="star2" value="2">
                        <label for="star2">★</label>
                        <input type="radio" name="rating" id="star1" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>رأيك:</label>
                    <textarea name="body" placeholder="اكتب تجربتك مع هذا المكان..." required></textarea>
                </div>
                <button type="submit" class="btn-submit">إرسال التقييم</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>