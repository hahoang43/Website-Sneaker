$(document).ready(function() {
    // Xử lý click vào các liên kết có class load-content
    $(document).on('click', '.load-content', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('#right').load(url);
    });
});