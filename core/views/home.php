<?php

use core\classes\Functions;

?>





<div class=" main-container p-0 container-fluid bg-sucess  d-flex">

    <!-- Look display -->
    <div class="look-container w-100 border-2 d-flex p-3 pt-0 flex-column bg-body-tertiary" style="max-width:250px">

        <span class="py-2  text-center fw-bold  ">Your look</span>

        <!-- Displayed images will inside this div -->
        <div class="container-displayed-images d-flex flex-column"></div>

    </div>

    <!--     Look options -->
    <div class="border-2 w-100  d-flex flex-column justify-content-between p-0 position-relative ">

        <ul class=" p-0   d-flex align-items-center justify-content-between " style="list-style:none;">
            <li id="top" class=" w-100 px-0 py-2 m-0 text-center">top</li>
            <li id="torso" class=" w-100 px-0 p-0  py-2  m-0 text-center">torso</li>
            <li id="legs" class=" w-100 px-0 p-0  py-2 m-0 text-center">legs</li>
            <li id="feet" class=" w-100 px-0 p-0  py-2 m-0 text-center">feet</li>
        </ul>

        <!--Saved images container -->
        <div class="options-container h-100  position-relative ">

            <div id="test-animal" class="flex-wrap"></div>

        </div>


        <footer class="d-flex align-items-center justify-content-between  bg-body-tertiary border-top position-absolute  w-100 p-2" style="bottom:0">

            <div class="d-flex">
                <!-- Temperature display -->
                <div class="d-flex me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-thermometer" viewBox="0 0 16 16">
                        <path d="M8 14a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                        <path d="M8 0a2.5 2.5 0 0 0-2.5 2.5v7.55a3.5 3.5 0 1 0 5 0V2.5A2.5 2.5 0 0 0 8 0M6.5 2.5a1.5 1.5 0 1 1 3 0v7.987l.167.15a2.5 2.5 0 1 1-3.333 0l.166-.15z" />
                    </svg>
                    <span id="temperature-text" class="ms-1  fw-bold"></span>
                </div>

                <button class="btn-suggestion btn btn-success p-1 px-2 mx-1  d-flex align-items-center justify-content-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart me-1" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>
                    Suggestion</button>

                <button class="btn-add btn btn-success p-1 px-2 mx-1 d-flex align-items-center justify-content-center ">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg me-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                    </svg>
                    Add
                </button>




            </div>

            <form class="d-flex " role="search">
                <input class="input-search form-control me-2  border " type="search" aria-label="Search">
                <button class="btn-search btn btn-success">Search</button>
            </form>

        </footer>


    </div>

</div>





<!-- Button trigger modal -->
<button id="btn-launch-modal" type="button" class="d-none btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"></button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog">

        <div class="modal-content ">
            <div class="modal-body d-flex flex-column">

                <!-- img add container -->
                <div class="container-add-img d-flex flex-column">



                    <p class="d-none  text-center fw-bold"></p>


                    <!-- Img preview container -->
                    <img id="img-preview" class="d-none mb-2 mx-auto" src="" alt="">


                    <form id="img-form" class="flex-column px-0 mt-1 py-1  d-none" action="?a=save_image" enctype="multipart/form-data" method="POST">


                        <!-- Img input file HIDDEN-->
                        <div id="container-input-file" class=" d-none mb-4">


                            <label for="form-input" class="input-group-text d-flex align-items-center bg-transparent rounded-end-0 ">

                                Choose new image

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                </svg>

                            </label>

                            <input id="form-input" type="file" class=" custom-file-button form-control rounded-0 rounded-end-1 " name="file">


                        </div>


                        <!-- Img name input trigger SHOWN-->
                        <button class="btn btn-add-img d-flex align-items-center border mb-3">

                            Choose an image

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-image ms-2" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z" />
                            </svg>

                        </button>


                        <!-- Img name input-->
                        <div class="mb-3">

                            <label for="input-img-name" class="form-label fw-bold d-none"></label>

                            <input id="input-img-name" type="text" class="form-control" name="input-img-name" placeholder="Choose a name for this piece">

                        </div>



                        <!-- Input check seasons -->
                        <div class="border rounded p-0 mb-3">

                            <button class="btn d-flex align-items-center border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-seasons" aria-expanded="false" aria-controls="collapse-seasons">
                                Attribute seasons for this piece

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill ms-2" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                </svg>
                            </button>

                            <div class="collapse mt-2 px-2 pb-2" id="collapse-seasons">

                                <div class="d-flex justify-content-between mb-0" style="user-select: none;">

                                    <!-- Spring -->
                                    <div class="mb-0 form-check">
                                        <input type="checkbox" name="spring-check" class="form-check-input input-spring" id="spring-check">
                                        <label class="form-check-label " for="spring-check">Spring</label>
                                    </div>

                                    <!-- Summer -->
                                    <div class="mb-0 form-check">
                                        <input type="checkbox" name="summer-check" class="form-check-input input-summer" id="summer-check">
                                        <label class="form-check-label" for="summer-check">Summer</label>
                                    </div>

                                    <!-- Fall -->
                                    <div class="mb-0 form-check">
                                        <input type="checkbox" name="fall-check" class="form-check-input input-fall" id="fall-check">
                                        <label class="form-check-label" for="fall-check">Fall</label>
                                    </div>

                                    <!-- Winter -->
                                    <div class="mb-0 form-check">
                                        <input type="checkbox" name="winter-check" class="form-check-input input-winter" id="winter-check">
                                        <label class="form-check-label" for="winter-check">Winter</label>
                                    </div>

                                </div>

                            </div>


                        </div>


                        <!-- Min and Max temperature range inputs -->
                        <div class="border rounded p-2 mb-2 ">

                            <button class="btn d-flex align-items-center p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-temperature" aria-expanded="false" aria-controls="collapse-temperature">
                                Set an ideal temperature for this piece
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill ms-2" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                </svg>
                            </button>

                            <div class="collapse" id="collapse-temperature">

                                <label for="input-min-range" class="form-label form-label-min-temp mb-0">Min:</label>

                                <input id="input-min-range" class="form-range" name="input-min-range" min="0" max="30" type="range">



                                <label for="input-max-range" class="form-label form-label-max-temp mb-0">Max:</label>

                                <input id="input-max-range" class="form-range" name="input-max-range" max="50" type="range">

                            </div>



                        </div>


                        <!-- Handled by JAVASCRIPT -->
                        <input id="form-input-type" class="d-none" type="text" name="data-type">



                        <!-- Hidden input img id for UPDATES -->
                        <div class="d-none">
                            <label for="input-img-id" class="form-label d-none"></label>
                            <input id="input-img-id" class="form-control d-none" name="input-img-id" type="text">

                        </div>





                        <!-- Modal btns -->
                        <div class="modal-footer border-0 d-flex p-0 justify-content-between">

                            <button id="btn-form-submit" type="submit" name="submit" class="btn btn-success mx-0 d-flex align-items-center justify-content-center" style="width: fit-content;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-download me-1" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                </svg>
                                Save</button>
                            <button id="btn-form-close" type="button" class="btn btn-secondary mx-0 d-flex align-items-center justify-content-center" data-bs-dismiss="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg me-1" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                </svg>
                                Close</button>


                        </div>

                    </form>


                </div>



                <!-- img info container -->
                <div class="container-img-info  mb-3 flex-column">

                    <p id="img-info-title" class=" fw-bold fs-5"></p>

                    <div class="d-flex">

                        <p class="mb-2">Recommended seasons:</p>

                        <!-- Seasons span container -->
                        <div id="img-info-list-season" class="d-flex  p-0 mb-3 border-0" style="list-style:none;"></div>

                    </div>

                    <div class="d-flex">

                        <p class="mb-2">Recommended temperature:</p>

                        <div id="img-info-list-temp" class=" p-0 mb-3 border-0 d-flex" style="list-style:none;"></div>
                    </div>

                </div>

                <p class="d-none error-msg-text "></p>



                <!-- Img suggestion container -->
                <div class="container-img-suggestion d-none flex-column"></div>


                <!-- Crud btns -->
                <div class="container-modal-btns d-none justify-content-between">

                    <div class="container-crud-btns d-flex">
                        <button id="btn-use" class="btn btn-success mx-1 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-left me-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z" />
                                <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                            </svg>
                            Use
                        </button>
                        <button id="btn-edit" class="btn btn-warning mx-1 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                            Edit

                        </button>
                        <button class="btn-remove btn btn-danger p-1 mx-1 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash me-1 " viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                            Remove
                        </button>
                    </div>

                    <button id="btn-close-form" type="button" class="btn btn-secondary   d-flex align-items-center justify-content-center" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg me-1" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                        </svg>
                        Close
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>