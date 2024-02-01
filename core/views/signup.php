<div class="bg-dark vh-100 " style="margin-top:100px">

    <div class="welcome-container bg-dark w-100">

        <form class=" p-4 text-light position-absolute " style="width:400px;top:50%;left:50%;transform: translate(-50%, -50%)" action="?a=signup" method="POST">



            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";

                unset($_SESSION['error']);
            }

            ?>
            <p class="text-center fs-2 mb-4">Create account</p>

            <div class="mb-3">
                <label for="signup-name" class="form-label">Name</label>

                <input value="weler" type="text" name="signup-name" class="form-control bg-dark text-light" id="signup-name" aria-describedby="emailHelp">
            </div>


            <div class="mb-3">
                <label for="signup-email" class="form-label">Email address</label>

                <input value="email@gmail.com" type="email" name="signup-email" class="form-control bg-dark text-light" id="signup-email" aria-describedby="emailHelp">

                <div class="form-text text-light">We'll never share your email with anyone else.</div>
            </div>


            <div class="mb-3">

                <label for="signup-password" class="form-label">Password</label>

                <input type="password" name="signup-password" class="form-control  bg-transparent text-light" id="signup-password">

            </div>

            <div class="mb-3">

                <label for="signup-repeat-password" class="form-label">Repeat password</label>

                <input type="password" name="signup-repeat-password" class="form-control  bg-transparent text-light" id="signup-repeat-password">

            </div>

            <button type="submit" class="btn btn-success">Create</button>

        </form>

    </div>


</div>