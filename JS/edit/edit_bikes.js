// displaying the uploading image
let input = document.querySelector(".image")
let prev = document.querySelector(".prev")
let next = document.querySelector(".next")
let img = document.querySelectorAll(".show_image")
// console.log(img);
let img_array;



input.addEventListener("change", display_image);
function display_image(event) {
    this.setAttribute("required", "");
    for (let i = 0; i < img.length; i++) {
        if (i == 0) {
            continue;
        }
        img[i].remove();
    }

    // if there is only one image
    if (document.querySelector(".image_prev") != null) {

        document.querySelector(".image_prev").style.visibility = "hidden";
    }
    if (document.querySelector(".image_next") != null) {

        document.querySelector(".image_next").style.visibility = "hidden";
    }
    document.querySelector(".icon_and_text").style.display = "none";
    img_array = event.target.files;
    // console.log(img_array);
    if (event.target.files.length > 0) {
        img[0].style.display = "block";
        let src = URL.createObjectURL(event.target.files[0]);
        img[0].src = src;
    }
    // if only one image is selected
    if (event.target.files.length < 2) {
        prev.style.visibility = "hidden"
        next.style.visibility = "hidden"
    }
    else if (event.target.files.length >= 2) {
        prev.style.visibility = "visible"
        next.style.visibility = "visible"
        prev.style.zIndex = "2"
        next.style.zIndex = "2"
    }
}
let index = 0;

//creating image slider if images are greater than 2
next.addEventListener("click", next_image);
prev.addEventListener("click", prev_image);

function next_image(event) {
    index++;
    if (index == img_array.length) {
        index = 0;
    }
    img[0].src = URL.createObjectURL(img_array[index]);
}

function prev_image(event) {
    index--;
    if (index == -1) {
        index = img_array.length - 1;
    }
    img[0].src = URL.createObjectURL(img_array[index]);
}

// validating negative values
let cc = document.querySelector(".cc")
let km = document.querySelector(".km")
let lot_no = document.querySelector(".lot_no")
let fuel_capacity = document.querySelector(".fuel_capacity")
let original_price = document.querySelector(".original_price")
let new_price = document.querySelector(".new_price")
let error = document.querySelectorAll(".error")
let form = document.querySelector("form");


let no_of_errors = 0;
let img_error = false;
let cc_error = false;
let km_error = false;
let lot_error = false;
let fuel_error = false;
let original_price_error = false;
let new_price_error = false;

form.addEventListener("submit", validate)


function validate(event) {
    if (img_array.length > 5) {
        if (!image_error) {
            no_of_errors++;
        }
        error[0].style.display = "block"
        img_error = true;
    }
    else {
        if (no_of_errors != 0 && img_error) {

            no_of_errors--;
        }
        error[0].style.display = "none"
        img_error = false;
    }

    if (cc.value < 0) {
        if (!cc_error) {

            no_of_errors++;
        }
        error[1].style.display = "block"
        cc_error = true;
    }
    else {
        if (no_of_errors != 0 && cc_error) {

            no_of_errors--;
        }
        error[1].style.display = "none"
        cc_error = false;
    }

    if (km.value < 0) {
        if (!km_error) {
            no_of_errors++;

        }
        error[2].style.display = "block"
        km_error = true;
    }
    else {
        if (no_of_errors != 0 && km_error) {

            no_of_errors--;
        }
        error[2].style.display = "none"
        km_error = false;
    }

    if (lot_no.value < 0) {
        if (!lot_error) {
            no_of_errors++;

        }
        error[3].style.display = "block"
        lot_error = true;
    }
    else {
        if (no_of_errors != 0 && lot_error) {

            no_of_errors--;
        }
        error[3].style.display = "none"
        lot_error = false;
    }

    if (fuel_capacity.value < 0) {
        if (!fuel_error) {
            no_of_errors++;

        }
        error[4].style.display = "block"
        fuel_error = true;
    }
    else {
        if (no_of_errors != 0 && fuel_error) {

            no_of_errors--;
        }
        error[4].style.display = "none"
        fuel_error = false;
    }

    if (original_price.value < 0) {
        if (!original_price_error) {
            no_of_errors++;

        }
        error[5].style.display = "block"
        original_price_error = true;
    }
    else {
        if (no_of_errors != 0 && original_price_error) {

            no_of_errors--;
        }
        error[5].style.display = "none"
        original_price_error = false;
    }

    if (new_price.value < 0) {
        if (!new_price_error) {
            no_of_errors++;

        }
        error[6].style.display = "block"
        new_price_error = true;
    }
    else {
        if (no_of_errors != 0 && new_price_error) {

            no_of_errors--;
        }
        error[6].style.display = "none"
        new_price_error = false;
    }

    if (no_of_errors != 0) {
        event.preventDefault();
    }

}

// working on placeholder showing on the top border line

function show_placeholder(class_name, element) {
    let label = document.querySelector(`.${class_name}`);
    label.style.display = "block";
    if (element.value == "") {
        label.style.display = "none";
    }
}


// working on image slider of products details
let images = document.querySelectorAll(".image_details img");
let image_prev = document.querySelector(".image_prev")
let image_next = document.querySelector(".image_next")

// to track images
let image_index = 0;

// if there is only one image then next and previous button will be disabled so it contains null
if (image_next != null) {
    image_next.addEventListener("click", next_uploaded_image);

}

if (image_prev != null) {
    image_prev.addEventListener("click", prev_uploaded_image);

}
// console.log(images);

// displaying first image
images[0].style.display = "block";

function next_uploaded_image() {
    images[image_index].style.display = "none";
    image_index++;
    if (image_index == images.length) {
        image_index = 0;
    }
    images[image_index].style.display = "block";
    // console.log(image_index);

}

function prev_uploaded_image() {
    images[image_index].style.display = "none";
    image_index--;
    if (image_index == -1) {
        image_index = images.length - 1;
    }
    images[image_index].style.display = "block";
    // console.log(image_index);


}