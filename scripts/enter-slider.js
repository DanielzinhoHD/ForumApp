const slider = document.querySelector(".slider");
const login = document.querySelector("#login-btn");
const signup = document.querySelector("#signup-btn");

const URL_str = location.href;
const url = new URL(URL_str);
const param = url.searchParams.get('signup');

login.onclick = () => {
    return false;
}
signup.onclick = () =>{
    return false;
}

login.addEventListener("click", () => {
    slider.style.marginLeft = "0%";
})

signup.addEventListener("click", () => {
    slider.style.marginLeft = "50%";
})

if(param !== null){
    slider.style.marginLeft = "50%";
}