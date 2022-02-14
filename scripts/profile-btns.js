const changePfpBtn = $('.pfp');
const delAccountBtn = $('.delete');
const userId = $('.account').data('userId');
const pfpBtn = $('#input-file');

pfpBtn.change(() => {
    // console.log(pfpBtn[0].files);

    const files = pfpBtn[0].files;
    const fd = new FormData();

    if(files.length > 0){

        fd.append('input-file', files[0]);
    // Sending users file;
        $.ajax({
            url: '../includes/pfp.inc.php',
            type: 'POST',
            data: fd,
            contentType : false,
            processData : false
        }).done((res) => {
            if(res !== ''){
                console.log(res);
            }else{
                alert('You need to select an image (png, jpeg or jpg)')
            }
        })
    }
    
})

const popup = $('.popup-screen');

delAccountBtn.click(() => {
    popup.addClass('important');

    $('#cancel-btn').on('click', () => {
    // Cancel deletting action;
        popup.removeClass('important');
    })

    $('#delete-btn').on('click', () => {
    // Deleting account;
        $.post("../includes/delete.inc.php", {
            delete: 'account',
            id: userId
        }).done((res) => {
            location.href = '../includes/logout.inc.php';
        })
    });
})