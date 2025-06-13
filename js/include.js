function includeHTML(id, file) {
    fetch(file)
        .then(response => response.text())
        .then(data => {
            document.getElementById(id).innerHTML = data;
        });
}

var pathPrefix = window.location.pathname.includes('/danhmuc/') ? '../' : '';
includeHTML("header", pathPrefix + "header-footer/header.html");
includeHTML("footer", pathPrefix + "header-footer/footer.html");