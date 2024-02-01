<nav class="navbar navbar-expand-lg bg-transparent border-bottom border-dark border-1">

    <div class="container-fluid  ">

        <a class="navbar-brand text-light" href="?a=home">Look Builder</a>


        <button class="navbar-toggler  bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-light bg-light"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent" style="flex-grow: 0;">

            <ul class="navbar-nav  mb-2 mb-lg-0 border-0  me-3">

                <li class="nav-item ">
                    <a class="nav-link active text-light" aria-current="page" href="?a=home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-light" href="?a=signin_page">Sign In</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-light" href="?a=signup_page">Sign Up</a>
                </li>


                <?php
                if (isset($_SESSION['adm'])) {
                    echo '  <li class="nav-item">
                                 <a class="nav-link text-light" href="?a=signout">Logout</a>
                            </li>';
                }
                ?>


            </ul>


            <?php
            if (isset($_SESSION['adm'])) {
                echo '<form class="d-flex " role="search">
                            <input class="form-control me-2 bg-black border-dark " type="search" placeholder="" aria-label="Search">
                            <button class="btn btn-success" type="submit">Search</button>
                          </form>';
            }
            ?>


        </div>

    </div>
</nav>