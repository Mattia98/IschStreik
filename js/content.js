(() => {
  "use strict";
  
	const init = () => {
        $('#dropdown-menu select').addEventListener('change', regionChanged);
        $$('.logo').forEach((obj) => obj.addEventListener('error', removeLogo));
        //For dynamic content: when change, reset listeners
		$(".box-container").addEventListener('DOMSubtreeModified', () => $$('.logo').forEach((obj) => obj.addEventListener('error', removeLogo)));

        //Restore region or display all if no region is savedw
        if(sessionStorage.getItem("last_location")!=null)
            setRegion(sessionStorage.getItem("last_location"));
        else
            reloadCompanies("all");
        
        //Check for location support and get location
        if (navigator.geolocation && sessionStorage.getItem("last_location")==null)
            navigator.geolocation.getCurrentPosition(setRegionFromPosition, (e) => console.error("location: "+e.message));

	};

    const setRegionFromPosition = (position) => {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;
		let response = JSON.parse(httpGet("https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=AIzaSyADHXzFMh1Hh01uVyRzuPvav-kmzYltFwo"));
		
        let region = response.results[0].address_components.find((obj) => obj.types[0] == "administrative_area_level_1").long_name;
		sessionStorage.setItem("last_location", region);
        setRegion(region);
    };
	
    const regionChanged = (e) => {
        sessionStorage.setItem("last_location", e.target.options[e.target.selectedIndex].value);
        reloadCompanies(e.target.options[e.target.selectedIndex].value);
    };

    const setRegion = (region) => {
        reloadCompanies(region);
        $('#dropdown-menu form select [value="'+region+'"]').selected = true;
    };

    const reloadCompanies = (region) => {
        if(region=="all")
            $(".box-container").innerHTML = httpGet("../API/html.php?action=getCompanies");
        else
            $(".box-container").innerHTML = httpGet("../API/html.php?action=getCompaniesByRegion&argument="+region);
    };

    const httpGet = (url) => {
		let xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", url, false ); // false for synchronous request
		xmlHttp.send( null );
		return xmlHttp.responseText;
	};

    const removeLogo = (e) => e.target.remove();

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
