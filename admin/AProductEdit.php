<?php
    require_once "bootstrap.php";
    $categories = getAllCategories();
    if(!$_GET['product_id']) {
        echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
        exit;
    }
    $product = findProductById($_GET['product_id']);
    if(!$product) {
        echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center text-success">Edit Product</h1>
    <div class="container">
        <div><img src="<?php print "../".$product['image']; ?>" style="width: 100px; height: 100px;"/></div>
        <form role="form" enctype="multipart/form-data" action="<?php echo htmlspecialchars('procedures/edit_product.php'); ?>"   method="post" class="col-sm-6">
            <div class="form-group">
            <input type="hidden" class="form-control" id="id" name="id" value="<?php print $product['id']; ?>">
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php print $product['name']; ?>">
          </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" rows="5" id="description" name="description"><?php print $product['description']; ?></textarea>
        </div>
          <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" class="form-control" id="brand" name="brand" value="<?php print $product['brand']; ?>">
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php print $product['price']; ?>">
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="img">
          </div>
        <div class="checkbox">
            <?php if($product['new_arrival'] == '1' || $product['new_arrival'] == 1){ ?>
                <label><input type="checkbox" value="1" name="new_arrival" checked="checked">New Arrival</label>
            <?php } else { ?>
                <label><input type="checkbox" value="1" name="new_arrival">New Arrival</label>
            <?php } ?>
        </div>
        <div class="checkbox">
            <?php if($product['new_product'] == '1' || $product['new_product'] == 1){ ?>
                <label><input type="checkbox" value="1" name="new_product" checked="checked">New Product</label>
            <?php } else { ?>
                <label><input type="checkbox" value="1" name="new_product">New Product</label>
            <?php } ?>
        </div>
        <div class="checkbox">
            <?php if($product['best_seller'] == '1' || $product['best_seller'] == 1){ ?>
                <label><input type="checkbox" value="1" name="best_seller" checked="checked">Best Seller</label>
            <?php } else { ?>
                <label><input type="checkbox" value="1" name="best_seller">Best Seller</label>
            <?php } ?>
        </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</body>
</html>