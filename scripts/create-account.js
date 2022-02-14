$(".form-signup").submit((event) => {
    event.preventDefault();
    
    const name = $('input[name="r-name"]').val();
    const email = $('input[name="r-email"]').val();
    const pwd = $('input[name="r-pwd"]').val();
    const pwd2 = $('input[name="r-pwd2"]').val();
    const submit = $('button[name="signup"]').val();

    $.post("../includes/register.inc.php", {
        name: name,
        email: email,
        pwd: pwd,
        pwd2: pwd2,
        submit: submit
    }).done((error) => {
        if(!error){
            location.href = "../views/success.php?stats=emailsent";
        }
        // console.log(error);
        window.scrollTo({top: 100, behavior: 'smooth'});
        const msg = $("#error");
        msg.html(error);
    })
})