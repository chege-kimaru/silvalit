<?php
    require_once "bootstrap.php";
    $categories = getAllCategories();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center text-success">Add Product</h1>
    <div class="container">
        <form role="form" enctype="multipart/form-data" action="<?php echo htmlspecialchars('procedures/add_product.php'); ?>"   method="post" class="col-sm-6">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
              <label for="category">Category:</label>
              <select class="form-control" id="category" name="category_id">
                <?php foreach ($categories as $cat): ?>
                  <option value="<?php print $cat['id'] ?>"><?php print $cat['name'] ?></option>
                <?php endforeach; ?>
              </select>
          </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea class="form-control" rows="5" id="description" name="description"></textarea>
        </div>
          <div class="form-group">
            <label for="brand">Brand:</label>
            <input type="text" class="form-control" id="brand" name="brand">
          </div>
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price">
          </div>
            <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="img">
          </div>
            <div class="checkbox">
              <label><input type="checkbox" value="1" name="new_arrival">New Arrival</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="1" name="new_product">New Product</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="1" name="best_seller">Best Seller</label>
            </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</body>
</html>