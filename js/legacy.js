if(sessionStorage.getItem("legacyPopupClosed")==null || sessionStorage.getItem("legacyPopupClosed")=="false") {
    legacyPopup();
    sessionStorage.setItem("legacyPopupClosed", false);
}
document.getElementById("legacy-popup-close").addEventListener('click', closeLegacyPopup);


function legacyPopup() {
    document.getElementById("legacy-popup").setAttribute('class', 'popup-open');
    document.getElementById("curtain").setAttribute('class', 'curtain-closed');
}

function closeLegacyPopup() {
    document.getElementById("legacy-popup").setAttribute('class', 'popup-closed');
    document.getElementById("curtain").setAttribute('class', 'curtain-open');
    sessionStorage.setItem("legacyPopupClosed", true);
}
