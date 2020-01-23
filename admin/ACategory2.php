<?php
    require_once "bootstrap.php";
    if(!$_GET['category_id']) {
        echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
        exit;
    }
    $products = getAllProductsInCategory($_GET['category_id']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Deloway</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>  
<body>
    <div class="container">
        <?php foreach ($products as $product): ?>
      <div class="col-sm-3">
        <div class="panel panel-info">
            <div class="panel-heading"><?php print $product['name']; ?></div>
            <div class="panel-body">
                <img src="<?php print "../".$product['image']; ?>" style="width: 100px; height: 100px;"/>
            </div>
            <div class="panel-body">
                <table>
                    <tr><td>Name: </td> <td><?php print $product['name']; ?></td></tr>
                    <tr><td>Brand: </td> <td><?php print $product['brand']; ?></td></tr>
                    <tr><td>Price: </td> <td><?php print $product['price']; ?></td></tr>
                    <tr><td>Description: </td> <td><?php print $product['description']; ?></td></tr>
                </table>
            </div>
            <div class="panel-footer">
                <a href="AProductImages.php?product_id=<?php print $product['id']; ?>"><button class="btn btn-success">Images</button></a>
                <a href="AProductEdit.php?product_id=<?php print $product['id']; ?>"><button class="btn btn-warning">Edit</button></a>
            </div>
        </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>