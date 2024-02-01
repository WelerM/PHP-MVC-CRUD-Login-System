<div class="bg-dark vh-100 " style="margin-top:100px">

    <div class="welcome-container bg-dark w-100">

        <form class=" p-4 text-light position-absolute " style="width:400px;top:50%;left:50%;transform: translate(-50%, -50%)" action="?a=signin" method="POST">

        <?php
            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];

                unset($_SESSION['error']);
            }
        
        ?>

            <p class="text-center fs-2 mb-4">Login</p>

            <div class="mb-3">
                <label for="login-email" class="form-label">Email address</label>

                <input type="email" name="login-email"  class="form-control bg-dark text-light" id="login-email" 
                value="email@test.com"
                aria-describedby="emailHelp">

                
            </div>

            <div class="mb-3">

                <label for="login-password" class="form-label">Password</label>

                <input type="password" name="login-password" class="form-control  bg-transparent text-light" id="login-password">

            </div>

            <button type="submit" class="btn btn-success">Login</button>

        </form>

    </div>


</div>