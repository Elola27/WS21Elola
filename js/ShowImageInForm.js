function show_image(fitxategia, hurrengoa) {
    var irudia = document.getElementById("imgirudia");

    if (!irudia) {
        // Irudia ez da existitzen
        irudia = document.createElement("img");
        irudia.id = "imgirudia";
        fitxategia.parentElement.insertBefore(irudia, document.getElementById(hurrengoa))
        irudia.style.maxWidth = "300px";
        irudia.style.maxHeight = "200px";
        irudia.style.width = 'auto';
        irudia.style.height = 'auto';

        var br = document.createElement("br");
        br.id = "irudiabr";
        fitxategia.parentElement.insertBefore(br, document.getElementById(hurrengoa))
    }

    var file = fitxategia.files[0];
    var reader  = new FileReader();

    reader.onload = function(e)  {
        irudia.src = e.target.result;
    }

    reader.readAsDataURL(file);
}

function hide_image() {
    var irudia = document.getElementById("imgirudia");
    irudia.parentElement.removeChild(irudia);

    var br = document.getElementById("irudiabr");
    br.parentElement.removeChild(br);
}


