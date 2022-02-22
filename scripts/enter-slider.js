viewWidth = window.innerWidth;

const slider = document.querySelector(".slider");
const login = document.querySelector("#login-btn");
const signup = document.querySelector("#signup-btn");
const formInner = document.querySelector(".form-inner");

const URL_str = location.href;
const url = new URL(URL_str);
const param = url.searchParams.get('signup');

login.onclick = () => {
    return false;
}
signup.onclick = () =>{
    return false;
}

if(viewWidth > 800){
    login.addEventListener("click", () => {
        slider.style.marginLeft = "0%";
    })
    signup.addEventListener("click", () => {
        slider.style.marginLeft = "50%";
    })
    if(param !== null){
        slider.style.marginLeft = "50%";
    }
}else{
    login.addEventListener("click", () => {
        formInner.style.marginLeft = "-100%";
    })
    signup.addEventListener("click", () => {
        formInner.style.marginLeft = "0%";
    })
    if(param == null){
        formInner.style.marginLeft = "-100%";
    }
}