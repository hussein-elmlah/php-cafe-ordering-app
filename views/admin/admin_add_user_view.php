<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Soft Masr - Project">
    <meta name="author" content="Ahmed ElShahat">
    <title>Admin </title>

    <!-- Favico -->
    <link rel="icon" type="image/png" href="./assets/images/admin.png">

    <!-- FontAwesome -->
    <link href="./assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style -->
    <link href="./assets/css/style.css" rel="stylesheet">

    <style>
        body,
        .col-md-8,
        .col-md-12,
        .row,
        .section-header,
        .admin-panel__content {
            background-color: white;
        }
    </style>
</head>

<body>

    <div class="admin-panel__content">

        <div class="row">
            <div class="col-md-12">
                <div class="section-header">
                    <h1>Add User</h1>
                </div>


            </div>
            <div class="col-md-8">
                <form class="form-horizontal" action="add-product.php" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="product-title" class="col-sm-3 control-label">User Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" id="product-title" value="<?= @$_POST['title'] ?>" placeholder="Product Title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product-title" class="col-sm-3 control-label">User Email</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" id="product-title" value="<?= @$_POST['title'] ?>" placeholder="Product Title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product-title" class="col-sm-3 control-label">User Password</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" id="product-title" value="<?= @$_POST['title'] ?>" placeholder="Product Title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product-price" class="col-sm-3 control-label">User Password Confirmation</label>
                        <div class="col-sm-9">
                            <input type="text" name="price" class="form-control" id="product-price" value="<?= @$_POST['price'] ?>" placeholder="Product Price">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product-availability" class="col-sm-3 control-label">User Room</label>
                        <div class="col-sm-9">
                            <select name="available" class="form-control" id="product-availability">
                                <!-- <option disabled selected> -- Select -- </option> -->
                                <option value="Available" selected>Available</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product-title" class="col-sm-3 control-label">User Ext</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" id="product-title" value="<?= @$_POST['title'] ?>" placeholder="Product Title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product-image" class="col-sm-3 control-label">User Profile Image</label>
                        <div class="col-sm-9">
                            <input type="file" name="imageProd" class="form-control" id="product-image">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" name="addprod" class="btn btn-success"><i class="fa fa-plus"></i> Add User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./assets/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./assets/js/bootstrap.min.js"></script>
</body>

</html>