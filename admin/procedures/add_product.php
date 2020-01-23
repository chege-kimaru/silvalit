<?php
require_once '../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
//    $session->getFlashBag()->add('error', 'Sorry, access to the page you tried to visit is denied. Or is currently not available!');
//    header('location: index.php');
    echo "<h1 style='color: red'>ACCESS DENIED</h1>";
    exit;
}

$name = $_POST['name'];
$category_id = $_POST['category_id'];
$price = $_POST['price'];
$description = $_POST['description'];
$brand = $_POST['brand'];
$new_arrival = $_POST['new_arrival'];
$new_product = $_POST['new_product'];
$best_seller = $_POST['best_seller'];

$img = $_FILES['img']['name'];
$tmp = $_FILES['img']['tmp_name'];
$type = $_FILES['img']['type'];

if(!$name || !$category_id) {
//    $session->getFlashBag()->add('error', 'Please fill all the required fields');
//    header('location: campus_form.php');
    echo "<h1 style='color: brown'>Name and Category of product are required. Please ensure these fields are filled.</h1>";
    exit;
}

if(($type == "image/jpeg") || ($type == "image/jpg") || ($type == "image/png")) {
        
} else {
    echo "<h1 style='color: brown'>This file has to be a jpeg or jpg or png.</h1>";
    exit;
}

if($new_arrival != 1) $new_arrival = 0;
if($new_product != 1) $new_product = 0;
if($best_seller != 1) $best_seller = 0;
try {
    $product_id = createProduct($name, $category_id, $price, $description, $brand, null, $new_arrival, $new_product, $best_seller);   
    echo "<h1 style='color: green'>Successfully added product.</h1>";
    
    if($img) {
        $dir = "../../uploads/products/".$product_id."/";
        $real_path = "uploads/products/".$product_id."/".time().$img;
        $save_path = "../../".$real_path;
        mkdir($dir, 0777, true);
        if(move_uploaded_file($tmp, $save_path)) {
            try {
                $stmt = $db->prepare("UPDATE products SET image = :path WHERE id = :product_id");
                $stmt->bindParam(':path', $real_path);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->execute();
                echo "<h1 style='color: green'>Successfully uploaded image</h1>";
            } catch (\Exception $e) {
                throw $e;
            }
        } else {
            echo "<h1 style='color: red'>Error uploading image</h1>";
            exit;
        }
    } else {
        echo "<h1 style='color: brown'>No image provided.</h1>";
    }
//    $session->getFlashBag()->add('success', 'Successfully added new campus.');
//    header('location: campus_form.php');
} catch (\Exception $e) {
//    $session->getFlashBag()->add('error', "OOps, an error occurred while adding campus. {$e->getMessage()} Please try again or consult admin.");
//    header('location: campus_form.php');
    echo "<h1 style='color: red'>".$e->getMessage()."</h1>";
    exit;
}