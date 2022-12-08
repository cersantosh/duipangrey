let show_hide = document.querySelector(".show_hide")
show_hide.addEventListener("click", show_hide_password)
let state = false;
password = document.querySelector(".password");
password.addEventListener("focus", chnage_width);

function chnage_width(){
    let input_width = document.querySelector(".password_details").offsetWidth;
        input_width = input_width- 60;
        password.style.width = `${input_width}px`;
        password.style.borderTopRightRadius = "0";
        password.style.borderBottomRightRadius = "0";
}

function show_hide_password(){
    if(state == false){
        password.type = "text";
        show_hide.textContent = "HIDE"
        state = true;
    }
    else{
        state = false;
        password.type = "password";
        show_hide.textContent = "SHOW"

    }
}



// working on placeholder showing on the top border line

function show_placeholder(class_name, element){
    let label = document.querySelector(`.${class_name}`);
    label.style.display = "block";
    if(element.value == ""){
        label.style.display = "none";
    }
}