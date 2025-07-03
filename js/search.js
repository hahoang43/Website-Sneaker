document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.getElementById('search-button');
    const searchInput = document.getElementById('search-input');
    if (!searchBtn || !searchInput) return;

    searchBtn.onclick = function () {
        const keyword = searchInput.value.trim();
        if (keyword) {
            window.location.href = '/Website-Sneaker/page/timkiem.php?q=' + encodeURIComponent(keyword);
        }
    };

    searchInput.onkeypress = function (e) {
        if (e.key === 'Enter') {
            searchBtn.click();
        }
    };
})

$(document).ready(function() {
    $('#search-input').on('input', function() {
        let q = $(this).val();
        $('.suggest-list').remove();
        if (q.length > 1) {
            $.get('../backend/search_suggest.php', { q: q }, function(data) {
                let suggestions = JSON.parse(data);
                if (suggestions.length > 0) {
                    let html = '<ul class="suggest-list">';
                    suggestions.forEach(function(item) {
                        html += `<li class="suggest-item">${item}</li>`;
                    });
                    html += '</ul>';
                    $('.search-container').append(html);

                    $('.suggest-item').on('click', function() {
                        $('#search-input').val($(this).text());
                        $('.suggest-list').remove();
                        $('#search-button').click(); // Thực hiện tìm kiếm luôn
                    });
                }
            });
        }
    });
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-container').length) {
            $('.suggest-list').remove();
        }
    });
});