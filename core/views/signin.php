<div class=" vh-100 " style="margin-top:100px">

    <div class="welcome-container  w-100">

        <form class="login-form p-4  d-flez flex-column position-absolute " style="width:400px;top:50%;left:50%;transform: translate(-50%, -50%)" action="?a=signin" method="POST">


            <p class="text-center text-success  fs-2 mb-4">Login</p>





            <!-- Email -->
            <div class="mb-3">

                <label for="login-email" class="form-label">Email address</label>

                <input required type="email" name="login-email" class="form-control" id="login-email" aria-describedby="emailHelp">


            </div>

            <!-- Password -->
            <div class="mb-3">

                <label for="login-password" class="form-label">Password</label>

                <input required type="password" name="login-password" class="form-control  bg-transparent " id="login-password">

            </div>


            <?php if (isset($_SESSION['error'])) :  ?>

                <div class='alert alert-danger text-center'>
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']) ?>
                </div>

            <?php endif; ?>

            <?php if (isset($_SESSION['success'])) :  ?>

                <div class='alert alert-success text-center'>
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']) ?>
                </div>

            <?php endif; ?>
            <div class="mb-3 ">
                <div class='d-none alert js-alert-error alert-danger text-center'></div>
                <a class="text-dark fs-6    " href="?a=send_recovery_email_page">Forgot your password?</a>
            </div>


            <button type="submit" class="btn btn-login btn-success">Login</button>

        </form>

    </div>


</div>