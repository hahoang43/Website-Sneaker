
$(document).ready(function(){
    let current = 0;
    const bannerCount = $('.banner-img').length;
    setInterval(function(){
        current = (current + 1) % bannerCount;
        $('.banner-inner').css('transform', 'translateX(' + (-current * 100) + '%)');
    }, 3000);
});
