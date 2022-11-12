
// working on nav bar for mobile

let icon_home = document.querySelector(".nav_bar_icon_home i");
let cross_icon = document.querySelector(".nav_bar_icon i");
if (cross_icon != null) {
    cross_icon.addEventListener("click", () => {
        document.querySelector(".nav_bar_mobile").style.display = "none";
        document.querySelector(".nav_bar_home_show_hide").style.display = "block";

    })
}

if (icon_home != null) {
    icon_home.addEventListener("click", () => {
        document.querySelector(".nav_bar_home_show_hide").style.display = "none";
        document.querySelector(".nav_bar_mobile").style.display = "block";
    })
}


// working on showing or hiding filter options

let show_hide_filter_button = document.querySelector(".filter_show_hide button");

show_hide_filter_button.addEventListener("click", () => {
    document.querySelector(".filter_details").classList.toggle("show_hide_filter");
})




// working on searching

let search_icon = document.querySelector(".search_icon");
let search_input = document.querySelector(".search_input");
// console.log(search_input);

// focusing search input box

let origin = location.origin;
let pathname = location.pathname;
let link = origin + pathname;
// console.log(origin);
// console.log(pathname);
// console.log(link);
if (link == "http://localhost/project/html/search/filter_search.php") {
    search_input.focus();
    // changing cursor to the end of the text
    let value = search_input.value; //store the value of the element
    search_input.value = ''; //clear the value of the element
    search_input.value = value; //set that value back.  
}

search_input.addEventListener("input", change_link);
// passing user search value to the url
function change_link(event) {
    let search_value = null;
    if (event.data == " ") {
        // passing ^ to add space as $_get is ignoring space
        search_value = search_input.value + "^";
    }
    else {

        search_value = search_input.value;
    }
    let url = "http://localhost/project/html/search/filter_search.php";

    location.href = `${url}?search_value=${search_value}`;
}

// showing only options related to bikes or scooters according to category
let company_filter_bikes = document.querySelector(".company_filter_bikes")
let company_filter_scooters = document.querySelector(".company_filter_scooters")
let lot_number_filter_bikes = document.querySelector(".lot_number_filter_bikes")
let lot_number_filter_scooters = document.querySelector(".lot_number_filter_scooters")
let location_filter_bikes = document.querySelector(".location_filter_bikes")
let location_filter_scooters = document.querySelector(".location_filter_scooters")
let category_bikes = document.querySelector("#bikes")
let category_scooters = document.querySelector("#scooters")

category_bikes.addEventListener("click", disable_scooters);
category_scooters.addEventListener("click", disable_bikes);
function disable_scooters() {
    if (category_bikes.checked == true && category_scooters.checked == false) {

        company_filter_scooters.style.display = "none";
        lot_number_filter_scooters.style.display = "none";
        location_filter_scooters.style.display = "none";
    }
    else {
        company_filter_bikes.style.display = "block";
        lot_number_filter_bikes.style.display = "block";
        location_filter_bikes.style.display = "block";
        company_filter_scooters.style.display = "block";
        lot_number_filter_scooters.style.display = "block";
        location_filter_scooters.style.display = "block";
    }
}

function disable_bikes() {
    if (category_scooters.checked == true && category_bikes.checked == false) {
        company_filter_bikes.style.display = "none";
        lot_number_filter_bikes.style.display = "none";
        location_filter_bikes.style.display = "none";
    }
    else {
        company_filter_scooters.style.display = "block";
        lot_number_filter_scooters.style.display = "block";
        location_filter_scooters.style.display = "block";
        company_filter_bikes.style.display = "block";
        lot_number_filter_bikes.style.display = "block";
        location_filter_bikes.style.display = "block";
    }

}

// working on all buttons

function select_all(class_value) {
    // showing options related to both bikes and scooters if user clicks both button
    if (class_value == "category_filter") {
        company_filter_bikes.style.display = "block";
        lot_number_filter_bikes.style.display = "block";
        location_filter_bikes.style.display = "block";
        company_filter_scooters.style.display = "block";
        lot_number_filter_scooters.style.display = "block";
        location_filter_scooters.style.display = "block";
    }
    console.log(class_value);
    let options = document.querySelectorAll(`.${class_value} input`);
    // console.log(options);
    for (let i = 0; i < options.length; i++) {
        options[i].checked = true;
    }
}

// working on clear button

function clear_all(class_value) {
    let options = document.querySelectorAll(`.${class_value} input`);
    // console.log(options);
    for (let i = 0; i < options.length; i++) {
        options[i].checked = false;
    }
}

// working on showing only 5 options in filter section

let brand_bikes = document.querySelectorAll(".brand_bikes");

if (brand_bikes.length > 5) {
    for (let i = 0; i < brand_bikes.length; i++) {
        if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
            continue
        }
        brand_bikes[i].style.display = "none"
    }
}

let brand_scooters = document.querySelectorAll(".brand_scooters");

if (brand_scooters.length > 5) {
    for (let i = 0; i < brand_scooters.length; i++) {
        if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
            continue
        }
        brand_scooters[i].style.display = "none"
    }
}


let lot_no_bikes = document.querySelectorAll(".lot_no_bikes");

if (lot_no_bikes.length > 5) {
    for (let i = 0; i < lot_no_bikes.length; i++) {
        if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
            continue
        }
        lot_no_bikes[i].style.display = "none"
    }
}


let lot_no_scooters = document.querySelectorAll(".lot_no_scooters");

if (lot_no_scooters.length > 5) {
    for (let i = 0; i < lot_no_scooters.length; i++) {
        if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
            continue
        }
        lot_no_scooters[i].style.display = "none"
    }
}

let district_bikes = document.querySelectorAll(".district_bikes");

if (district_bikes.length > 5) {
    for (let i = 0; i < district_bikes.length; i++) {
        if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
            continue
        }
        district_bikes[i].style.display = "none"
    }
}


let district_scooters = document.querySelectorAll(".district_scooters");

if (district_scooters.length > 5) {
    for (let i = 0; i < district_scooters.length; i++) {
        if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
            continue
        }
        district_scooters[i].style.display = "none"
    }
}


function see_more(class_name, element) {
    let options = document.querySelectorAll(`.${class_name}`);
    if (element.textContent == "Show More") {
        for (let i = 0; i < options.length; i++) {
            if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
                continue
            }
            options[i].style.display = "block"
        }
        element.textContent = "Show Less"
    } else {
        for (let i = 0; i < options.length; i++) {
            if (i == 0 || i == 1 || i == 2 || i == 3 || i == 4) {
                continue
            }
            options[i].style.display = "none"
        }
        element.textContent = "Show More"
    }

}

// working on products showing
let products_wrapper = document.querySelectorAll(".products_wrapper");
let previous = document.querySelectorAll(".previous")
let next = document.querySelectorAll(".next")
let buttons = document.querySelectorAll(".btn");
let next_button = document.querySelector(".next_button")
let previous_button = document.querySelector(".previous_button")

if (buttons.length >= 1) {

    buttons[0].style.backgroundColor = "green";
}
if (previous_button != null) {
    previous_button.addEventListener("click", show_previous_products);

}

if (next_button != null) {
    next_button.addEventListener("click", show_next_products);

}

if (products_wrapper.length >= 1) {
    products_wrapper[0].style.display = "block";

}



let index = 0;

function show_next_products() {
    products_wrapper[index].style.display = "none";
    index++;
    if (index == products_wrapper.length) {
        index = products_wrapper.length - 1;
    }
    products_wrapper[index].style.display = "block";

    buttons[index].classList.add("background");
    buttons[0].style.backgroundColor = "blue";
    for (let i = 0; i < buttons.length; i++) {
        if (i == index) {
            continue;
        }
        buttons[i].classList.remove("background");
    }
}

function show_previous_products() {
    products_wrapper[index].style.display = "none";
    index--;
    if (index == -1) {
        index = 0;
    }
    products_wrapper[index].style.display = "block";
    buttons[index].classList.add("background");
    buttons[0].style.backgroundColor = "blue";
    for (let i = 0; i < buttons.length; i++) {
        if (i == index) {
            continue;
        }
        buttons[i].classList.remove("background");
    }
}






for (let i = 0; i < next.length; i++) {
    next[i].addEventListener("click", next_data);

}
for (let i = 0; i < previous.length; i++) {
    previous[i].addEventListener("click", previous_data);

}


function next_data() {
    products_wrapper[index].style.display = "none";
    index++;
    if (index == products_wrapper.length) {
        index = 0;
    }
    products_wrapper[index].style.display = "block";
    buttons[index].classList.add("background");
    buttons[0].style.backgroundColor = "blue";
    for (let i = 0; i < buttons.length; i++) {
        if (i == index) {
            continue;
        }
        buttons[i].classList.remove("background");
    }
}

function previous_data() {
    products_wrapper[index].style.display = "none";
    index--;
    if (index == -1) {
        index = products_wrapper.length - 1;
    }
    products_wrapper[index].style.display = "block";
    buttons[index].classList.add("background");
    buttons[0].style.backgroundColor = "blue";
    for (let i = 0; i < buttons.length; i++) {
        if (i == index) {
            continue;
        }
        buttons[i].classList.remove("background");
    }
}

// working on buttons so that user can directly click on buttons and see products
function change_products(num, elem) {
    products_wrapper[index].style.display = "none";
    index = num;
    products_wrapper[index].style.display = "block";
    // to apply background color to selected one and remove class background from other buttons
    elem.classList.add("background");
    buttons[0].style.backgroundColor = "blue";
    for (let i = 0; i < buttons.length; i++) {
        if (i == num) {
            continue;
        }
        buttons[i].classList.remove("background");
    }
}

// working on profile picture

let profile_wrapper = document.querySelector(".profile_wrapper");
let profile_button = document.querySelector(".profile");
let profile_state = false;

if (profile_button != null) {

    profile_button.addEventListener("click", display_profile_details);
}
document.body.addEventListener("click", () => {
    profile_wrapper.style.display = "none";
    profile_state = false;

})

function display_profile_details(event) {
    event.stopPropagation();
    if (profile_state == false) {

        profile_wrapper.style.display = "block";
        profile_state = true;
    }
    else {
        profile_wrapper.style.display = "none";
        profile_state = false;
    }
}

// working on sticky menu

window.addEventListener("scroll", sticky_menu)

function sticky_menu() {
    if (window.pageYOffset >= 20) {
        document.querySelector(".nav_bar").classList.add("sticky");
    }
    else {
        document.querySelector(".nav_bar").classList.remove("sticky");

    }
}

// working on image slider of products details

let products = document.querySelectorAll(".products");

// console.log(products[3].children[0].children[2].children);
let images = [];
for (let i = 0; i < products.length; i++) {
    // this is for if there is only one image of vehicles
    if (products[i].children[0].children[2] == undefined) {
        images.push(products[i].children[0].children[0].children);
    }
    else {
        images.push(products[i].children[0].children[2].children);

    }
}

// displaying first image of all products
for (let i = 0; i < images.length; i++) {
    images[i][0].style.display = "block";
}

let image_index = 0;
let function_call = 0;
let initialize = false;
function next_image(value) {
    if (value != 0 && !initialize) {
        image_index = 0;
        initialize = true;
    }
    // console.log(value);
    images[value][image_index].style.display = "none";
    image_index++;
    if (image_index == images[value].length) {
        image_index = 0;
    }
    images[value][image_index].style.display = "block";
    // console.log(image_index);

}

function prev_image(value) {
    if (value != 0 && !initialize) {
        image_index = 0;
        initialize = true;
    }
    // console.log(value);
    images[value][image_index].style.display = "none";
    image_index--;
    if (image_index == -1) {
        image_index = images[value].length - 1;
    }
    images[value][image_index].style.display = "block";
    // console.log(image_index);


}

