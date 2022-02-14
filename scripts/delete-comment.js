const popup = $('.popup-screen');

$('.remove-btn').each((index, element) => {
    $(element).on('click', ()=>{
    // Showing confirmation popup;
        popup.addClass('important');

    // Get URL id param;
        const URL_str = location.href;
        const url = new URL(URL_str);
        const param = url.searchParams.get('id');

    // Getting element parent;
        const parent = element.offsetParent;
    
    // Figure out if clicked in a comment or the post by id;
        const commentId = parent.dataset.commentId;
        const postId = parent.dataset.postId;

        if(postId == param){
        // Checking for each btn clicked;
            $('#delete-btn').on('click', () => {
            // Deleting the entire post;
                $.post('../includes/delete.inc.php', {
                    textID: postId,
                    delete: 'post'
                }).done((result) => {
                    // console.log(result);
                    location.href = '../index.php';
                })
            });

            $('#cancel-btn').on('click', () => {
                // Cancel deletting action;
                popup.removeClass('important');
            })
            
        }else{
        // Checking for each btn clicked;
            $('#delete-btn').on('click', () => {
            // Deleting each comment;
                $.post('../includes/delete.inc.php', {
                    textID: commentId,
                    delete: 'comment'
                }).done((result) => {
                    result = JSON.parse(result);
                    // console.log(result.bool);

                // Change the users comment to a deleted comment template;
                    if(result.bool === true){                   
                        const pub = parent.querySelector('.publication');
                        const editBtn = pub.querySelector('.edit-comment');
                        const removeBtn = parent.querySelector('.remove-btn');
                        const text = pub.querySelector('.text');
                        if(text){
                            parent.removeChild(removeBtn);
                            text.classList.remove('text');
                            text.classList.add('deleted');
    
                            text.innerText = 'This comment was deleted by a moderator!';
                        }
                        editBtn.remove();
                        
                    }else{
                        console.log('Something went wrong!');
                    }
                })

                popup.removeClass('important');
            });

            $('#cancel-btn').on('click', () => {
            // Cancel deletting action;
                popup.removeClass('important');
            })
        }
    })
})