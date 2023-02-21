function toggleDropdown() {
    var dropdown = document.getElementById("dropdown");
    dropdown.style.display = (dropdown.style.display == "block") ? "none" : "block";
}

function showContent(n) {
    var content = document.getElementById("content" + n);
    var contents = document.getElementsByClassName("dropdown-content");

    // Cacher tous les contenus
    for (var i = 0; i < contents.length; i++) {
        contents[i].style.display = "none";
    }

    // Afficher le contenu sélectionné
    content.style.display = "block";
}