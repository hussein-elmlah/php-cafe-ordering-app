<div class="container mt-4">
    <h1>Orders Number <?php echo htmlspecialchars($_GET['id']); ?></h1>
    <table class="table">
        <thead>
            <tr>
                <th class='text-center'>Product name</th>
                <th class='text-center'>Price</th>
                <th class='text-center'>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td class='text-center'><?php echo htmlspecialchars($item['name']); ?></td>
                    <td class='text-center'><?php echo htmlspecialchars($item['price']); ?></td>
                    <td class='text-center'>
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
