// // Import jQuery module (npm i jquery)
import $ from 'jquery'
import {gsap, TweenMax} from 'gsap'
window.jQuery = $
window.$ = $

document.addEventListener('DOMContentLoaded', () => {
	const tl = gsap.timeline()

	// табы
	$('.tabs_action_btn').on('click', function(){
		$('.tabs_action_btn').removeClass('active')
		$('.tabs_content').removeClass('active')
		let index = $(this).addClass('active').data('item')
		$('.tabs_content[data-content="' + index + '"]').addClass('active')
	})
	// анимируем цифры
	const numberBlock = document.querySelector(".count");
	var scores = [];
	let numberElement = $('.count_item');
	for (let i = 0; i < numberElement.length; i++) {
			scores.push({ score: parseInt($(numberElement[i]).attr('data-start')), end: parseInt($(numberElement[i]).attr('data-end')) })
	}
	if (numberBlock !== null) {
			window.addEventListener('scroll', function () {
					const numberBlockPos = numberBlock.offsetTop,
							winHeight = window.innerHeight;
					let winScrollTop = window.scrollY,
							scrollToElem = winScrollTop + winHeight
					if ((scrollToElem + 30 > numberBlockPos) && $('.count_item').children('div.count_item_num').text() == 0) {
							for (let i = 0; i < scores.length; i++) {
									TweenMax.to(scores[i], 4, { score: scores[i].end, onUpdate: updateHandler, onUpdateParams: [i] });
							}
					}

			});
	}
	function updateHandler(index) {
			let numberBlock = document.querySelector('.count_item[data-target="' + index + '"] div');
			numberBlock.innerHTML = scores[index].score.toFixed(0);
	}
	
})
