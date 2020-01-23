<?php
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request() {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

function redirect($path, $extra = []) {
    $response = Response::create(null, Response::HTTP_FOUND, ['Location' => $path]);

    if(key_exists('cookies', $extra)) {
        foreach($extra['cookies'] as $cookie) {
            $response->headers->setCookie($cookie);
        }
    }

    $response->send();
    exit;
}

function redirect_base($path, $extra = []) {
    $response = Response::create(null, Response::HTTP_FOUND, ['Location' => '../../'.$path]);

    if(key_exists('cookies', $extra)) {
        foreach($extra['cookies'] as $cookie) {
            $response->headers->setCookie($cookie);
        }
    }

    $response->send();
    exit;
}

function redirect_base_2($path, $extra = []) {
    $response = Response::create(null, Response::HTTP_FOUND, ['Location' => '../../deloway/'.$path]);

    if(key_exists('cookies', $extra)) {
        foreach($extra['cookies'] as $cookie) {
            $response->headers->setCookie($cookie);
        }
    }

    $response->send();
    exit;
}

function display_alerts($level, $messages = []) {
    $response = '<div class="alert alert-'.$level.' alert-dismissable">';
    foreach($messages as $message ) {
        $response .= "{$message}<br>";
    }
    $response .= '</div>';

    return $response;
}

function display_errors($bag = 'error') {
    global $session;

    if(!$session->getFlashBag()->has($bag)) {
        return;
    }

    $messages = $session->getFlashBag()->get($bag);

    return display_alerts('danger', $messages);
}

function display_success($bag = 'success') {
    global $session;

    if(!$session->getFlashBag()->has($bag)) {
        return;
    }

    $messages = $session->getFlashBag()->get($bag);

    return display_alerts('success', $messages);
}

function createCategory($name, $color, $icon) {
    global $db;

    try {
        $stmt = $db->prepare("INSERT INTO categories (name, color, icon) VALUES (:name, :color, :icon)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':icon', $icon);
        $stmt->execute();
        return $db->lastInsertId();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function createProduct($name, $category_id, $price, $description, $brand, $image, $new_arrival, $new_product, $best_seller) {
    global $db;

    try {
        $stmt = $db->prepare("INSERT INTO products (name, category_id, price, description, brand, image, new_arrival, new_product, best_seller) VALUES (:name, :category_id, :price, :description, :brand, :image, :new_arrival, :new_product, :best_seller)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':new_arrival', $new_arrival);
        $stmt->bindParam(':new_product', $new_product);
        $stmt->bindParam(':best_seller', $best_seller);
        $stmt->execute();
        return $db->lastInsertId();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function getAllCategories() {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function getAllProductsInCategory($category_id) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function getNewArrivalProducts() {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM products WHERE new_arrival = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function getNewProducts() {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM products WHERE new_product = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function getBestSellerProducts() {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM products WHERE best_seller = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function findProductById($product_id) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT c.name AS category, p.id AS id, p.name AS name, p.category_id AS category_id, p.price AS price, p.description AS description, p.brand AS brand, p.image AS image, p.new_arrival AS new_arrival, p.new_product AS new_product, p.best_seller AS best_seller
        FROM products AS p
        LEFT JOIN categories AS c ON p.category_id = c.id
        WHERE p.id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function findCategoryById($category_id) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function updateCategory($id, $name, $color, $icon) {
    global $db;

    try {
        $stmt = $db->prepare("UPDATE categories SET name=:name, color=:color, icon=:icon WHERE id=:id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':icon', $icon);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $db->lastInsertId();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function updateProduct($id, $name, $price, $description, $brand, $new_arrival, $new_product, $best_seller) {
    global $db;

    try {
        $stmt = $db->prepare("UPDATE products SET name=:name, price=:price, description=:description, brand=:brand, new_arrival=:new_arrival, new_product=:new_product, best_seller=:best_seller WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':new_arrival', $new_arrival);
        $stmt->bindParam(':new_product', $new_product);
        $stmt->bindParam(':best_seller', $best_seller);
        $stmt->execute();
        return $db->lastInsertId();
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function searchProduct($term, $category_id) {
    $conn = new mysqli("localhost", "root", "kevinkimaru", "deloway");
    $terms = explode(" ", $term);
    if ($conn->connect_error) {
        die ("Oops connection Error: " . $conn->connect_error);
    }
    $query = "SELECT * FROM products WHERE category_id = $category_id ";
    $i = 0;
    foreach ($terms as $key) {
        $i++;
        if ($i == 1) {
            $query .= "AND (name LIKE '%$term%' ";
        }
        $query .= "OR brand LIKE '%$term%' ";
    }
    $query .= ");";
    $products = $conn->query($query);
    return $products;
}

function getProductImages($product_id) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM product_images WHERE product_id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}

function findProductImageById($product_image_id) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM product_images WHERE id = ?");
        $stmt->execute([$product_image_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch ( \Exception $e ) {
        throw $e;
    }
}
