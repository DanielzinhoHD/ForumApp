// Make search bar works;
if(window.innerWidth > 600){
    $("nav ul li form input").keyup(() => {
    
        const word = $('nav ul li form input').val();
    
        $.post("../includes/searchbar-suggestions.inc.php", {
            word: word
        }).done((result) => {
            // console.log(result !== '')
            if(result !== ''){
                $(".navbar-suggestions").html('');
                // console.log(result);
                const res = JSON.parse(result);
            // Checking each array retrieved;
                for(const key in res){
                    // console.log(res[key]);
                    let array = res[key];
                // Checking if array has any result;
                    if(array != false){
                    // Checking which array is it;
                        if(array[0].hasOwnProperty('name')){
                        // Creating separator;
                            const separator = $("<div>", {class: 'separator'});
                            separator.text("Post titles:")
                            $(".navbar-suggestions").append(separator);
                        // Creating each suggestion;
                            for(const i in array){
                                suggestionCreator(array[i].name, {nId: array[i].id});
                            }
    
                        }else if(array[0].hasOwnProperty('text')){
                        // Creating separator;
                            const separator = $("<div>", {class: 'separator'});
                            separator.text("Post questions:")
                            $(".navbar-suggestions").append(separator);
                        // Creating each suggestion;
                            for(const i in array){
                                suggestionCreator(array[i].text, {tId: array[i].id});
                            }
    
                        }else if(array[0].hasOwnProperty('comment')){
                        // Creating separator;
                            const separator = $("<div>", {class: 'separator'});
                            separator.text("Comments:")
                            $(".navbar-suggestions").append(separator);
                        // Creating each suggestion;
                            for(const i in array){
                                suggestionCreator(array[i].comment, {cId: array[i].id, cPostId: array[i].id_post});
                            }
                        }
                    }
                }            
            }else{
            // Clean suggestions if input is empty;
                $(".navbar-suggestions").html('');
            }
        })
    });
}

function suggestionCreator(item, data){
    const p = $('<p>');
    p.html(item);
    // console.log(data);

// Creating each suggestion;
    const a = $('<a>', {class: 'navbar-suggestion-link'});
    
    if(data.hasOwnProperty('nId')){
        a.attr('href', '../views/post.php?id='+data.nId);
    }else if(data.hasOwnProperty('tId')){
        a.attr('href', '../views/post.php?id='+data.tId);
    }else if(data.hasOwnProperty('cId')){
        a.attr('href', '../views/post.php?id='+data.cPostId+'&cId='+data.cId);
    }

    const suggestion = $('<div>', {class: 'navbar-suggestion'});

    suggestion.html(p);
    a.html(suggestion);

    $(".navbar-suggestions").append(a);
}

// Make form not submittable if there is no input;
$("nav ul li form input").keyup(() => {
    const value = $("nav ul li form input").val();

    if(value !== ''){
        $("nav ul li form button").attr('type', 'submit');
    }else{
        $("nav ul li form button").attr('type', 'button');
    }
});

// Toggle navbar's responsive class;
$('.bars').on('click', () => {
    $('.nav-container').toggleClass('responsive');
});