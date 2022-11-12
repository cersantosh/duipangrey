

// working on password
let state = false;
let state2 = false;
let new_password = document.querySelector(".new_password")
let confirm_password = document.querySelector(".confirm_password")

let show_hide = document.querySelectorAll(".show_hide")
show_hide[0].addEventListener("click", show_hide_new_password)
show_hide[1].addEventListener("click", show_hide_confirm_password)

function show_hide_new_password(){
    if(state == false){
        new_password.type = "text";
        show_hide[0].textContent = "HIDE"
        state = true;
    }
    else{
        state = false;
        new_password.type = "password";
        show_hide[0].textContent = "SHOW"

    }
}


function show_hide_confirm_password(){
    if(state2 == false){
        confirm_password.type = "text";
        show_hide[1].textContent = "HIDE"
        state2 = true;
    }
    else{
        state2 = false;
        confirm_password.type = "password";
        show_hide[1].textContent = "SHOW"

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





new_password.addEventListener("input", check_strength);
confirm_password.addEventListener("input", chnage_confirm_password_width);
new_password.addEventListener("input", chnage_new_password_width);

// to reduce width of input field so that charcter shouldn't overflow
function chnage_new_password_width(){
    let input_width = document.querySelector(".new_password_details div").offsetWidth;
        input_width = input_width - 100;
        new_password.style.width = `${input_width}px`;
        new_password.style.marginRight = "60px";
}
function chnage_confirm_password_width(){
    let input_width = document.querySelector(".confirm_password_details div").offsetWidth;
        input_width = input_width - 60;
        confirm_password.style.width = `${input_width}px`;
        confirm_password.style.marginRight = "60px";
}

function check_strength() {
    
    if(new_password.value == ""){
        incorrect_password_icon.style.visibility = "hidden";
        correct_password_icon.style.visibility = "hidden";
        return;

    }
    let inputValue = new_password.value;
    let numberP = inputValue.match(number);
    let lowercaseP = inputValue.match(lowercase)
    let uppercaseP = inputValue.match(uppercase);
    let symbolsP = inputValue.match(symbols)


    if (inputValue.length >= 10 && (numberP != null && numberP.length >= 1) && (lowercaseP != null && lowercaseP.length >= 2) && (uppercaseP != null && uppercaseP.length >= 3) && (symbolsP != null && symbolsP.length >= 4)){
        is_password_strong = true;
        correct_password_icon.style.visibility = "visible";
        incorrect_password_icon.style.visibility = "hidden";

    }
    else{
        is_password_strong = false;
        incorrect_password_icon.style.visibility = "visible";
        correct_password_icon.style.visibility = "hidden";

    }
}


// validating first password, confirm password

let form = document.querySelector("form")
let error = document.querySelectorAll(".error")


form.addEventListener("submit", check_password)
let no_of_errors = 0;
function check_password(event){

    if(is_password_strong == false){
        no_of_errors++;
        error[0].style.display = "block"
        error[0].textContent = "Weak Password"
    }
    // to show first password is strong or not and after that compare the password
    else{
        no_of_errors = 0;
        error[0].style.display = "none"

        if(new_password.value != confirm_password.value){
            no_of_errors++;
            error[1].style.display = "block"
        }
        else{
            no_of_errors = 0;
            error[1].style.display = "none";
        }
    }

    if(no_of_errors != 0){
        event.preventDefault();
    }
}