// displaying the uploading image
let input = document.querySelector(".image")
let img = document.querySelector(".show_image")
let upload_profile = null;
input.addEventListener("change", display_image);
function display_image(event) {
    upload_profile = event.target.files[0];
    if (event.target.files.length > 0) {
        img.style.display = "block";
        let src = URL.createObjectURL(event.target.files[0]);
        img.src = src;
    }
    // to hide text and icon when image is displayed
    // this issue arises when user upload png image
    document.querySelector(".icon_and_text").style.display = "none"

}


// working on password
let state = false;
let state2 = false;
let first_password = document.querySelector(".password_details div input")
let confirm_password = document.querySelector(".confirm_password")

let show_hide = document.querySelectorAll(".show_hide")
show_hide[0].addEventListener("click", show_hide_first_password)
show_hide[1].addEventListener("click", show_hide_confirm_password)

function show_hide_first_password() {
    if (state == false) {
        first_password.type = "text";
        show_hide[0].textContent = "HIDE"
        state = true;
    }
    else {
        state = false;
        first_password.type = "password";
        show_hide[0].textContent = "SHOW"

    }
}

function show_hide_confirm_password() {
    if (state2 == false) {
        confirm_password.type = "text";
        show_hide[1].textContent = "HIDE"
        state2 = true;
    }
    else {
        state2 = false;
        confirm_password.type = "password";
        show_hide[1].textContent = "SHOW"

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


// checking strength of password
let is_password_strong = true;
let correct_password_icon = document.querySelector(".correct_first_password")
let incorrect_password_icon = document.querySelector(".incorrect_first_password")

let number = /[0-9]/g;
let lowercase = /[a-z]/g;
let uppercase = /[A-Z]/g;
let symbols = /[^a-zA-Z0-9]/g;





first_password.addEventListener("input", check_strength);
confirm_password.addEventListener("input", change_width);

function change_width() {
    confirm_password.style.paddingRight = "70px";

    // let input_width = document.querySelector(".confirm_password_details div").offsetWidth;
    // input_width = (input_width * 95 / 100) - 60;
    // confirm_password.style.width = `${input_width}px`;
    // confirm_password.style.marginRight = "60px";
}

function check_strength() {
    first_password.style.paddingRight = "110px";
    // to reduce width of input field so that charcter shouldn't overflow
    // if (first_password.value.length >= 1) {
    //     let input_width = document.querySelector(".password_details div").offsetWidth;
    //     input_width = (input_width * 95 / 100) - 100;
    //     first_password.style.width = `${input_width}px`;
    //     first_password.style.marginRight = "100px";

    // }
    if (first_password.value == "") {
        incorrect_password_icon.style.visibility = "hidden";
        correct_password_icon.style.visibility = "hidden";
        return;

    }
    let inputValue = first_password.value;
    let numberP = inputValue.match(number);
    let lowercaseP = inputValue.match(lowercase)
    let uppercaseP = inputValue.match(uppercase);
    let symbolsP = inputValue.match(symbols)


    if (inputValue.length >= 10 && (numberP != null && numberP.length >= 1) && (lowercaseP != null && lowercaseP.length >= 2) && (uppercaseP != null && uppercaseP.length >= 3) && (symbolsP != null && symbolsP.length >= 4)) {
        is_password_strong = true;
        correct_password_icon.style.visibility = "visible";
        incorrect_password_icon.style.visibility = "hidden";

    }
    else {
        is_password_strong = false;
        incorrect_password_icon.style.visibility = "visible";
        correct_password_icon.style.visibility = "hidden";

    }
}


// validating first password, confirm password and email

let form = document.querySelector("form")
let error = document.querySelectorAll(".error")
let user_email = document.querySelector(".email")


let valid_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

//changing icon when email is valid or invalid
let correct_email = document.querySelector(".correct_email")
let incorrect_email = document.querySelector(".incorrect_email")

let correct_phone_number = document.querySelector(".correct_phone_number")
let incorrect_phone_number = document.querySelector(".incorrect_phone_number")
let user_phone_number = document.querySelector(".phone_number");

user_email.addEventListener("input", check_email)
user_phone_number.addEventListener("input", check_phone_number);

function check_phone_number() {
    user_phone_number.style.paddingRight = "40px";

    // let input_width = document.querySelector(".phone_number_details div").offsetWidth;
    // input_width = (input_width * 95 / 100) - 40;
    // user_phone_number.style.width = `${input_width}px`;
    // user_phone_number.style.marginRight = "40px";

    if (user_phone_number.value.length == 10) {
        correct_phone_number.style.visibility = "visible"
        incorrect_phone_number.style.visibility = "hidden"
    }
    else {
        correct_phone_number.style.visibility = "hidden"
        incorrect_phone_number.style.visibility = "visible"
    }
}

function check_email() {
    user_email.style.paddingRight = "50px";

    // let input_width = document.querySelector(".email_details div").offsetWidth;
    // input_width = (input_width * 95 / 100) - 40;
    // user_email.style.width = `${input_width}px`;
    // user_email.style.marginRight = "40px";

    if (valid_email.test(user_email.value)) {
        correct_email.style.visibility = "visible"
        incorrect_email.style.visibility = "hidden"
    }
    else {
        correct_email.style.visibility = "hidden"
        incorrect_email.style.visibility = "visible"
    }
}



form.addEventListener("submit", check_password)
let no_of_errors = 0;
let image_error = false;
let email_error = false;
let phone_number_error = false;
let strong_password_error = false;
let confirm_password_error = false;

function check_password(event) {
    if (upload_profile != null) {
        if (upload_profile.size >= 1024 * 1024) {

            if (!image_error) {

                no_of_errors++;
            }

            image_error = true;
            error[0].style.display = "block";
            document.querySelector(".image").style.zIndex = "10"
        }
        else {
            if (no_of_errors != 0 && image_error) {

                no_of_errors--;
            }
            image_error = false;
            error[0].style.display = "none";
        }
    }

    if (!valid_email.test(user_email.value)) {


        if (!email_error) {

            no_of_errors++;
        }

        email_error = true;

        error[1].style.display = "block"
        error[1].textContent = "Invalid E-mail Address";
    }
    else {
        if (no_of_errors != 0 && email_error) {

            no_of_errors--;
        }
        email_error = false;
        error[1].style.display = "none"
    }

    if (user_phone_number.value.length != 10) {


        if (!phone_number_error) {

            no_of_errors++;
        }

        phone_number_error = true;

        error[2].style.display = "block"
        error[2].textContent = "Invalid Phone Number";

    }
    else {
        if (no_of_errors != 0 && phone_number_error) {

            no_of_errors--;
        }
        phone_number_error = false;
        error[2].style.display = "none"
    }

    if (is_password_strong == false) {

        if (!strong_password_error) {

            no_of_errors++;
        }

        strong_password_error = true;

        error[3].style.display = "block"
        error[3].textContent = "Weak Password"
    }
    // to show first password is strong or not and after that compare the password
    else {
        if (no_of_errors != 0 && strong_password_error) {

            no_of_errors--;
        }
        strong_password_error = false;
        error[3].style.display = "none"
        if (first_password.value != confirm_password.value) {

            if (!confirm_password_error) {

                no_of_errors++;
            }

            confirm_password_error = true;

            error[4].style.display = "block"
        }
        else {
            if (no_of_errors != 0 && confirm_password_error) {

                no_of_errors--;
            }
            confirm_password_error = false;
            error[4].style.display = "none";
        }
    }

    if (no_of_errors != 0) {
        event.preventDefault();
    }
}