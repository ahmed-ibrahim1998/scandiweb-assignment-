<?php

// استخدام namespace الصحيح
namespace App;

require_once 'vendor/autoload.php';

use App\Controllers\ProductController;
use Config\Database; // تأكد أن المسار صحيح

// اتصل بقاعدة البيانات إذا لزم الأمر
$db = (new Database())->getConnection(); // إذا كنت بحاجة إلى الاتصال بالقاعدة

// إنشاء كائن من ProductController
$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productController->addProduct(); // استدعاء الدالة لإضافة المنتج
}

// تحميل واجهة إضافة المنتج
include 'views/add-product.php'; // Load the add product view
