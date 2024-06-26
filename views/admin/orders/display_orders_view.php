<?php if (count($orders) == 0): ?>
    <h3 class="text-center mt-5">There are no orders yet!</h3>
<?php else: ?>
    <div class="container mt-4">
        <h1 class="text-center mb-5">Orders</h1>
        <table class="table">
            <thead>
                <tr>
                    <th class='text-center'>ID</th>
                    <th class='text-center'>Date</th>
                    <th class='text-center'>User</th>
                    <th class='text-center'>Room</th>
                    <th class='text-center'>Total Price</th>
                    <th class='text-center'>Status</th>
                    <th class='text-center'>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td class='text-center'><?php echo $order['id']; ?></td>
                        <td class='text-center'><?php echo $order['created_date']; ?></td>
                        <td class='text-center'><?php echo $order['user_email']; ?></td>
                        <td class='text-center'><?php echo $order['room']; ?></td>
                        <td class='text-center'><?php echo $order['total_price']; ?></td>
                        <td class='text-center'><?php echo $order['status']; ?></td>
                        <td class='text-center'>
                            <a rel="tooltip" class="btn btn-info btn-just-icon btn-sm" data-original-title="" title="" href="?view=admin-orders&action=details&order_id=<?= $order['id'] ?>">
                                <i class="material-icons">visibility</i>
                            </a>

                            <?php if ($order['status'] == 'Processing') : ?>
                                <a rel='tooltip' class='btn btn-danger btn-just-icon btn-sm' data-original-title='' title='' href='?view=admin-orders&action=delete&order_id=<?php echo $order["id"]; ?>'>
                                    <i class='material-icons'>cancel</i>
                                </a>
                                <a rel='tooltip' class='btn btn-success btn-just-icon btn-sm' data-original-title='' title='' href="?view=admin-orders&action=edit&order_id=<?= $order['id'] ?>&status=Done">
                                    <i class='material-icons'>done</i>
                                </a>
                                <a rel='tooltip' class='btn btn-dark btn-just-icon btn-sm' data-original-title='' title='' href='?view=admin-orders&action=edit&order_id=<?php echo $order["id"]; ?>&status=Out for delivery'>
                                    <i class='material-icons'>local_shipping</i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<style>
    small {
        font-size: 75% !important;
        color: #777;
    }

    .btn-group {
        position: relative;
        margin: 10px 1px;
        display: inline-flex;
        vertical-align: middle;
    }

    .btn-group .btn {
        padding: 6.5px 20px !important;
    }

    .btn.btn-round {
        border-radius: 30px !important;
    }

    .btn-group .btn.btn-round {
        border-radius: 30px !important;
    }

    .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .btn-group>.btn:not(:first-child) {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .btn {
        padding: 12px 30px !important;
        margin: 5px 1px;
        font-size: 12px !important;
        box-shadow: 0 2px 2px 0 hsla(0, 0%, 60%, .14), 0 3px 1px -2px hsla(0, 0%, 60%, .2), 0 1px 5px 0 hsla(0, 0%, 60%, .12);
    }

    .btn .material-icons {
        position: relative;
        display: inline-block;
        top: 0;
        margin-top: -1.2em;
        margin-bottom: -1em;
        font-size: 1.1rem;
        vertical-align: middle;
    }

    .btn.btn-sm {
        border-radius: 3px !important;
    }

    .btn.btn-just-icon.btn-sm {
        height: 30px;
        min-width: 30px;
        width: 30px;
    }

    .btn.btn-just-icon {
        font-size: 24px;
        height: 41px;
        min-width: 41px;
        width: 41px;
        padding: 0 !important;
        overflow: hidden;
        position: relative;
        line-height: 41px;
    }

    .btn.btn-just-icon.btn-round {
        border-radius: 50% !important;
    }

    .btn.btn-link {
        background: transparent;
        box-shadow: none;
        color: #999;
    }

    .btn.btn-info {
        color: #fff !important;
        background-color: #00bcd4 !important;
        border-color: #00bcd4;
        box-shadow: 0 2px 2px 0 rgba(0, 188, 212, .14),
            0 3px 1px -2px rgba(0, 188, 212, .2),
            0 1px 5px 0 rgba(0, 188, 212, .12) !important;
    }

    .btn.btn-info:hover {
        box-shadow: 0 14px 26px -12px rgba(0, 188, 212, .42),
            0 4px 23px 0 rgba(0, 0, 0, .12),
            0 8px 10px -5px rgba(0, 188, 212, .2) !important;
        background: #00aec5 !important;
    }

    .btn.btn-info.btn-link {
        background-color: transparent !important;
        color: #00bcd4 !important;
        box-shadow: none !important;
    }

    .btn.btn-success {
        color: #fff !important;
        background-color: #4caf50 !important;
        border-color: #4caf50;
        box-shadow: 0 2px 2px 0 rgba(76, 175, 80, .14),
            0 3px 1px -2px rgba(76, 175, 80, .2),
            0 1px 5px 0 rgba(76, 175, 80, .12) !important;
    }

    .btn.btn-success:hover {
        box-shadow: 0 14px 26px -12px rgba(76, 175, 80, .42),
            0 4px 23px 0 rgba(0, 0, 0, .12),
            0 8px 10px -5px rgba(76, 175, 80, .2) !important;
        background: #47a44b !important;
    }

    .btn.btn-success.btn-link {
        background-color: transparent !important;
        color: #4caf50 !important;
        box-shadow: none !important;
    }

    .btn.btn-danger {
        color: #fff !important;
        background-color: #f44336 !important;
        border-color: #f44336;
        box-shadow: 0 2px 2px 0 rgba(244, 67, 54, .14),
            0 3px 1px -2px rgba(244, 67, 54, .2),
            0 1px 5px 0 rgba(244, 67, 54, .12) !important;
    }

    .btn.btn-danger:hover {
        box-shadow: 0 14px 26px -12px rgba(244, 67, 54, .42),
            0 4px 23px 0 rgba(0, 0, 0, .12),
            0 8px 10px -5px rgba(244, 67, 54, .2) !important;
        background-color: #f33527 !important;

    }

    .btn.btn-danger.btn-link {
        background-color: transparent !important;
        color: #f44336 !important;
        box-shadow: none !important;
    }

    .btn.btn-just-icon .material-icons {
        margin-top: 0;
        position: absolute;
        width: 100%;
        transform: none;
        left: 0;
        top: 0;
        height: 100%;
        line-height: 41px;
        font-size: 20px;
    }

    .btn.btn-just-icon.btn-sm .material-icons {
        font-size: 17px;
        line-height: 29px;
    }
</style>