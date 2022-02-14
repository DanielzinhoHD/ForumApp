$(".search").keyup(() => {
    
    const word = $('input[name="search-accounts"]').val();
    // console.log(word);

    $.post("../includes/return-accounts.inc.php", {
        word: word
    }).done((result) => {
        try{
            const res = JSON.parse(result);
            // console.log(res);

            if(res !== 'false'){
                $(".account-list").html('');

                for (let key in res){
                    // console.log(res[key]);
                // Creating each HTML element;
                    const a = $("<a>", {href:`../views/profile.php?id=${res[key].id}`});
                    const account = $("<div>", {class:"account"});
                    const img = $("<img>", {src:"../imgs/face1.png"}); //Change it to res[key].img
                    const accContainer = $("<div>", {class: 'account-container'});
                    const accBody = $("<div>", {class: 'account-body'});
                    const accName = $("<p>", {class: 'account-name'});
                    const creationDate = $("<p>", {class: 'creation-date'});
                    const accFeet = $("<div>", {class: 'account-feet'});
                    const accPosts = $("<p>", {class: 'account-posts'});
                    const accComments = $("<p>", {class: 'account-comments'});
                // Creating each item;
                    a.html(account);
                    account.append(img);
                    account.append(accContainer);
                    accContainer.append(accBody);
                        accBody.append(accName);
                            accName.text(ucFirst(res[key].name));
                        accBody.append(creationDate);
                        // Formatting date;
                            const options = {
                                day: '2-digit', 
                                month: '2-digit', 
                                year:'2-digit'
                            };
                            const date = new Date(res[key].creation_date);
                            creationDate.text(date.toLocaleDateString('en-US', options));
                    accContainer.append(accFeet);
                        accFeet.append(accPosts);
                        // Checks if post is equals 1 or not and print 'post(s)';
                            accPosts.text(+(res[key].posts_amount) == 1 ? +(res[key].posts_amount) + ' post' : +(res[key].posts_amount) + ' posts');
                        accFeet.append(accComments);
                            accComments.text(+(res[key].comments_amount) == 1 ? +(res[key].comments_amount) + ' comment' : +(res[key].comments_amount) + ' comments');

                    $(".account-list").append(a);
                }
            }else{

            }
        }catch(e){
            console.log(e);
        }
        
    })
})

function ucFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}