<?php
    require_once "bootstrap.php";
    if(!$_GET['product_id']) {
        echo "<h1 style='color: brown'>404. NOT FOUND</h1>";
        exit;
    }
    $product_id = $_GET['product_id'];
    $product_images = getProductImages($product_id);
?>
<!--Add image -->
<?php 
    if(isset($_POST['add_image'])) {
        $img = $_FILES['img']['name'];
        $tmp = $_FILES['img']['tmp_name'];
        $type = $_FILES['img']['type'];

        if($img) {
            $dir = "../uploads/products/".$product_id."/images/";
            $path = "uploads/products/".$product_id."/images/".time().$img;
            $real_path = "../uploads/products/".$product_id."/images/".time().$img;
            mkdir($dir, 0777, true);
            if(move_uploaded_file($tmp, $real_path)) {
                try {
                    $stmt = $db->prepare("INSERT INTO product_images (image, product_id) VALUES(:image, :product_id)");
                    $stmt->bindParam(':image', $path);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->execute();
                    echo "<h4 style='color: green'>Successfully added image</h4>";
                } catch (\Exception $e) {
                    echo "<h4 style='color: red'>Error adding image to db".$e->getMessage()."</h4>";
                }
            } else {
                echo "<h4 style='color: red'>Error uploading image</h4>";
            }
        } else {
            echo "<h4 style='color: brown'>No image provided.</h4>";
        }
    }

    if(isset($_POST['delete_image'])) {
        $product_image = findProductImageById($_POST['image_id']);
        if ($product_image && file_exists("../".$product_image['image'])) {
            if(!$product_image['image']) {
                echo "<h1 style='color: brown'>Error deleting this image.</h1>";
            } else {
                try {
                    $stmt = $db->prepare("DELETE FROM product_images WHERE id=?");
                    $stmt->execute([$product_image['id']]);
                    echo "<h4 style='color: green'>Successfully deleted image</h4>";
                } catch (\Exception $e) {
                    echo "<h4 style='color: red'>Error deleting image from db".$e->getMessage()."</h4>";
                }
            }
        } else {
            echo "<h1 style='color: brown'>Current image unavailable</h1>";
        }
    }
?>

<!--Delete image -->

<!DOCTYPE html>
<html>
<head>
<title>Deloway</title>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>  
<body>
    <div class="container">
      <?php foreach ($product_images as $product_image): ?>
          <div class="col-sm-2">
            <div class="panel panel-info">
                <div class="panel-body">
                    <img src="<?php print "../".$product_image['image']; ?>" style="width: 100px; height: 100px;"/>
                </div>
                <div class="panel-footer">
                    <form method="post">
                        <input type="hidden" value="<?php print $product_image['id']; ?>" name="image_id"/>
                        <button class="btn btn-warning" type="submit" name="delete_image">Delete</button>
                    </form>
                </div>
            </div>
            </div>
        <?php endforeach; ?>
        <hr>
        <form role="form" enctype="multipart/form-data" method="post" class="col-sm-6">
            <h4>Add Image</h4>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="img">
            </div>
            <button type="submit" class="btn btn-default" name="add_image">Submit</button>
        </form>
    </div>
</div>
</body>
</html>