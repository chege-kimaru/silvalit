<?php
    require_once "bootstrap.php";
    if(!$_GET['category_id']) {
        echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
        exit;
    }
    $category = findCategoryById($_GET['category_id']);
    if(!$category) {
        echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center text-success">Edit Category</h1>
    <div class="container">
        <form role="form" action="<?php echo htmlspecialchars('procedures/edit_category.php'); ?>"   method="post" class="col-sm-6">
        <div class="form-group">
            <input type="hidden" class="form-control" id="id" name="id" value="<?php print $category['id']; ?>">
          </div>
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php print $category['name']; ?>">
          </div>
          <div class="form-group">
            <label for="color">Category color:</label>
            <input type="text" class="form-control" id="color" name="color" value="<?php print $category['color']; ?>">
          </div>
          <div class="form-group">
            <label for="icon">Category icon:</label>
            <input type="text" class="form-control" id="icon" name="icon" <?php print $category['icon']; ?>>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</body>
</html>