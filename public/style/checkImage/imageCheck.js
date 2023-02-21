function imageCheck() {
    document.getElementById('iconFree').src = '/checkImage/images/green.gif'
}

function imageCheck2() {
    document.getElementById('iconFree').src = '/checkImage/images/red.gif'
}

function imageCheck3() {
    var imageElement = document.getElementById('iconFree');
    if (imageElement) {
        imageElement.remove();
    }
}





// title js


function size() {
    document.getElementById("roomTitle10").style.fontSize = "190%";
    document.getElementById("roomTitle10").style.backgroundColor = "#dcdcdc";
    console.log("oui")
}


function size2() {
    document.getElementById("roomTitle10").style.fontSize = "100%";
    console.log("Size2")
}


