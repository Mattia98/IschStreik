(() => {
  "use strict";
  
	const init = () => {
        if(localStorage.getItem("notifications_unsupported"))
            return;
        
        console.log(localStorage.getItem("notifications_status"));
        $('#settingsswitcher').checked = localStorage.getItem("notifications_status") === 'true';
        $('#settingsswitcher').addEventListener('change', notificationSwitch);
        if(localStorage.getItem("notifications_status") === 'true') {
        		$('#notification-test').addEventListener('click', testNotification);
            $$('.bell').forEach((obj) => obj.addEventListener('click', bellClicked));
            $$('.bell').forEach((obj) => updateBell(obj));
        }
	};
	
    const notificationSwitch = (e) => {
        console.log("change");
        if (!("Notification" in window)) {
            alert("This browser does not support desktop notifications! Please use another browser.");
            localStorage.setItem("notifications_unsupported", true);
        } else {
            if($('#settingsswitcher').checked) {
                localStorage.setItem("notifications_status", true);
                Notification.requestPermission();
                if(getSelectedCompanies() == null)
            	    setSelectedCompanies(["0"]);
            	 
            	 $('#notification-test').addEventListener('click', testNotification);
            	 $$('.bell').forEach((obj) => obj.addEventListener('click', bellClicked));
            	 $$('.bell').forEach((obj) => updateBell(obj));
            } else {
                localStorage.setItem("notifications_status", false);
            }
        }
    };

    const bellClicked = (e) => {
        let id = e.target.dataset.cid;
        if(getSelectedCompanies().includes(id))
        		setSelectedCompanies(getSelectedCompanies().filter((obj) => obj != id));
        else
            setSelectedCompanies(getSelectedCompanies().concat([id]));
        
        updateBell(e.target);
    };

    const updateBell = (bell) => {
        let id = bell.dataset.cid;
        if(getSelectedCompanies().includes(id))
            bell.innerHTML = "notifications_active";
        else
            bell.innerHTML = "notifications_off";
    };

    const testNotification = () => {
        let companies = JSON.parse(httpGet("../API/?action=getCompanies"));
        if(companies.length == 0)
            alert("No strikes for today and tomorrow!");
                
        let interestedCompanies = companies.filter((obj) => getSelectedCompanies().includes(obj.cid+""));
        console.log(interestedCompanies);

        interestedCompanies.forEach(makeNotificationFromCompany);
    };

    const makeNotificationFromCompany = (company) => {
        let options = {
            body: company.name+' is striking!',
            icon: '../media/logos/companies/'+company.nameCode+'.png',
            badge: '../media/icons/favicon/favicon transparent.png',
            "vibrate": [50, 50, 50, 50, 50, 200, 50, 50, 50, 50, 50, 200, 50, 50, 50, 50, 50, 200, 50, 50, 50, 50, 50],
            data:	company.cid
        };
        navigator.serviceWorker.getRegistration().then((r)=>r.showNotification("Strike!", options));
    };

    const httpGet = (url) => {
		let xmlHttp = new XMLHttpRequest();
		xmlHttp.open( "GET", url, false ); // false for synchronous request
		xmlHttp.send( null );
		return xmlHttp.responseText;
	}
    
    const getSelectedCompanies = () => JSON.parse(localStorage.getItem("selected_companies"));
   
    const setSelectedCompanies = (companies) => localStorage.setItem("selected_companies", JSON.stringify(companies));

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
