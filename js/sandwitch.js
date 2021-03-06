(() => {
  "use strict";
  
	const init = () => {
		$('#sandwitch').addEventListener('click', sandwitch);
		$('#language-selector').addEventListener('click', languagePopup);
		$('#description-selector').addEventListener('click', descriptionPopup);
        $('#description-popup i').addEventListener('click', closeAll);
        $('#language-popup i').addEventListener('click', closeAll);
        $('#li-feedback').addEventListener('click', listFeedback);
		$('#curtain').addEventListener('click', closeAll);
        $('.list-up li').addEventListener('click', triggerSwitch);

		//Replace logo with text in company page
		$$('.logo-cp').forEach((obj) => obj.addEventListener('error', replaceLogo));

		//Show popup on first visit
		if(localStorage.getItem("firsttime")==null) {
			descriptionPopup();
			localStorage.setItem("firsttime", false);
		}

		// Workaround SG width
		window.addEventListener('resize', resize);
		setTimeout(resize, 200);
	};
	
	const closeAll = () => {
		$('#language-popup').setAttribute('class', 'popup-closed');
		$('#description-popup').setAttribute('class', 'popup-closed');
		$('nav').setAttribute('class', 'nav-closed');
		$('#curtain').setAttribute('class', 'curtain-open');
		$('body').setAttribute('style', '');
		$('main').setAttribute('style', '');
	};

	const sandwitch = () => {
		let state = !isNavOpen();
		closeAll();
		if(state) {
			$('nav').setAttribute('class', 'nav-open');
			$('#curtain').setAttribute('class', 'curtain-closed');
			$('body').setAttribute('style', 'overflow:hidden');
			$('main').setAttribute('style', 'filter: blur(5px);');
		}
	};

	const languagePopup = () => {
		let state = !isLangPopupOpen();
		closeAll();
		if (state) {
			$('#language-popup').setAttribute('class', 'popup-open');
			$('#curtain').setAttribute('class', 'curtain-closed');
			$('body').setAttribute('style', 'overflow:hidden');
			$('main').setAttribute('style', 'filter: blur(5px);');
		}
	};
    
	const descriptionPopup = () => {
		let state = !isDescPopupOpen();
		closeAll();
		if (state) {
			$('#description-popup').setAttribute('class', 'popup-open');
			$('#curtain').setAttribute('class', 'curtain-closed');
			$('body').setAttribute('style', 'overflow:hidden');
			$('main').setAttribute('style', 'filter: blur(5px);');
		}
	};
    
    const listFeedback = () => {
		if (isFeedbackDropdownOpen()) {
			$('#list-feedback').setAttribute('class', 'dropdown-closed');
		} else {
			$('#list-feedback').setAttribute('class', 'dropdown-open');
        }
	};

	const resize = () => 
		$('#sciopero-generale p a').style.width = 
		(Math.floor(($('body').clientWidth)/($('.box-container a').clientWidth+(0.0085*$('.box-container a').clientWidth)))
		*($('.box-container a').clientWidth+3.2)
		-(($('.box-container a').clientWidth-$('.box-container .box').clientWidth)) + "px")
	;
    //-(($('.box-container a').clientWidth-$('.box-container .box').clientWidth)/2+16)
    const triggerSwitch = () => $('.onoffswitch input[type=checkbox]').checked = !$('.onoffswitch input[type=checkbox]').checked;
	
	const replaceLogo = (e) => e.target.parentElement.innerHTML = "<span>"+e.target.alt+"</span>";
	
	const isNavOpen = () => $('nav').classList.contains('nav-open');

	const isLangPopupOpen = () => $('#language-popup').classList.contains('popup-open');
    
	const isDescPopupOpen = () => $('#description-popup').classList.contains('popup-open');
    
	const isFeedbackDropdownOpen = () => $('#list-feedback').classList.contains('dropdown-open');
		
	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
