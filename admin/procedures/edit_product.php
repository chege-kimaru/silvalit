<?php
require_once '../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
//    $session->getFlashBag()->add('error', 'Sorry, access to the page you tried to visit is denied. Or is currently not available!');
//    header('location: index.php');
    echo "<h1 style='color: red'>ACCESS DENIED</h1>";
    exit;
}

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$brand = $_POST['brand'];
$id = $_POST['id'];
$new_arrival = $_POST['new_arrival'];
$new_product = $_POST['new_product'];
$best_seller = $_POST['best_seller'];

$img = $_FILES['img']['name'];
$tmp = $_FILES['img']['tmp_name'];
$type = $_FILES['img']['type'];

if(!$name) {
//    $session->getFlashBag()->add('error', 'Please fill all the required fields');
//    header('location: campus_form.php');
    echo "<h1 style='color: brown'>Name of product is required. Please ensure these fields are filled.</h1>";
    exit;
}
if($new_arrival != 1) $new_arrival = 0;
if($new_product != 1) $new_product = 0;
if($best_seller != 1) $best_seller = 0;

try {
    $product_id = updateProduct($id, $name, $price, $description, $brand, $new_arrival, $new_product, $best_seller); 
    echo "<h1 style='color: green'>Successfully updated product. $product_id</h1>";
    if($img) {
        $product = findProductById($id);
        if ($product['image'] && file_exists('../'.$product['image'])) {
            if(!unlink('../'.$product['image'])) {
                echo "<h1 style='color: brown'>Error deleting current image ../".$product['image']."</h1>";
            }
        } else {
            echo "<h1 style='color: brown'>Current image unavailable</h1>";
        }
        $dir = "../../uploads/products/".$product['id']."/";
        $real_path = "uploads/products/".$product['id']."/".time().$img;
        $save_path = "../../".$real_path;
        mkdir($dir, 0777, true);
        if(move_uploaded_file($tmp, $save_path)) {
            try {
                $stmt = $db->prepare("UPDATE products SET image = :path WHERE id = :product_id");
                $stmt->bindParam(':path', $real_path);
                $stmt->bindParam(':product_id', $id);
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
    exit;
//    $session->getFlashBag()->add('success', 'Successfully added new campus.');
//    header('location: campus_form.php');
} catch (\Exception $e) {
//    $session->getFlashBag()->add('error', "OOps, an error occurred while adding campus. {$e->getMessage()} Please try again or consult admin.");
//    header('location: campus_form.php');
    echo "<h1 style='color: red'>".$e->getMessage()."</h1>";
    exit;
}