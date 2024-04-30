<?php 
$order = new AdminOrdersController();
?>
<div class="container mt-4">
    <h1 class="text-center my-5">Orders Number <?php echo htmlspecialchars($_GET['order_id']); ?></h1>
    <table class="table">
        <thead>
            <tr>
                <th class='text-center'>Product name</th>
                <th class='text-center'>Price</th>
                <th class='text-center'>Quantity</th>
                <th class='text-center'>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) : ?>
                <?php 
                    $product_item = $order->getProduct($item['product_id']); 
                    ?>
                <tr>
                    <td class='text-center'><?php echo htmlspecialchars($product_item[0]['name']); ?></td>
                    <td class='text-center'><?php echo htmlspecialchars($product_item[0]['price']); ?></td>
                    <td class='text-center'><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td class='text-center'>
                        <img src="<?php echo htmlspecialchars($product_item[0]['image']); ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
