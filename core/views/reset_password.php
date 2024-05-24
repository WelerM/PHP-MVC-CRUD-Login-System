<?php
    if (!isset($data)) {
        $data = $_GET['token'];
    }
?>

<div class=" vh-100 " style="margin-top:100px">
    ]
    <form action="?a=reset_password" method="POST" class="mx-auto" style="max-width: 400px;">

        <p class="text-center text-success  fs-2 mb-4">Redefine password</p>

        <?php if (isset($_SESSION['error'])) :  ?>

            <div class='alert alert-danger text-center'>
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']) ?>
            </div>

        <?php endif; ?>

      
        <div class="mb-2">
            <label for="password" class="form-label">New password</label>
            <input id="password" class="form-control" type="password" name="password">
        </div>

        <div class="mb-3">
            <label for="repeat-password" class="form-label">Repeat password</label>
            <input id="repeat-password" class="form-control" type="password" name="repeat-password">
        </div>

        <!-- Hidden -->

        <div class="mb-3">
            <input  class="d-none form-control" type="text" name="token" value="<?php echo $data; ?>">
        </div>

        <button type="submit" class="btn btn-success">Redefine password</button>

    </form>
</div>