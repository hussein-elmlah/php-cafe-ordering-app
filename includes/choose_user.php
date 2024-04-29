<h3>Add to user</h3>

<form method="post">
    <select class="form-control w-50 my-4" name="user_selected" onchange="this.form.submit()">
        <option value="">Choose User...</option>
        <?php foreach ($users as $user) : ?>
            <?php if ($user['id'] == $_SESSION['user_selected_id']) : ?>
                <option value="<?php echo $user['id']; ?>" selected><?php echo $user['name']; ?></option>
            <?php else : ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</form>
