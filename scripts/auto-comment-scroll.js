const cURL_str = location.href;
const curl = new URL(cURL_str);
const commentId = curl.searchParams.get('cId');

const wh = $(window).height();
// console.log(commentId);
if(commentId){
// After scroll ends, add class animation to comment;
    var scrollTimeout;
    addEventListener('scroll', (e) => {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            $('*[data-comment-id="'+commentId+'"').addClass('scrolledTo');
        }, 100);
    });
    // console.log($('*[data-comment-id="'+commentId+'"').offset().top - getVHPercentage(15));

    window.scrollTo({
        top: $('*[data-comment-id="'+commentId+'"').offset().top - getVHPercentage(15), behavior: 'smooth'
    });


    function getVHPercentage(percentage){
        return wh * percentage / 100;
    }
}