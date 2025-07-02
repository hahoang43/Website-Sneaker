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