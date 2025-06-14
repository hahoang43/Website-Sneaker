document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('search-button').addEventListener('click', function () {
        const keyword = document.getElementById('search-input').value.trim();
        if (keyword !== '') {
            window.location.href = `/page/timkiem.html?keyword=${encodeURIComponent(keyword)}`;
        }
    });

    document.getElementById('search-input').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            document.getElementById('search-button').click();
        }
    });
});
