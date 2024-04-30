<div class="d-flex my-5 mb-0">
        <div class="me-auto px-5">
        <label for=""  class="fs-4">Date From</label>
            <input placeholder="Date From" class="textbox-n w-100" type="date"  id="date_from" />
        </div>
        <div class="px-5">
            <label for="" class="fs-4">Date To</label>
            <input placeholder="Date To" class="textbox-n w-100" type="date"  id="date_to" />
        </div>
    </div>
    <div style="margin-left:90%;">
        <a id="checkLink" href="#" class="btn w-100 fw-bolder fs-5 " p-5 style="background-color:#34bc1c; color:white; left:100%">GO</a>
    </div>
    <div class="container">
        <?php  if(!isset($orders)):?>
<h1 class="text-center-my-5">You don't have any orders yet!</h1>
<?php else:?>
        <?php foreach ($orders as $order) : ?>
            <div class="card">
                <a href="?view=user-orders&action=details&order_id=<?php echo $order['id'].'&total_price='.$order['total_price'];?>">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1604135307399-86c6ce0aba8e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1374&q=80">
                    </div>
                </a>
                <div class="card-text"> 
                    <p class="card-meal-type">Date : <?php echo $order['created_date'] ?> </p>
                    <h2 class="card-title ">Status : <span class="fs-5 <?php echo ($order['status'] == 'Done') ? 'text-success' : (($order['status'] == 'Out for delivery') ? 'text-info' : 'text-warning'); ?>"><?php echo $order['status']; ?></span></h2>
                    <h2 class="card-title">Amount : <span class="fs-5"><?php echo $order['total_price']; ?> EGP</span></h2>
                </div>
                <?php if ($order['status'] == "Processing") : ?>
                    <a class=" card-price btn w-25 fs-5 text-center mb-0 " href='user-orders&action=delete&order_id=<?php echo $order["id"]; ?>' style="text-decoration:none; margin-top:15px;background-color:#970C0A;color: #fff;">Cancel</a>
                    <!--  <div class="card-price"><?php echo $order['total_price'] ?> EGP</div> -->
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <style>
        /*@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,900;1,400;1,900&display=swap');*/

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: url(https://images.unsplash.com/photo-1495195129352-aeb325a55b65?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1776&q=80);
            background-size: cover;
            background-position: right;
            background-attachment: fixed;
        }

        #header {
            margin: 20px;
        }

        #header>h1 {
            text-align: center;
            font-size: 3rem;
        }

        #header>p {
            text-align: center;
            font-size: 1.5rem;
            font-style: italic;
        }

        .container {
            width: 100vw;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 40px 20px;
        }

     
        [type="date"] {
            background: #fff url(https://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/calendar_2.png) 97% 50% no-repeat;
        }

        [type="date"]::-webkit-inner-spin-button {
            display: none;
        }

        [type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }

        input {
            border: 1px solid #c4c4c4;
            border-radius: 5px;
            background-color: #fff;
            padding: 3px 5px;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
            width: 190px;
        }

        .card {
            display: flex;
            flex-direction: column;
            width: 400px;
            margin-bottom: 30px;
            height: 400px;
        }

        .card>div {
            box-shadow: 0 15px 20px 0 rgba(0, 0, 0, 0.5);
        }

        .card-image {
            width: 400px;
            height: 200px;
        }

        .card-image>img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: bottom;
        }

        .card-text {
            margin: -30px auto;
            margin-bottom: -50px;
            height: 200px;
            width: 300px;
            background-color: #1D1C20;
            color: #fff;
            padding: 20px;
        }

        .card-meal-type {
            font-style: italic;
        }

        .card-title {
            font-size: 2.2rem;
            margin-bottom: 20px;
            margin-top: 5px;
        }

        .card-body {
            font-size: 1.25rem;
        }

        .card-price {
            width: 100px;
            height: 100px;
            background-color: #970C0A;
            color: #fff;
            margin-left: auto;
            font-size: 1.25rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <script>
        // Get the input elements
        const dateFromInput = document.getElementById('date_from');
        const dateToInput = document.getElementById('date_to');
        const checkLink = document.getElementById('checkLink');

        function constructUrl() {
            let url = 'user-orders&action=date';
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