<?php

use core\classes\Functions;

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">

    <div class="container-fluid  ">

        <a class="navbar-brand text-success fw-bold" href="?a=home"><?= APP_NAME?></a>


        <button class="navbar-toggler  " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon  bg-light"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent" style="flex-grow: 0;">


            <ul class="navbar-nav  mb-2 mb-lg-0 border-0  me-3">


                <?php if (!Functions::user_logged()) : ?>

                    <li class="nav-item text-center mb-2">
                        <a class="nav-link active" href="?a=signin_page">Sign In</a>
                    </li>

                    <li class="nav-item text-center">
                        <a class="nav-link active " href="?a=signup_page">Sign Up</a>
                    </li>

                <?php endif; ?>

            </ul>


            <?php if (Functions::user_logged()) : ?>
                <!-- User button -->
               
                <button class="btn-user btn " type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">

                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="GREY" class="bi bi-person-circle me-1" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg>

                    <?= $_SESSION['user_name'] ?>

                </button>



                <ul class="custom-ul flex-column mb-2 mb-lg-0 border-0  me-3">

                    <li class="nav-item">
                        <a class="nav-link text-center mb-2 " href="?a=account_page">Account</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-center " href="?a=signout">LogOut</a>
                    </li>

                </ul>


            <?php endif; ?>


        </div>

    </div>
</nav>


<div class="offcanvas offcanvas-end  " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">

    <div class="offcanvas-header d-flex justify-content-start">

        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="grey" class="bi bi-person-circle me-2" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
        </svg>

        <?php if (Functions::user_logged()) : ?>
            <?= $_SESSION['user_name'] ?>
        <?php endif; ?>

    </div>

    <div class="offcanvas-body">

        <?php if (Functions::user_logged()) : ?>


            <li class="nav-item mb-2">
                <a class="nav-link " href="?a=account_page">Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="?a=signout">Logout</a>
            </li>



        <?php else : ?>

            <li class="nav-item">
                <a class="nav-link " href="?a=signin_page">Sign In</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="?a=signup_page">Sign Up</a>
            </li>

        <?php endif; ?>
    </div>
</div>