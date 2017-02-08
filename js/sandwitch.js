(() => {
  "use strict";
  
	const init = () => {
		$('#sandwitch').addEventListener('click', sandwitch);
		$('#language-selector').addEventListener('click', languagePopup);
		$('#description-selector').addEventListener('click', descriptionPopup);
        $('#description-popup i').addEventListener('click', closeAll);
        $('#language-popup i').addEventListener('click', closeAll); 
		$('#curtain').addEventListener('click', closeAll);
		$$('.logo').forEach((obj) => obj.addEventListener('error', removeLogo));
		$$('.logo-cp').forEach((obj) => obj.addEventListener('error', replaceLogo));
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

	const removeLogo = (e) => e.srcElement.remove();

	const replaceLogo = (e) => e.srcElement.parentElement.innerHTML = "<span>"+e.srcElement.alt+"</span>";
	
	const isNavOpen = () => $('nav').classList.contains('nav-open');

	const isLangPopupOpen = () => $('#language-popup').classList.contains('popup-open');
    
	const isDescPopupOpen = () => $('#description-popup').classList.contains('popup-open');
		
	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
