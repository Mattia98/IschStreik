(() => {
  "use strict";
  
	const init = () => {
		if (navigator.geolocation && sessionStorage.getItem("last_location")==null) {
            navigator.geolocation.getCurrentPosition(successFunction, (e) => console.log("failed: "+e.message));
			console.log("inside");
		} else {
			console.log("no location or item set");
		}
	};
	
    const successFunction = (position) => {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;
		let response = JSON.parse(httpGet("https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=AIzaSyADHXzFMh1Hh01uVyRzuPvav-kmzYltFwo"));
		
        let region = response.results[0].address_components.find((obj) => obj.types[0] == "administrative_area_level_1").long_name;
		sessionStorage.setItem("last_location", region);

		let regionElement = document.createElement("option");
		regionElement.innerHTML = region;
		regionElement.selected = "selected";
		$("#dropdown-menu form select").add(regionElement);
		$("#dropdown-menu form select").form.submit();
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
