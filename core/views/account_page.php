<div class="container d-flex flex-column justify-content-center align-items-center vh-100 ">

    <div class="col-6  h-100 ">

        <div class="row d-flex flex-column w-100 mb-4">

            <p class="fs-2">My account</p>

   
          
            <p class="fs-4"> <span class="fw-bold">ID: </span> <?php echo  $data[0]->id; ?></p>
            <p class="fs-4"> <span class="fw-bold">NAME: </span> <?php echo $data[0]->user_name; ?></p>
            <p class="fs-4"><span class="fw-bold">EMAIL: </span> <?php echo  $data[0]->user_email; ?></p>
            <p class="fs-4"><span class="fw-bold">CREATED AT: : </span> <?php echo $data[0]->created_at; ?></p>


        </div>
    </div>



</div>