<?php
require_once __DIR__ . "/bootstrap.php";

$db->beginTransaction();

try {
    $createCategory = $db->exec("CREATE TABLE categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    color VARCHAR(255),
    icon VARCHAR(255),
    created_at datetime DEFAULT CURRENT_TIMESTAMP
    )");
    
    $createProduct = $db->exec("CREATE TABLE products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id INT(11) NOT NULL,
    price INT(11),
    description VARCHAR(255),
    brand VARCHAR(255),
    image VARCHAR(255),
    new_arrival INT(1),
    new_product INT(1),
    best_seller INT(1),
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
    )");
    
    $createProductImage = $db->exec("CREATE TABLE product_images (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
    )");

    $db->commit();
//    header('location: index.php');
    echo "<h1>Done</h1>";

} catch (\Exception $e) {

    $db->rollBack();

    if ($e->getCode() == '42S01') {
//        header('location: index.php');
        echo "<h1>Done with code</h1>";
    }

    echo $e->getMessage();
}