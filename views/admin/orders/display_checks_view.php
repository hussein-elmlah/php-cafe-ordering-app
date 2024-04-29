<div class="container mt-4">
    <div class="d-flex justify-content-around">
        <div class="mb-5">
            <label>From: </label>
            <input type="date" id="date_from" name="date_from">
        </div>
        <div class="mb-5">
            <label>To: </label>
            <input type="date" id="date_to" name="date_to">
        </div>
    </div>
    <a id="checkLink" href="#" class="btn btn-success w-25">Check</a>
    <div class="dropdown-center my-5 ">
        <h4>Select User to See his Orders</h4>
        <button class="btn btn-secondary w-25 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Select User
        </button>
        <ul class="dropdown-menu dropdown-menu w-50 text-center">
            <?php
            foreach ($users as $user) :
            ?>
                <li><a class="dropdown-item" href="?view=admin-checks&user_email=<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if (count($users) > 0) : ?>
        <div>
            <h1 class="text-center mb-5">Users</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th class='text-center'>User</th>
                        <th class='text-center'>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders_users as $order) : ?>
                        <tr>
                            <td class='text-center'><?php echo $order['user_email']; ?></td>
                            <td class='text-center'><?php echo $order['total_price']; ?></td>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
    <?php if (count($orders) > 0) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th class='text-center'>Date</th>
                    <th class='text-center'>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td class='text-center'><?php echo $order['created_date']; ?></td>
                        <td class='text-center'><?php echo $order['total_price']; ?></td>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>
<?php else : ?>
    <h1 class="text-center my-5">There is no Orders!</h1>
<?php endif ?>
<style>
    [type="date"] {
        background: #fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png) 97% 50% no-repeat;
    }

    [type="date"]::-webkit-inner-spin-button {
        display: none;
    }

    [type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0;
    }


    label {
        display: block;
    }

    input {
        border: 1px solid #c4c4c4;
        border-radius: 5px;
        background-color: #fff;
        padding: 3px 5px;
        box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
        width: 190px;
    }
</style>

<script>
    // Get the input elements
    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');
    const checkLink = document.getElementById('checkLink');

    function constructUrl() {
        let url = '?view=admin-checks';
        const dateFromValue = dateFromInput.value;
        const dateToValue = dateToInput.value;

        if (dateFromValue) {
            url += `&date_from=${dateFromValue}`;
        }
        if (dateToValue) {
            url += `&date_to=${dateToValue}`;
        }

        return url;
    }

    function updateCheckLinkUrl() {
        const url = constructUrl();
        checkLink.href = url;
    }

    dateFromInput.addEventListener('change', updateCheckLinkUrl);
    dateToInput.addEventListener('change', updateCheckLinkUrl);
</script>