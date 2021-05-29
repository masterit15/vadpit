// // Import jQuery module (npm i jquery)
import $ from 'jquery'
import detect from '../libs/browser.detect.min'
import {gsap, TweenMax} from 'gsap'
window.jQuery = $
window.$ = $

document.addEventListener('DOMContentLoaded', () => {
	const tl = gsap.timeline()
	// определяем что за браузер
	var user = detect.parse(navigator.userAgent);
	console.log(user.browser);
	if (user.browser.family == 'IE'){
			$('.header').addClass('damn_it_internet_explorer')
			alert('Ваш браузер Internet Explorer, сайт может отображается не коректно, скачайте нормальный браузер!')
	}
	$('.card_item_btn').on('click', function(){
		let adoptGetForm = `<form class="form form_adopt_get">
													<input type="text" name="name" placeholder="Ваше имя" required>
													<input type="email" name="email" placeholder="Телефон" required>
													<input type="text" name="phone" placeholder="Телефон" required>
													<button type="submit">Отправить</button>
												</form>`
	})
	$('.volunteer_item_action').on('click', function(){
		$('.volunteer_item').removeClass('active')
		if($('.form_volunteer') && $('.form_volunteer').length > 0){
			$('.form_volunteer').remove()
		}
		let volunteerForm = `<form class="form form_volunteer">
													<input type="text" name="name" placeholder="Ваше имя" required>
													<input type="text" name="phone" placeholder="Телефон" required>
													<button type="submit">Отправить</button>
												</form>`
		let parent = $(this).parent('.volunteer_item').addClass('active')
		$(parent).append(volunteerForm)
		$(parent).find('.close').on('click', function(){
			$('.form_volunteer').fadeOut(200).remove()
			$(parent).removeClass('active')
		})
		
	})
	$('#mobnav').on('click', function(){
		$(this).toggleClass('active')
		if($(this).hasClass('active')){
			$('.header').addClass('full')
			setTimeout(()=>{
				$('.nav_wrap').slideDown(200)
			}, 100)
		}else{
			$('.nav_wrap').slideUp(200)
			// setTimeout(()=>{
			// 	$('.header').removeClass('full')
			// }, 100)
		}
	})
	$('.section_nav_link').on('click', function(){
		let elId = $(this).attr('href')
		$('html, body').animate({
				scrollTop: $(elId).offset().top
		}, 800);
	})
	// табы
	$('.tabs_action_btn').on('click', function(){
		$('.tabs_action_btn').removeClass('active')
		$('.tabs_content').removeClass('active')
		let index = $(this).addClass('active').data('item')
		$('.tabs_content').fadeOut(200)
		$('.tabs_content[data-content="' + index + '"]').addClass('active').fadeIn(200)
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
