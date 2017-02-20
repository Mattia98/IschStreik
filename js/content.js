(() => {
  "use strict";
  
	const init = () => {
        $('#dropdown-menu select').addEventListener('change', regionChanged);
        if(sessionStorage.getItem("last_location")!=null)
            setRegion(sessionStorage.getItem("last_location"));
	};
	
    const regionChanged = (e) => {
        sessionStorage.setItem("last_location", e.target.options[e.target.selectedIndex].value);
        changeRegion(e.target.options[e.target.selectedIndex].value);
    };

    const setRegion = (region) => {
        changeRegion(region);
        $('#dropdown-menu form select [value="'+region+'"]').selected = true;
    };

	const httpGet = (url) => {
		let xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", url, false ); // false for synchronous request
		xmlHttp.send( null );
		return xmlHttp.responseText;
	};

    const changeRegion = (region) => $(".box-container").innerHTML = httpGet("../API/html.php?action=getCompaniesByRegion&argument="+region);

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
