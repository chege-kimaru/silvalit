<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <h1 class="text-center text-success">Add Category</h1>
    <div class="container">
        <form role="form" action="<?php echo htmlspecialchars('procedures/add_category.php'); ?>"   method="post" class="col-sm-6">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="color">Category color:</label>
            <input type="text" class="form-control" id="color" name="color">
          </div>
          <div class="form-group">
            <label for="icon">Category icon:</label>
            <input type="text" class="form-control" id="icon" name="icon">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</body>
</html>