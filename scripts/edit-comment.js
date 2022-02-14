$('.edit-comment').each((index, element) => {
    $(element).on('click', ()=>{

    // Get URL id param;
        const URL_str = location.href;
        const url = new URL(URL_str);
        const param = url.searchParams.get('id');

    // Getting element parent;
        const pub = element.offsetParent;
        const post = pub.offsetParent;
    
    // Figure out if clicked in a comment or the post by id;
        const commentId = post.dataset.commentId;
        const postId = post.dataset.postId;

        if(postId == param){
        // Changing post comment;
            const textArea = pub.querySelector(".text textarea");
            // console.log(textArea.value)
            // console.log(postId);
            toggleEditBtn(element, 'post', postId, textArea.value);

            textArea.addEventListener("keyup", () => {
                autoGrow(textArea);
            })

            toggleTextArea(textArea);
            
        }else{
        // Changing comment;
            const textArea = pub.querySelector(".text textarea");

            toggleEditBtn(element, 'comment', commentId, textArea.value);

            textArea.addEventListener("keyup", () => {
                autoGrow(textArea);
            })

            toggleTextArea(textArea);
        }
    })
})

function toggleEditBtn(editBtn, type, id, text){
    if(editBtn.innerHTML == 'Edit <i class="fas fa-pen"></i>'){
        return editBtn.innerHTML = 'Save <i class="fas fa-pen"></i>';
    }else{
        if(type === 'post'){
            // console.log('editing post');
            updatePost(id, text);
        }else if(type === 'comment'){
            // console.log('editing comment')
            updateComment(id, text);
        }
        return editBtn.innerHTML = 'Edit <i class="fas fa-pen"></i>';
    }
}

function updateComment(commentID, text){
    $.post("../includes/submit-comment.inc.php", {
        update: 'comment',
        commentId: commentID,
        text: text
    }).done((res) => {
        // console.log(res);
    })
}

function updatePost(postID, text){
    // console.log(postID)
    // console.log(text)
    $.post("../includes/submit-comment.inc.php", {
        update: 'post',
        postId: postID,
        text: text
    }).done((res) => {
        // console.log(res);
    })
}

function autoGrow (textarea) {
    if (textarea.scrollHeight > textarea.clientHeight) {
      textarea.style.height = textarea.scrollHeight + "px";
    }
}

function toggleTextArea(textarea){
    if(textarea.disabled){
        return textarea.disabled = false;
    }else{
        return textarea.disabled = true;
    }
}

// Resize textareas height;
$('.text textarea').each((index, element) => {

    // console.log($(element).height());
    // console.log($(element).prop('scrollHeight'));
    
// Setting textarea height so text is visible to anyone;
    const textAreaHeight = $(element).prop('scrollHeight');
    $(element).height(textAreaHeight);

})