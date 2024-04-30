<div class="admin-panel__content">

    <div class="row">
    
    <form class="row g-3" action="?view=login&action=validate" method="post" enctype="multipart/form-data">
        
    <?php if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger" role="alert" id="error_message">' .
            $_SESSION['error']
            . '</div>';
        }

        echo '<script>
                setTimeout(() => {
                    document.getElementById("error_message").style.display = "none";
                }, 2000);
            </script>';
        unset($_SESSION['error']);
    ?>
    
            
            <div class="col-md-8">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" value="<?php echo @$_SESSION['old_email']; ?>" name="email" id="inputEmail4">
            </div>
            <div class="col-md-8">
                <label for="inputEmail4" class="form-label">Password</label>
                <input type="password" class="form-control" value="<?php echo @$_SESSION['old_password']; ?>" name="password" id="inputEmail4">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

    </div>

</div>