// // Import jQuery module (npm i jquery)
import $ from 'jquery'
import detect from '../libs/browser.detect.min'
import {gsap, TweenMax} from 'gsap'
window.jQuery = $
window.$ = $
const datepicker = require('air-datepicker')
document.addEventListener('DOMContentLoaded', () => {
	const tl = gsap.timeline()
	// определяем что за браузер

	$('.datepicker-here').datepicker({
		range: true,
		onSelect: function (formattedDate, date, inst){
			console.log(formattedDate);
		}
	})
	$(document).on("click", function (event) {
    if (
		!$(event.target).hasClass('volunteer_item_action') &&
		!$(event.target).hasClass('card_item_btn') && 
		!$(event.target).hasClass('form') && 
		$(event.target).closest(".form").length === 0
		) {
			$('.form_volunteer').parent().removeClass('active')
			$('.form').removeClass('show')
			setTimeout(()=>{
				$('.form').remove()
			}, 200)
    }
  });
	$('.input').on('input',function(){
		let label = $(this).closest('.group').children('.label');
		if($(this).val().length > 0) {
			$(label).addClass('active')
		}else{
			$(label).removeClass('active')
		}
	})
	var user = detect.parse(navigator.userAgent);
	if (user.browser.family == 'IE'){
			$('.header').addClass('damn_it_internet_explorer')
			alert('Ваш браузер Internet Explorer, сайт может отображается не коректно, скачайте нормальный браузер!')
	}
	$('.card_item_btn').on('click', function(){
		if($('.form_adopt_get') && $('.form_adopt_get').length > 0){
			$('.form_adopt_get').remove()
		}
		let adoptGetForm = `<form class="form form_adopt_get" action="/">
												<div class="form_adopt_get_media" style="background-image: url(./images/dist/pexels-dog2.jpg);"></div>
												<div class="form_adopt_get_fields">
													<h2 class="form_adopt_get_title">Забрать питомца</h2>
												<div class="group">
													<i class="fal fa-user-circle"></i>
													<input class="input" type="text" name="name" required>
													<label class="label">Введите имя</label>
												</div>
												<div class="group">
													<i class="fal fa-envelope"></i>
													<input class="input" type="email" name="email" required>
													<label class="label">Введите e-mail</label>
												</div>
												<div class="group">
													<i class="far fa-phone"></i>
													<input class="input" type="text" name="phone" required>
													<label class="label">Введите номер телефона</label>
												</div>
												<button type="submit">Оставить заявку</button>
											</div>
											</form>`
		let parent = $('.tabs_content.active')
		$(parent).append(adoptGetForm)
		$('.form_adopt_get_media').css({'background-image' : `url(${$(this).data('img')})`})
		setTimeout(()=>{
			$('.form_adopt_get').addClass('show')
		}, 0)
		$('.form_adopt_get').on('submit', function(e){
			e.preventDefault()
			e.stopPropagation()
			let succesRes = `<div class="group success">
												<i class="far fa-user-check"></i>
												<label class="label">Ваша заявка принята. Мы свяжемся с Вами в ближайшее время</label>
											</div>
											<button class="close" type="submit">Закрыть</button>
											`
			$(this).html(succesRes)
			$('.close').on('click', function(){
				$('.form_adopt_get').removeClass('show')
				setTimeout(()=>{
					$('.form_adopt_get').remove()
				}, 200)
			})
		})
	})
	$('.volunteer_item_action').on('click', function(){
		$('.volunteer_item').removeClass('active')
		if($('.form_volunteer') && $('.form_volunteer').length > 0){
			$('.form_volunteer').remove()
		}
		let volunteerForm = `<form class="form form_volunteer">
													<div class="group">
														<i class="fal fa-user-circle"></i>
														<input class="input" type="text" name="name" required>
														<label class="label">Введите имя</label>
													</div>
													<div class="group">
														<i class="fal fa-envelope"></i>
														<input class="input" type="email" name="email" required>
														<label class="label">Введите e-mail</label>
													</div>
													<button type="submit">Оставить заявку</button>
												</form>`
		let parent = $(this).parent('.volunteer_item').addClass('active')
		$(parent).append(volunteerForm)
		setTimeout(()=>{
			$('.form_volunteer').addClass('show')
		}, 0)
		$('.form_volunteer').on('submit', function(e){
			e.preventDefault()
			e.stopPropagation()
			let succesRes = `<div class="group success">
												<i class="far fa-user-check"></i>
												<label class="label">Ваша заявка принята. Мы свяжемся с Вами в ближайшее время</label>
											</div>
											<button class="close" type="submit">Закрыть</button>
											`
			$(this).html(succesRes)
			$('.close').on('click', function(){
				$('.form_volunteer').removeClass('show')
				setTimeout(()=>{
					$('.form_volunteer').remove()
				}, 200)
			})
			console.log($(this).serialize());
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
