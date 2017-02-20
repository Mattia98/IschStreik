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
		$$('.logo').forEach((obj) => obj.addEventListener('error', removeLogo));
		$$('.logo-cp').forEach((obj) => obj.addEventListener('error', replaceLogo));

		//For dynamic content, when change reset listeners
		$('#dropdown-menu select').addEventListener('change', () => setTimeout(() => $$('.logo').forEach((obj) => obj.addEventListener('error', removeLogo)) , 1));
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
			$('#list-feedback').setAttribute('class', 'popup-closed');
		} else {
			$('#list-feedback').setAttribute('class', 'popup-open');
        }
	};

	const removeLogo = (e) => e.target.remove();

	const replaceLogo = (e) => e.target.parentElement.innerHTML = "<span>"+e.target.alt+"</span>";
	
	const isNavOpen = () => $('nav').classList.contains('nav-open');

	const isLangPopupOpen = () => $('#language-popup').classList.contains('popup-open');
    
	const isDescPopupOpen = () => $('#description-popup').classList.contains('popup-open');
    
	const isFeedbackDropdownOpen = () => $('#list-feedback').classList.contains('popup-open');
		
	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
