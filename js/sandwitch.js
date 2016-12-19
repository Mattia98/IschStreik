(() => {
  "use strict";
  
	const init = () => {
		$('#sandwitch').addEventListener('click', sandwitch);
		$('#language-selector').addEventListener('click', languagePopup);
	};
	
	const sandwitch = () => {
		if (isNavOpen()) {
			$('nav').setAttribute('class', 'nav-closed');
			$('#curtain').setAttribute('class', 'curtain-open');
			$('body').setAttribute('style', '');
		} else {
			$('nav').setAttribute('class', 'nav-open');
			$('#curtain').setAttribute('class', 'curtain-closed');
			$('body').setAttribute('style', 'overflow:hidden');
		}
	};

	const languagePopup = () => {
		if (isLangPopupOpen()) {
			$('#language-popup').setAttribute('class', 'language-popup-closed');
			$('#curtain').setAttribute('class', 'curtain-open');
			$('body').setAttribute('style', '');
			$('main').setAttribute('style', '');
		} else {
			$('#language-popup').setAttribute('class', 'language-popup-open');
			$('#curtain').setAttribute('class', 'curtain-closed');
			$('body').setAttribute('style', 'overflow:hidden');
			$('main').setAttribute('style', 'filter: blur(5px);');
		}
	};
	
	const isNavOpen = () => $('nav').classList.contains('nav-open');

	const isLangPopupOpen = () => $('#language-popup').classList.contains('language-popup-open');
		
	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
