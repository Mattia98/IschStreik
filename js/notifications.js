(() => {
  "use strict";
  
	const init = () => {
        if(localStorage.getItem("notifications_unsupported"))
            return;
        
        if (!("Notification" in window)) {
            alert("This browser does not support desktop notifications! Please use another browser.");
            localStorage.setItem("notifications_unsupported", false);
        } else {
            Notification.requestPermission();
            if(getSelectedCompanies() == null)
            	setSelectedCompanies([0]);
				$('#notification-test').addEventListener('click', testNotification);
            $$('.bell').forEach((obj) => obj.addEventListener('click', bellClicked));
            $$('.bell').forEach((obj) => updateBell(obj));
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

    const testNotification = (jsonData) => {
        let data;// = JSON.parse(jsonData);
        data = [{cid: 1, name: "Trenitalia"}, {cid: 3, name: "SAD"}, {cid: 25, name: "atap di pordenone"}];
        let wantCompanies = localStorage.getItem("selected_companies");
        
        let interestedCompanies = data.filter((obj) => wantCompanies.includes(obj.cid));
        console.log(interestedCompanies);

        interestedCompanies.forEach(makeNotificationFromCompany);
    };

    const makeNotificationFromCompany = (company) => {
        let options = {
            body: company.name+' is striking!',
            icon: '../media/logos/companies/'+company.name+'.png',
            badge: '../favicon.png'
        };

        let not = new Notification("Strike!", options);
        not.onclick = () => {
            //window.location.replace("?site=company&id="+cid);
            event.preventDefault(); // prevent the browser from focusing the Notification's tab
            window.open("?site=company&id="+company.cid, '_blank');
        };
    };

    const testNotificationORIG = () => {
        let cid = prompt("CID PLEASE:");
        const options = {
            body: 'Redit to cid "'+cid+'"',
            icon: '../favicon.png',
            badge: '../favicon.png'
        };

        let not = new Notification("Hi!", options);
        not.onclick = () => {
            //window.location.replace("?site=company&id="+cid);
            event.preventDefault(); // prevent the browser from focusing the Notification's tab
            window.open("?site=company&id="+cid, '_blank');
        };
    };
    
   const getSelectedCompanies = () => JSON.parse(localStorage.getItem("selected_companies"));
   
   const setSelectedCompanies = (companies) => localStorage.setItem("selected_companies", JSON.stringify(companies));

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
