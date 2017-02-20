(() => {
  "use strict";
  
	const init = () => {
		$('#dropdown-menu select').addEventListener('change', regionChanged);
	};
	
    const regionChanged = (e) => {
        let region = e.target.options[e.target.selectedIndex].value;
        $(".box-container").innerHTML = httpGet("../API/html.php?action=getCompaniesByRegion&argument="+region);
    };

	const httpGet = (url) => {
		let xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", url, false ); // false for synchronous request
		xmlHttp.send( null );
		return xmlHttp.responseText;
	}

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
