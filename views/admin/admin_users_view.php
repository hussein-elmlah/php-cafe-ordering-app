<div class="container mt-4">
    <a href="?view=admin-users&action=add" class="btn btn-primary">Add a user</a> <br />
    <h1>Admin Users</h1>
    
    <?php if (isset($_SESSION['msg'])) {
            echo '<div class="alert alert-success" role="alert" id="success_message">' .
                $_SESSION['msg']
                . '</div>';
                
            if (isset($_SESSION['old_data'])) {
                unset($_SESSION['old_data']);
            }
        }

        echo '<script>
            setTimeout(() => {
                document.getElementById("success_message").style.display = "none";
            }, 2000);
            </script>';
        unset($_SESSION['msg']);
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Room</th>
                <th>Ext</th>
                <th>Profile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adminUsers as $user) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['room']; ?></td>
                    <td><?php echo $user['ext']; ?></td>
                    <td> <img src="<?php echo "data:image/jpeg;base64," . base64_encode($user['profile']) ?>" width="100" height="70" /></td>
                    <td>
                        <a href="?view=admin-users&action=edit&user_id=<?= $user['id'] ?>" class="btn btn-primary">Edit</a>
                        <a href="?view=admin-users&action=delete&user_id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>