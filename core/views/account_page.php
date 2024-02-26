<div class="container d-flex flex-column justify-content-center align-items-center vh-100 ">

    <div class="col-6  h-100 ">

        <div class="row d-flex flex-column w-100 mb-4">

            <p class="fs-2">My account</p>

            <img class="w-50 mb-3" id="" src="assets/images/top/id_1_top_1708626416327.png" alt="">
          
            <p class="fs-4"><?php echo $data[0]->user_name; ?></p>
            <p class="fs-4"><?php echo $data[0]->user_email; ?></p>
            <p class="fs-4"><?php echo $data[0]->user_country; ?></p>
            <p class="fs-4"><?php echo $data[0]->user_city; ?></p>
            <p class="fs-4"><?php echo $data[0]->created_at; ?></p>

        </div>
    </div>



</div>