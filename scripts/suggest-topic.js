$(".input-topic").keyup(() => {
    
    const word = $('input[name="topic"]').val();

    $.post("../includes/return-topics.inc.php", {
        word: word
    }).done((result) => {
        if(result !== 'false'){
            
            $(".suggestions").html('');
            if(result !== ''){
                const topics = JSON.parse(result);

                for(const row in topics){
                    
                    const p = $('<p>');
                    p.html(topics[row].name);
                    
    
                    const suggestion = $('<div>', {class: 'suggestion'});
                    suggestion.html(p);
                    // suggestion.data('id', topics[row].id);
                    // console.log(suggestion.data());

                    suggestion.on("click", () => {
                        const input = $('input[name="topic"]');

                        const sugg = $(p).text();
                        // console.log(sugg)
                        $(".suggestions").html('');
                        input.val(sugg);
                    })
    
                    $(".suggestions").append(suggestion);
                }
            }
        }
    })
})