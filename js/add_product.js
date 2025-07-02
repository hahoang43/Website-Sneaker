$(document).ready(function() {
    
    $(document).on('click', '.load-content', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $('#right').load(url);
    });
});