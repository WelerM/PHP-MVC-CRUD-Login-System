const layout = new Layout();

const [...listItems] = document.querySelectorAll('li');
const [...input_check_seasons] = document.querySelectorAll('.form-check-input')
const img_container = document.querySelector('#test-animal')

const alert_element = document.querySelector('.alert-danger')
const alert_text = document.querySelector('.alert-danger-text')

const form_1 = document.querySelector('#img-form')
const container_img_preview = document.querySelector('#img-preview')

const form_input_type = document.querySelector('#form-input-type')
const input_min_range = document.querySelector('#input-min-range')
const input_max_range = document.querySelector('#input-max-range')

const container_img_suggestion = document.querySelector('.container-img-suggestion')

var selected_img_to_use
var img_id
var is_spring_checked = false
var is_summer_checked = false
var is_fall_checked = false
var is_winter_checked = false
var is_all_seasons_checkd = false
var current_temperature = null
var min_temperature
var is_btn_edit_clicked = false














//Form's input range ( min temperature )
if (input_min_range) {

    input_min_range.addEventListener('input', () => {
        min_temperature = input_min_range.value


        document.querySelector('.form-label-min-temp').textContent = `Min: ${min_temperature}°C`

        input_max_range.setAttribute('min', min_temperature)
    })
}

//For when user drop the range pointer
if (input_min_range) {

    input_min_range.addEventListener('change', () => {

        document.querySelector('.form-label-max-temp').textContent = `Max: ${min_temperature}°C`
        input_max_range.setAttribute('min', min_temperature)
    })
}

//Form's input range ( max temperature )
if (input_max_range) {

    input_max_range.addEventListener('input', () => {
        document.querySelector('.form-label-max-temp').textContent = `Max: ${input_max_range.value}°C`
    })
}









//BODY PARTS MENU OPTIONS
listItems.map(li => {
    li.addEventListener('click', (e) => {

        //  Prevents users from navigating to another body part top menu
        // When they clicked in the btn "use" or "remove" and didn't finish the action 


        //Resets menu style
        let [...listItems] = document.querySelectorAll('li');
        listItems.map(li => {

            li.style.background = "transparent"
            li.style.color = "black"
        })

        //Sets choosen body part option to checked
        let li_top = document.querySelector('#' + e.target.textContent)

        li_top.style.background = 'rgb(201, 201, 201)'
        li_top.style.color = 'white'



        selected_img_to_use = e.target.textContent
        fetch_images(e.target.textContent);

    })
})

//BTN ADD IMG
if (document.querySelector('.btn-add')) {
    document.querySelector('.btn-add').addEventListener('click', () => {

        is_btn_edit_clicked = false;

        layout.btn_add_clicked()

        ///Checks which body part will be handled in PHP
        if (selected_img_to_use === 'top') {
            form_input_type.setAttribute('value', 'top')
        } else if (selected_img_to_use === 'torso') {
            form_input_type.setAttribute('value', 'torso')
        } else if (selected_img_to_use === 'legs') {
            form_input_type.setAttribute('value', 'legs')
        } else if (selected_img_to_use === 'feet') {
            form_input_type.setAttribute('value', 'feet')
        }

        //Opens system's file explorer
        document.querySelector('#form-input').click();
    })
}


//BTN ADD SUGGESTION
if (document.querySelector('.btn-suggestion')) {
    document.querySelector('.btn-suggestion').addEventListener('click', () => {


        if (current_temperature != null) {

            let temperature = Math.floor(current_temperature)

            axios.defaults.withCredentials = true;
            axios.get('?a=show_suggestion&data=' + temperature)
                .then(function (response) {

                    let data = response.data

                    let topArray = [];
                    let torsoArray = [];
                    let legsArray = [];
                    let feetArray = [];

                    data.forEach(object => {

                        switch (object.img_type) {
                            case 'top':
                                topArray.push(object);

                                break;
                            case 'torso':
                                torsoArray.push(object);
                                break;
                            case 'legs':
                                legsArray.push(object);
                                break;
                            case 'feet':
                                feetArray.push(object);
                                break;

                        }
                    });


                    // Function to randomly pick one index from an array
                    function getRandomIndex(array) {
                        return Math.floor(Math.random() * array.length);
                    }


                    // Randomly pick one index maximum from each array

                    let finalArray = [];

                    if (topArray.length > 0) {
                        finalArray.push(topArray[getRandomIndex(topArray)])
                    } else {
                        topArray.push({ img_type: 'top', img_src: 'assets/images/default.png' })
                        finalArray.push(topArray[0])
                    }

                    if (torsoArray.length > 0) {
                        finalArray.push(torsoArray[getRandomIndex(torsoArray)])
                    } else {
                        torsoArray.push({ img_type: 'torso', img_src: 'assets/images/default.png' })
                        finalArray.push(torsoArray[0])
                    }

                    if (legsArray.length > 0) {
                        finalArray.push(legsArray[getRandomIndex(legsArray)])
                    } else {
                        legsArray.push({ img_type: 'legs', img_src: 'assets/images/default.png' })
                        finalArray.push(legsArray[0])
                    }

                    if (feetArray.length > 0) {
                        finalArray.push(feetArray[getRandomIndex(feetArray)])
                    } else {
                        feetArray.push({ img_type: 'feet', img_src: 'assets/images/default.png' })
                        finalArray.push(feetArray[0])
                    }


                    //Delete olds results container_img_suggestion
                    while (container_img_suggestion.firstChild) {
                        container_img_suggestion.removeChild(container_img_suggestion.firstChild);
                    }


                    container_img_suggestion.innerHTML = `<p class='mb-2 fs-5 text-light'>New suggestion for:  ${temperature}°C</p>`

                    //Creates img suggestions inside "container_img_suggestion"
                    finalArray.map(i => {

                        if (i.img_type === 'top') {

                            let img_sugge_top = document.createElement('img')
                            img_sugge_top.setAttribute('src', i.img_src)
                            img_sugge_top.classList.add('img-suggestion', 'mb-1')
                            container_img_suggestion.appendChild(img_sugge_top)

                        } else if (i.img_type === 'torso') {

                            let img_sugge_torso = document.createElement('img')
                            img_sugge_torso.setAttribute('src', i.img_src)
                            img_sugge_torso.classList.add('img-suggestion', 'mb-1')
                            container_img_suggestion.appendChild(img_sugge_torso)

                        } else if (i.img_type === 'legs') {

                            let img_sugge_legs = document.createElement('img')
                            img_sugge_legs.setAttribute('src', i.img_src)
                            img_sugge_legs.classList.add('img-suggestion', 'mb-1')
                            container_img_suggestion.appendChild(img_sugge_legs)

                        } else if (i.img_type === 'feet') {

                            let img_sugge_feet = document.createElement('img')
                            img_sugge_feet.setAttribute('src', i.img_src)
                            img_sugge_feet.classList.add('img-suggestion', 'mb-2')
                            container_img_suggestion.appendChild(img_sugge_feet)
                        }
                    })


                    layout.btn_add_sugge_clicked()


                    //Launches modal
                    document.querySelector('#btn-launch-modal').click();
                })

        } else {
            console.log('error');
        }



    })
}


//BTN USE IMG
if (document.querySelector('#btn-use')) {
    document.querySelector('#btn-use').addEventListener('click', () => {



        //Displays choosen image on "using" display
        axios.defaults.withCredentials = true;
        axios.get('?a=use_image&id=' + img_id + '&name=' + selected_img_to_use)
            .then(function (response) {
                //Updates images currently displayed on the "wearing container"
                update_displayed_images()

            })

        //Deletes imgs from gallery container
        while (img_container.firstChild) {
            img_container.removeChild(img_container.firstChild);
        }

        //Updates imgs from gallery container
        setTimeout(() => {
            fetch_images(selected_img_to_use)
        }, 100);


        //Closes img info form
        document.querySelector('#btn-close-form').click();
    })

}



/* BTN REMOVE IMG*/
if (document.querySelector('.btn-remove')) {

    document.querySelector('.btn-remove').addEventListener('click', () => {

        Swal.fire({
            title: 'Are you sure you want to delete this image?',
            text: '',
            icon: 'warning',
            confirmButtonText: 'Delete',
            confirmButtonColor: '#dc3545',
            showCancelButton: true,
            cancelButtonColor: "#6c757d",
        }).then((result) => {

            if (result.isConfirmed) {
                delete_image();
            }
        })


    })
}


/* BTN EDIT IMG*/
if (document.querySelector('#btn-edit')) {

    document.querySelector('#btn-edit').addEventListener('click', () => {

        is_btn_edit_clicked = true;


        layout.btn_edit_clicked();

        //Fill input fields with current img's information
        //Displays saved images
        axios.defaults.withCredentials = true;
        axios.get('?a=retrieve_image_info&data=' + img_id)
            .then(function (response) { })




        // add id da imagem no "input file" do formulario
        let hidden_input_img_id = document.querySelector('#input-img-id')
        hidden_input_img_id.setAttribute('value', img_id)

        //Adds image type to the form's input
        let hidden_input_img_type = document.querySelector('#form-input-type')
        hidden_input_img_type.setAttribute('value', selected_img_to_use)


        //Change form's "action" attribute to a php to edit data
        form_1.setAttribute('action', '?a=edit_image')
    })
}




//Handles input checks
input_check_seasons.map(input_check => {
    input_check.addEventListener('change', (e) => {

        if (e.target.checked) {

            if (e.target.id === "spring-check") {
                is_spring_checked = true

            } else if (e.target.id === "summer-check") {
                is_summer_checked = true

            } else if (e.target.id === "fall-check") {
                is_fall_checked = true

            } else if (e.target.id === "winter-check") {
                is_winter_checked = true
            } else if (e.target.id === 'all-seasons-check') {
                is_all_seasons_checkd = true

            }

        } else {
            if (e.target.id === "spring-check") {
                is_spring_checked = false

            } else if (e.target.id === "summer-check") {
                is_summer_checked = false

            } else if (e.target.id === "fall-check") {
                is_fall_checked = false

            } else if (e.target.id === "winter-check") {
                is_winter_checked = false
            } else if (e.target.id === 'all-seaons-check') {
                is_all_seasons_checkd = false

            }
        }

        //Hides warning text
        alert_element.classList.remove('d-flex')
        alert_element.classList.add('d-none')
    })
})

//Forms'  btn submit "save". Also closes off the modal windown
if (document.querySelector('#btn-form-submit')) {

    document.querySelector('#btn-form-submit').addEventListener('click', (e) => {

        if (!validate_form_input_checks()) {
            e.preventDefault();
        } else {
            //Form will be submitted
            document.querySelector('#btn-form-submit').textContent = "Saving..."
        }
    })
}

//Forms' btn "Close". Reloads the page
if (document.querySelector('#btn-form-close')) {

    document.querySelector('#btn-form-close').addEventListener('click', () => {
        location.reload();
    })
}

if (document.querySelector("#form-input")) {

    document.querySelector("#form-input").addEventListener('change', () => {
        let img_file = document.querySelector('#form-input')

        if ((img_file.files) && (img_file.files[0])) {

            var reader = new FileReader()

            reader.onload = function (e) {


                layout.show_img_preview(e.target.result)

                if (!is_btn_edit_clicked) {
                    document.querySelector('#btn-launch-modal').click();
                }
            }
            reader.readAsDataURL(img_file.files[0])
        }
    })
}





async function is_user_logged() {

    axios.defaults.withCredentials = true;
    axios.get('?a=is_user_logged')
        .then(function (response) {

            if (response.data === true) {

                return true

            } else {
                return false
            }

        })


}



function start() {

    //Checks in the URL to check if it has a "data" varible
    let queryParams = new URLSearchParams(window.location.search);
    if (queryParams.has('data')) {
        let dataValue = queryParams.get('data');

        //Starts the app with a custom body part
        selected_img_to_use = dataValue
        fetch_images(selected_img_to_use)


        //Marks choosen ul for user accessibility
        let custom_checked_li = document.querySelector('#' + dataValue)
        custom_checked_li.style.background = 'rgb(201, 201, 201)'

    } else {


        if (is_user_logged()) {

            //Starts the app with the "top" body part
            selected_img_to_use = 'top'
            fetch_images(selected_img_to_use)

        }

        //Marks choosen ul for user accessibility
        let custom_checked_li = document.querySelector('#top')
        if (custom_checked_li) {

            custom_checked_li.style.background = 'rgb(201, 201, 201)'
        }

    }


    //Checks for error messages in the URL
    if (queryParams.has('error')) {

        let error = queryParams.get('error');

        if (error != 'none') {


            layout.show_error_alert(error)

        }
    }

    update_displayed_images()

    // getWeather();

} start();




//Will be called on Forms btn "Save"
function validate_form_input_checks() {


    //Checks for all inputs empty
    if (!is_spring_checked && !is_summer_checked && !is_fall_checked && !is_winter_checked && !is_all_seasons_checkd) {

        //Shows warning alert
        alert_text.innerHTML = "Choose at leat one season for this piece"
        alert_element.classList.remove('d-none')
        alert_element.classList.add('d-flex')

        return false;
    }


    document.querySelector('#btn-form-submit').click();

    return true;

}



//"CRUD" ACTIONS
function update_displayed_images() {//Being callend on START() and USE_IMG();

    //Gets displayed images container
    let container_displayed_images = document.querySelector('.container-displayed-images')
    if (container_displayed_images) {


        //Checks if "container_displayed_images" has img child elements and delete them if they exist
        while (container_displayed_images.firstChild) {
            // Remove the first child until there are no more children
            container_displayed_images.removeChild(container_displayed_images.firstChild);
        }


        //Creates new images
        let top_displayed_img = document.createElement('img')
        top_displayed_img.setAttribute('src', 'assets/images/default.png')
        top_displayed_img.classList.add('img-teste', 'mb-1')

        let torso_displayed_img = document.createElement('img')
        torso_displayed_img.setAttribute('src', 'assets/images/default.png')
        torso_displayed_img.classList.add('img-teste', 'mb-1')

        let legs_displayed_img = document.createElement('img')
        legs_displayed_img.setAttribute('src', 'assets/images/default.png')
        legs_displayed_img.classList.add('img-teste', 'mb-1')

        let feet_displayed_img = document.createElement('img')
        feet_displayed_img.setAttribute('src', 'assets/images/default.png')
        feet_displayed_img.classList.add('img-teste')

        container_displayed_images.appendChild(top_displayed_img)
        container_displayed_images.appendChild(torso_displayed_img)
        container_displayed_images.appendChild(legs_displayed_img)
        container_displayed_images.appendChild(feet_displayed_img)



        //Gets all images that are set as "Displayed" on database
        if (is_user_logged()) {


            axios.defaults.withCredentials = true;
            axios.get('?a=show_wearing_parts')
                .then(function (response) {

                    let data = response.data

                    if (data) {

                        data.map(i => {

                            if (i.img_type === 'top') {
                                top_displayed_img.setAttribute('src', i.img_src)
                            }

                            if (i.img_type === 'torso') {
                                torso_displayed_img.setAttribute('src', i.img_src)
                            }

                            if (i.img_type === 'legs') {
                                legs_displayed_img.setAttribute('src', i.img_src)
                            }

                            if (i.img_type === 'feet') {


                                feet_displayed_img.setAttribute('src', i.img_src)

                            }

                        })

                    }
                })



        }



    }
}

function fetch_images(param) {

    selected_img_to_use = param

    //Displays saved images
    axios.defaults.withCredentials = true;
    axios.get('?a=display_img&data=' + param)
        .then(function (response) {

            let data = response.data

            //Removes old images from container
            if (img_container) {

                while (img_container.firstChild) {
                    img_container.removeChild(img_container.firstChild);
                }

            }


            if (data.length === 0) {//No results on database

                //  layout.show_error_alert("addnewimages")

            } else {


                //Creates list of saved images on container
                data.map(i => {

                    let img_element = document.createElement('img')

                    img_element.classList.add('img', 'shadow', 'border')
                    if (img_container) {

                        img_container.appendChild(img_element)
                    }

                    if (param === 'top') {

                        img_element.setAttribute('src', i.img_src)
                        img_element.setAttribute('id', i.id)
                        img_element.setAttribute('name', 'top')

                    } else if (param === 'torso') {

                        img_element.setAttribute('src', i.img_src)
                        img_element.setAttribute('id', i.id)
                        img_element.setAttribute('name', 'torso')

                    } else if (param === 'legs') {

                        img_element.setAttribute('src', i.img_src)
                        img_element.setAttribute('id', i.id)
                        img_element.setAttribute('name', 'legs')

                    } else if (param === 'feet') {

                        img_element.setAttribute('src', i.img_src)
                        img_element.setAttribute('id', i.id)
                        img_element.setAttribute('name', 'feet')

                    }

                    //Talvez colocar a seleção abaixo aqui dentro
                })
                //==========================================================




                //Attachs Event Listener to the nearly displayed images from gallery and
                //call "show_img__info()" function
                const [...gallery_imgs] = document.querySelectorAll('.img')
                gallery_imgs.map(img => {

                    img.addEventListener('click', (e) => {


                        show_image_info(e.target.id, param);
                        img_id = e.target.id

                    })
                })
            }



        })
}


function delete_image() {
    //Deletes imgs passing img unique id
    axios.defaults.withCredentials = true;
    axios.get('?a=delete_image&id=' + img_id + '&name=' + selected_img_to_use)
        .then(function (response) {

            //Updates images currently displayed on the "wearing container"
            update_displayed_images()
        })

    //Refresh img container
    while (img_container.firstChild) {
        img_container.removeChild(img_container.firstChild);
    }

    setTimeout(() => {
        fetch_images(selected_img_to_use)
    }, 100);


    //Closes img info form
    document.querySelector('#btn-close-form').click();
}



function show_image_info(img_id, body_part) {

    axios.defaults.withCredentials = true;
    axios.get('?a=show_img_info&data=' + img_id)
        .then(function (response) {

            let data = response.data;

            layout.show_img_info(data.img_src)


            //Shows image
            if (body_part === 'top') {
                container_img_preview.setAttribute('src', data[0].img_src)
            } else if (body_part === 'torso') {
                container_img_preview.setAttribute('src', data[0].img_src)
            } else if (body_part === 'legs') {
                container_img_preview.setAttribute('src', data[0].img_src)
            } else if (body_part === 'feet') {
                container_img_preview.setAttribute('src', data[0].img_src)
            }

            //Adds image  title
            let img_info_title = document.querySelector('#img-info-title')
            img_info_title.textContent = data[0].img_name
            //==================================================================



            //Sets available seasons for this image
            let arr_img_info = []

            for (let key in data[0]) {
                arr_img_info.push(data[0][key])

            }


            //Adds seasons
            let imgs_season_arr = []

            if (arr_img_info[8] != null) {
                imgs_season_arr.push('spring')

            }
            if (arr_img_info[9] != null) {
                imgs_season_arr.push('summer')
            }
            if (arr_img_info[10] != null) {
                imgs_season_arr.push('fall')
            }
            if (arr_img_info[11] != null) {
                imgs_season_arr.push('winter')
            }


            if (imgs_season_arr.length === 0) {
                imgs_season_arr.push('All seasons')
            }



            //Clears off old LI results
            let img_info_list_season = document.querySelector('#img-info-list-season')
            while (img_info_list_season.firstChild) {
                img_info_list_season.removeChild(img_info_list_season.firstChild);
            }



            //Displays available seasons for this image
            imgs_season_arr.map(season => {

                let img_season_icon = document.createElement('img')
                img_season_icon.style.width = '25px'
                img_season_icon.classList.add('mx-1')

                if (season === 'summer') {
                    img_season_icon.setAttribute('src', 'assets/images/icon-summer.png')
                    img_info_list_season.appendChild(img_season_icon)

                } else if (season === 'spring') {
                    img_season_icon.setAttribute('src', 'assets/images/icon-spring.png')
                    img_info_list_season.appendChild(img_season_icon)

                } else if (season === 'fall') {
                    img_season_icon.setAttribute('src', 'assets/images/icon-fall.png')
                    img_info_list_season.appendChild(img_season_icon)
                } else if (season === 'winter') {
                    img_season_icon.setAttribute('src', 'assets/images/icon-winter.png')
                    img_info_list_season.appendChild(img_season_icon)
                } else if (season === 'All seasons') {

                    let img_icon_spring = document.createElement('img')
                    img_icon_spring.setAttribute('src', 'assets/images/icon-spring.png')
                    img_icon_spring.style.width = "25px"
                    img_icon_spring.style.height = "25px"
                    img_icon_spring.classList.add('mx-1')

                    img_info_list_season.appendChild(img_icon_spring)

                    let img_icon_summer = document.createElement('img')
                    img_icon_summer.setAttribute('src', 'assets/images/icon-summer.png')
                    img_icon_summer.style.width = "25px"
                    img_icon_summer.style.height = "25px"
                    img_icon_summer.classList.add('mx-1')
                    img_info_list_season.appendChild(img_icon_summer)

                    let img_icon_fall = document.createElement('img')
                    img_icon_fall.setAttribute('src', 'assets/images/icon-fall.png')
                    img_icon_fall.style.width = "25px"
                    img_icon_fall.style.height = "25px"
                    img_icon_fall.classList.add('mx-1')

                    img_info_list_season.appendChild(img_icon_fall)

                    let img_icon_winter = document.createElement('img')
                    img_icon_winter.setAttribute('src', 'assets/images/icon-winter.png')
                    img_icon_winter.style.width = "25px"
                    img_icon_winter.style.height = "25px"
                    img_icon_winter.classList.add('mx-1')
                    img_info_list_season.appendChild(img_icon_winter)

                }

            })
            //===========================================================



            //Adds temperature
            let imgs_temperature_arr = []

            if (arr_img_info[5] != null) {
                imgs_temperature_arr.push(arr_img_info[6])
            }
            if (arr_img_info[6] != null) {
                imgs_temperature_arr.push(arr_img_info[7])
            }
            let img_info_list_temp = document.querySelector('#img-info-list-temp')

            //Clears off old LI results
            while (img_info_list_temp.firstChild) {
                img_info_list_temp.removeChild(img_info_list_temp.firstChild);
            }

            //Display temperature range for this image 
            imgs_temperature_arr.map(temperature => {

                let span = document.createElement('span')
                span.setAttribute('style', '')
                span.classList.add('me-2')

                //Adds available temperatures for this image
                span.innerHTML = `&nbsp; ${temperature} °C`
                img_info_list_temp.appendChild(span)
            })
            //===========================================================




            //Shows image info container


            //Opens the actual modal by its btn
            document.querySelector('#btn-launch-modal').click();

        })

}


async function getWeather() {


    //Displays saved images
    axios.defaults.withCredentials = true;
    axios.get(`?a=weather_api`)
        .then(function (response) {

            let data = response.data

            if (document.querySelector('#temperature-text')) {

                document.querySelector('#temperature-text').textContent = data + '°C'
            }

            current_temperature = data


        }).catch(error => {

            console.log(error);
            //Launches error alert
            /*             Swal.fire({
                            title: 'No internet connection at the moment',
                            text: 'Make sure you have access to the internet',
                            icon: 'warning',
                        }) */

            current_temperature = null
        });
}
getWeather();



//Sign up form
//Esperando api
const selectCountry = document.querySelector('.select-country')
selectCountry.addEventListener('change', () => { selectState.removeAttribute('disabled') });
if (selectCountry) {

    async function load_country_options() {
        axios.defaults.withCredentials = true;
        axios.get(`?a=get_country_list`)
            .then(function (response) {

                let data = response.data

                data.forEach(country => {
                    const option = document.createElement('option')
                    option.classList.add('option-country')
                    option.value = country.iso2
                    option.textContent = country.name
                    selectCountry.appendChild(option)
                })


                //Removes "disabled" attribuete from the select tag below (select city)


            })
    }
    window.onload = load_country_options
}


const selectState = document.querySelector('.select-state')
selectState.addEventListener('change', () => { selectCity.removeAttribute('disabled') });
async function load_states_options() {

    let selected_country = selectCountry.value

    selectState.innerHTML = '<option value="">Select State</option>'

    axios.defaults.withCredentials = true;
    axios.get(`?a=get_country_list&selected-country=${selected_country}`)
        .then(function (response) {

            let data = response.data
            data.forEach(state => {
                const option = document.createElement('option')
                option.classList.add('option-state')
                option.value = state.iso2
                option.textContent = state.name
                selectState.appendChild(option)
            })



        })
}


const selectCity = document.querySelector('.select-city')
selectCity.addEventListener('change', () => { document.querySelector('.btn-register').removeAttribute('disabled') });
async function load_cities_options() {

    let selected_country = selectCountry.value
    let selected_state = selectState.value

    selectCity.innerHTML = '<option value="">Select City</option>'

    axios.defaults.withCredentials = true;
    axios.get(`?a=get_country_list&selected-country=${selected_country}&selected-state=${selected_state}`)
        .then(function (response) {

            let data = response.data

            data.forEach(city => {
                const option = document.createElement('option')
                option.classList.add('option-cities')
                option.value = city.name
                option.textContent = city.name
                selectCity.appendChild(option)

            })
        })
}




