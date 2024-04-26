<div class="container mt-4">
    <h1>All Orders</h1>
    <button class="btn btn-success">Add Order</button>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>user</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $oreder['order_id']; ?></td>
                    <td><?php echo $order['created_date']; ?></td>
                    <td><?php echo $order['user_email']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
