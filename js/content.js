(() => {
  "use strict";
  
	const init = () => {
        $('#dropdown-menu select').addEventListener('change', regionChanged);
        $$('.logo').forEach((obj) => obj.addEventListener('error', removeLogo));
        //For dynamic content, when change reset listeners
		$(".box-container").addEventListener('DOMSubtreeModified', () => $$('.logo').forEach((obj) => obj.addEventListener('error', removeLogo)));

        if(sessionStorage.getItem("last_location")!=null)
            setRegion(sessionStorage.getItem("last_location"));
	};
	
    const regionChanged = (e) => {
        sessionStorage.setItem("last_location", e.target.options[e.target.selectedIndex].value);
        reloadCompanies(e.target.options[e.target.selectedIndex].value);
    };

    const setRegion = (region) => {
        reloadCompanies(region);
        $('#dropdown-menu form select [value="'+region+'"]').selected = true;
    };

	const httpGet = (url) => {
		let xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", url, false ); // false for synchronous request
		xmlHttp.send( null );
		return xmlHttp.responseText;
	};

    const reloadCompanies = (region) => {
        if(region=="all")
            $(".box-container").innerHTML = httpGet("../API/html.php?action=getCompanies");
        else
            $(".box-container").innerHTML = httpGet("../API/html.php?action=getCompaniesByRegion&argument="+region);
    };
    
    const removeLogo = (e) => e.target.remove();

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
