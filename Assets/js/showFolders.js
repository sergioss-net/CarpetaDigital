document.addEventListener('DOMContentLoaded', function () {

}, false);

window.addEventListener('load', function () {
    getData();
}, false);

function getData() {
    var path = ""; var folder = "";
    $.ajax({
        url: '../utils/getFolder.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            data.forEach(function (objeto) {
                idFolder=objeto.Id_Carpeta;
                mainFolder = objeto.Id_Carpeta_Padre;
                folderName = objeto.Nombre_Carpeta;
                if (mainFolder === null) {
                    crearCard(idFolder,mainFolder, folderName);
                }else{
                    
                }
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

function crearCard(idFolder, mainFolder, folderName) {
    var card = $("<div>", { class: "card text-center" }); 
    var cardBody = $("<div>", { class: "card-body d-flex align-items-center justify-content-center flex-column" });
    var iconoCarpeta = $("<i>", { id: mainFolder, class: "bi bi-folder-fill foldersize folderColor", style: "cursor: pointer;" });
    
    iconoCarpeta.on("click", function() {
        enterFolder(idFolder);
    });
    
    cardBody.append(iconoCarpeta);
    var textoCarpeta = $("<p>", { class: "folderText" }).text(folderName);
    cardBody.append(textoCarpeta);
    card.append(cardBody);
    $(".folderDesign").append(card);
}

function enterFolder(folderId) {
    window.location.href = "?folderId=" + folderId;
}
