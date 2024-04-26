<div class="container mt-4">
    <a href="admin-users&action=add" class="btn btn-primary">Add a user</a> <br />
    <h1>Admin Users</h1>
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
                        <a href="admin-users&action=edit&user_id=<?= $user['id'] ?>" class="btn btn-primary">Edit</a>
                        <a href="admin-users&action=delete&user_id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>