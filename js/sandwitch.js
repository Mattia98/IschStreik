(() => {
  "use strict";
  
	const init = () => {
		$('#sandwitch').addEventListener('click', sandwitch);
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
	
	const isNavOpen = () => $('nav').classList.contains('nav-open');
		
	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();