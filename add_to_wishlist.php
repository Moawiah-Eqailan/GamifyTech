<?php
session_start();
include 'includes/wishlistClass.php'; // تأكد من تضمين كلاس Wishlist

$wishlist = new Wishlist(); // إنشاء كائن من الكلاس Wishlist
$userId = $_SESSION['user_id']; // استرجاع معرف المستخدم

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); // الحصول على معرف المنتج

    // إضافة المنتج إلى قائمة المفضلات
    if ($wishlist->addToWishlist($userId, $productId)) {
        // إعادة التوجيه أو عرض رسالة نجاح
        header("Location: wishlist.php?success=1"); // إعادة التوجيه إلى صفحة المفضلات
        exit();
    } else {
        // عرض رسالة خطأ
        echo "Product already in wishlist.";
    }
}
?>
