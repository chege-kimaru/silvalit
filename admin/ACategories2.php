<?php
    require_once "bootstrap.php";
    $categories = getAllCategories();
?>
<!DOCTYPE html>
<html>
<head>
<title>Deloway</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>  
<body>
    <div class="container">
        <?php foreach ($categories as $category): ?>
      <div class="col-sm-3">
        <div class="panel panel-info">
            <div class="panel-heading"><?php print $category['name']; ?></div>
            <div class="panel-body">
                <p>Category Description</p>
            </div>
            <div class="panel-footer">
                <a href="ACategoryEdit.php?category_id=<?php print $category['id']; ?>"><button class="btn btn-warning">Edit</button></a>
                <a href="ACategory2.php?category_id=<?php print $category['id']; ?>"><button class="btn btn-warning">Products</button></a>
            </div>
        </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>