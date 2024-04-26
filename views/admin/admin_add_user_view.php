<div class="admin-panel__content">

    <div class="row">

        <form class="row g-3" action="?view=admin-users&action=create" method="post">
            <div class="col-md-4">
                <label for="inputAddress" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="inputAddress">
            </div>
            <div class="col-md-8">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="inputPassword4">
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label">Ext</label>
                <input type="text" class="form-control" name="ext" id="inputCity">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Room</label>
                <?php /* echo "<pre>"; var_dump($rooms) */ ?>
                <select id="inputState" name="room" class="form-select">
                <?php  if ($rooms){ foreach ($rooms as $room) {  ?>
                    <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                <?php  } }else{  ?>
                        <option>...NO ROOMS...</option>
                <?php  }  ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputZip" class="form-label">Profile</label>
                <input type="file" class="form-control" name="profile" id="inputZip">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>

    </div>

</div>