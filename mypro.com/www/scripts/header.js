function open_basket() {
	document.querySelector("#back").classList.add('background_close');
	document.querySelector("#basket").classList.add('basket');
	document.querySelector("#basket").classList.remove('display_close');
	window.addEventListener('scroll', noScroll);
}

function close_basket() {
	document.querySelector("#back").classList.remove('background_close');
	document.querySelector("#basket").classList.remove('basket');
	document.querySelector("#basket").classList.add('display_close');

	window.removeEventListener('scroll', noScroll);
}

function noScroll() {
  window.scrollTo(0, 0);
}