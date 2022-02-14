const URL_str = location.href;
const url = new URL(URL_str);
const postID = url.searchParams.get('id');

// console.log(postID);

const btn = $("#submit");

btn.on("click", () => {
    
    const msg = $('textarea[name="text"]').val();

    const submit = $('#submit').val();

    $.post("../includes/submit-comment.inc.php", {
        msg: msg,
        postID: postID,
        submit: submit
    }).done((res) => {
        if(!res){
            return location.reload();
        }

        const msg = $("#error");
        msg.html(res);
    })
})