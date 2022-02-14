const btn = $("#submit");
btn.on("click", () => {
    
    const topic = $('.input-topic').val();
    const title = $('.input-title').val();
    const img = $('.input-file').val();
    const text = $('textarea').val();
    const submit = $('#submit').val();

    $.post("../includes/submit-post.inc.php", {
        topic: topic,
        title: title,
        img: img,
        text: text,
        submit: submit
    }).done((res) => {
        try {
            res = JSON.parse(res);
            if(res.location){
                location.href = res.location;
            }
        }
        catch(e){
            // console.log(e);
        }
        // console.log(res);
        
        // console.log(error);
        window.scrollTo({top: 0, behavior: 'smooth'});
        const msg = $("#error");
        msg.html(res);
    })
})