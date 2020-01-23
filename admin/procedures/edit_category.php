<?php
require_once '../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
//    $session->getFlashBag()->add('error', 'Sorry, access to the page you tried to visit is denied. Or is currently not available!');
//    header('location: index.php');
    echo "<h1 style='color: red'>ACCESS DENIED</h1>";
    exit;
}

$name = $_POST['name'];
$color = $_POST['color'];
$icon = $_POST['icon'];
$id = $_POST['id'];
if(!$name) {
//    $session->getFlashBag()->add('error', 'Please fill all the required fields');
//    header('location: campus_form.php');
    echo "<h1 style='color: brown'>Name of category is required.</h1>";
    exit;
}

try {
    updateCategory($id, $name, $color, $icon);
    echo "<h1 style='color: green'>Successfully updated category.</h1>";
    exit;
//    $session->getFlashBag()->add('success', 'Successfully added new campus.');
//    header('location: campus_form.php');
} catch (\Exception $e) {
//    $session->getFlashBag()->add('error', "OOps, an error occurred while adding campus. {$e->getMessage()} Please try again or consult admin.");
//    header('location: campus_form.php');
    echo "<h1 style='color: red'>".$e->getMessage()."</h1>";
    exit;
}