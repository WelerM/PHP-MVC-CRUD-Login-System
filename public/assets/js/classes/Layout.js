const form = document.querySelector('#img-form')
const img_preview_container = document.querySelector('#img-preview')
const container_modal_btns = document.querySelector('.container-modal-btns')
const container_crud_btns = document.querySelector('.container-crud-btns')
const container_img_suggestion = document.querySelector('.container-img-suggestion')
const error_msg_text = document.querySelector('.error-msg-text')
const container_add_img = document.querySelector('.container-add-img')
const container_img_info = document.querySelector('.container-img-info')
const container_input_file = document.querySelector('#container-input-file')
const btn_use = document.querySelector('#btn-use')
const btn_remove = document.querySelector('.btn-remove')
const modal_container_info_img = document.querySelector('.container-img-info')
const modal_container_add_img = document.querySelector('.container-add-img')







 class Layout {

  constructor(elementSelector) {
    this.element = document.querySelector(elementSelector);


  }


  btn_add_clicked() {



    //Shows image preview before submiting
    img_preview_container.classList.remove('d-none')
    img_preview_container.classList.add('d-flex')

    //Hides "crud" btns, they are only available when checking existing images in the app
    container_modal_btns.classList.remove('d-flex')
    container_modal_btns.classList.add('d-none')

    //Hides container img suggestion
    container_img_suggestion.classList.remove('d-flex')
    container_img_suggestion.classList.add('d-none')

    //Hides error msg
    error_msg_text.classList.add('d-none')
    //Shows form
    form.classList.remove('d-none')
    form.classList.add('d-flex')
  }
  //======================================================================



  btn_add_sugge_clicked() {

    container_add_img.classList.remove('d-flex')
    container_add_img.classList.add('d-none')

    container_img_info.classList.remove('d-flex')
    container_img_info.classList.add('d-none')

    container_img_suggestion.classList.remove('d-none')
    container_img_suggestion.classList.add('d-flex')


    container_modal_btns.classList.remove('d-none')
    container_modal_btns.classList.remove('d-flex')

    container_crud_btns.classList.remove('d-flex')
    container_crud_btns.classList.add('d-none')
  }
  //======================================================================



  btn_edit_clicked() {
    container_add_img.classList.remove('d-none')
    container_add_img.classList.remove('flex-column-reverse')

    container_input_file.classList.remove('d-none')
    container_input_file.classList.add('d-flex')


    container_modal_btns.classList.remove('d-flex')
    container_modal_btns.classList.add('d-none')

    container_add_img.classList.add('flex-column')
    container_add_img.classList.add('d-flex')

    container_img_info.classList.remove('d-flex')
    container_img_info.classList.add('d-none')

    form.classList.remove('d-none')
    form.classList.add('d-flex')

  }
  //======================================================================



  show_img_preview(e) {
    container_add_img.classList.remove('d-none')
    container_add_img.classList.add('d-flex')

    //Hides img info container
    container_img_info.classList.remove('d-flex')
    container_img_info.classList.add('d-none')

    img_preview_container.setAttribute('src', e)
    img_preview_container.classList.remove('d-none')
  }
  //======================================================================






  show_error_alert(error) {

    let error_text;

    if (error === 'filetoobig') {
      error_text = "The choosen file is too big. Plese select another one."
    } else if (error === 'uploaderror') {
      error_text = "There was an error uploading your file."
    } else if (error === 'filenotsupported') {
      error_text = "This image is not supported."
    } else if (error = 'imgnameempty') {
      error_text = "You need to add a name for the image."
    }


    Swal.fire({
      title: 'Error!',
      text: error_text,
      icon: 'warning'
    })



  }



  show_img_info(img_src) {

    container_add_img.classList.remove('d-none')
    container_add_img.classList.add('d-flex')

    container_img_suggestion.classList.remove('d-flex')
    container_img_suggestion.classList.add('d-none')


    //Shows "crud" btn 
    container_modal_btns.classList.remove('d-none')
    container_modal_btns.classList.add('d-flex')

    container_crud_btns.classList.remove('d-none')
    container_crud_btns.classList.add('d-flex')

    //Forces "crud" btns to show, they may be hidden from start if the URL as an "error" variable
    btn_use.classList.remove('d-none')
    btn_use.classList.add('d-flex')

    btn_remove.classList.remove('d-none')
    btn_remove.classList.add('d-flex')

    //Hides modal's error msg
    error_msg_text.classList.add('d-none')


    //Shows image
    img_preview_container.classList.remove('d-none')
    img_preview_container.classList.add('d-flex')
    img_preview_container.setAttribute('src', img_src)

    container_img_info.classList.remove('d-none')
    container_img_info.classList.add('d-flex')
    container_img_info.classList.add('flex')

    //Hides form
    form.classList.remove('d-flex')
    form.classList.add('d-none')
  }
}
