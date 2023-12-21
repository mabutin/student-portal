function hideSuccessMessage() {
    var successMessageElement = document.getElementById("successMessage");
    if (successMessageElement) {
        successMessageElement.style.display = "none";
    }
}
window.onload = function () {
    setTimeout(hideSuccessMessage, 3000); 
};

function handleFileSelection(input) {
    var uploadButton = document.getElementById("uploadButton");
    var selectedFileName = document.getElementById("selectedFileName");

    if (input.files.length > 0) {
        selectedFileName.textContent = "Selected File: " + input.files[0].name;
        uploadButton.style.display = "inline-block";
    } else {
        selectedFileName.textContent = "";
        uploadButton.style.display = "none";
    }
}