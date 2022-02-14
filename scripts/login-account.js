$(".form-login").submit((event) => {
    event.preventDefault();
    
    const email = $('input[name="l-email"]').val();
    const pwd = $('input[name="l-pwd"]').val();
    const submit = $('button[name="login"]').val();

    $.post("../includes/login.inc.php", {
        email: email,
        pwd: pwd,
        submit: submit
    }).done((error) => {
        if(!error){
            // mudar cursor pra loading;
            location.href = "../index.php";
        }
        // console.log(error);
        window.scrollTo({top: 100, behavior: 'smooth'});
        const span = $("#error");
        span.html(error);
    })
})