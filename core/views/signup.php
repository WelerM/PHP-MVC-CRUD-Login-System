<div class=" " style="height:fit-content">

    <div class="welcome-container  w-100">

        <form class=" p-4 mx-auto mt-5" style="max-width:500px" action="?a=signup" method="POST">

            <p class="text-center text-success fs-2 mb-4">Create account</p>


            <!-- Name -->
            <div class="mb-3">
                <label for="signup-name" class="form-label">Name</label>

                <input id="signup-name" type="text" name="signup-name" class="form-control  " aria-describedby="emailHelp">
            </div>


            <!-- Email -->
            <div class="mb-3">
                <label for="signup-email" class="form-label">Email address</label>

                <input id="signup-email" type="email" name="signup-email" class="form-control" aria-describedby="emailHelp">

                <div class="form-text ">We'll never share your email with anyone else.</div>
            </div>


            <!-- Password -->
            <div class="mb-3">

                <label for="signup-password" class="form-label">Password</label>

                <input id="signup-password" type="password" name="signup-password" class="form-control   ">

            </div>


            <!-- Repeat Password -->
            <div class="mb-3">

                <label for="signup-repeat-password" class="form-label">Repeat password</label>

                <input id="signup-repeat-password" type="password" name="signup-repeat-password" class="form-control   ">

            </div>



            <!-- Select Country -->
            <select class="select-country form-select   mb-3" name="select-country" onchange="load_states_options()" aria-label="Default select example">

                <option selected>Select Country</option>

            </select>


            <!-- Select State -->
            <select disabled   class="select-state form-select   mb-3" name="select-state" onchange="load_cities_options()" aria-label="Default select example">

                <option selected >Select State</option>

            </select>


            <!-- Select City -->
            <select disabled class="select-city form-select   mb-3" name="select-city" aria-label="Default select example">

                <option selected>Select City</option>

            </select>


            <?php

            if (isset($_SESSION['error'])) {

                if ($_SESSION['error'] != 'none') {

                    echo "<div class='alert alert-danger mt-2'>" . $_SESSION['error'] . "</div>";
                } else {
                }

                unset($_SESSION['error']);
            }

            ?>


            <div class="js-alert-error d-none alert alert-danger"></div>

            <button disabled   type="submit" class="btn-register btn btn-success">Register</button>

        </form>

    </div>


</div>