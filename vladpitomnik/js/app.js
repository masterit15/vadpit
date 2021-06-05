// // Import jQuery module (npm i jquery)
import $ from 'jquery'
import detect from '../libs/browser.detect.min'
import { gsap, TweenMax } from 'gsap'
import Splide from '@splidejs/splide'
window.jQuery = $
window.$ = $
require('air-datepicker')
document.addEventListener('DOMContentLoaded', () => {
    const tl = gsap.timeline()
    let filterParams = {
            name: '',
            sex: '',
            petsType: '',
            dateFrom: '',
            dateTo: '',
        }
        // отслеживаем изменения параметров фильтра
    let filterProxied = new Proxy(filterParams, {
        get: function(target, prop) {
            // console.log({
            // 	type: "get",
            // 	target,
            // 	prop
            // });
            return Reflect.get(target, prop);
        },
        set: function(target, prop, value) {
            // console.log({
            // 	type: "set",
            // 	target,
            // 	prop,
            // 	value
            // });
            setTimeout(()=>{
                filterPets(target)
            },10)
            
            return Reflect.set(target, prop, value);
        }
    });
    // функция для запроса фильтрации
    function filterPets(params) {
        params['action'] = 'petsFilter'
        $.ajax({
            type: "POST",
            url: $('#filter').data('url'),
            data: params,
            beforeSend: function() {
                console.log('ajax beforeSend')
            },
            success: function(res) {
                $('.card_list_detail').html(res)
                console.log('success', res)
            },
            complete: function() {
                console.log('ajax complete')
            },
            error: function(err) {
                console.error('success', err);
            }
        });
    }
    // фильтрация по имени
    $('.filter_input').on('change', function() {
        if ($(this).val().length > 0) {
            filterProxied.name = $(this).val()
        } else {
            filterProxied.name = ''
        }
    })
    $('.filter_btn').on('click', function() {
            $(this).parent().children('button').removeClass('active')
            $(this).addClass('active')
            filterProxied[$(this).data('param')] = $(this).data('value')
        })
        // инициализация календаря (фильтра по датам)
    $('.datepicker-here').datepicker({
            range: true,
            position: 'top left',
            onSelect: function(formattedDate, date, inst) {
                if (formattedDate.includes(' - ')) {
                    let dateArr = formattedDate.split(' - ')
                    filterProxied.dateFrom = dateArr[0]
                    filterProxied.dateTo = dateArr[1]
                } else {
                    filterProxied.dateFrom = formattedDate
                    filterProxied.dateTo = ''
                }
            }
        })
        // вычисляем поле датапикера от низа если не хватает то открываем календарь сверху, если хватает то снизу
    let datepicker = $('.datepicker-here').datepicker().data('datepicker')
    if (document.querySelector('.filter_input.datepicker-here')) {
        var distance = Math.abs(document.querySelector('.filter_input.datepicker-here').getBoundingClientRect().bottom - window.innerHeight)
        window.onresize = function() {
            distance = Math.abs(document.querySelector('.filter_input.datepicker-here').getBoundingClientRect().bottom - window.innerHeight)
            if (distance >= 370) {
                datepicker.update({ position: 'bottom left' })
            } else {
                datepicker.update({ position: 'top left' })
            }
        };
        window.addEventListener('scroll', () => {
            distance = Math.abs(document.querySelector('.filter_input.datepicker-here').getBoundingClientRect().bottom - window.innerHeight)
            if (distance >= 370) {
                datepicker.update({ position: 'bottom left' })
            } else {
                datepicker.update({ position: 'top left' })
            }
        })
    }
    // закрываем элементы при клике вне блока
    $(document).on("click", function(event) {
        if (!$(event.target).hasClass('outsideclick') && $(event.target).closest(".outsideclick").length === 0) {
            $('.form_volunteer').parent().removeClass('active')
            $('.form').removeClass('show')
            $('.card_popup').removeClass('show')
            setTimeout(() => {
                $('.form').remove()
                $('.card_popup').remove()
            }, 200)
        }
    });

    // добавляем активный класс label при взаимодействии с полем ввода
    $('.input').on('input', function() {
        let label = $(this).closest('.group').children('.label');
        if ($(this).val().length > 0) {
            $(label).addClass('active')
        } else {
            $(label).removeClass('active')
        }
    })

    // определяем что за браузер
    const user = detect.parse(navigator.userAgent);
    if (user.browser.family == 'IE') {
        $('.header').addClass('damn_it_internet_explorer')
        alert('Ваш браузер Internet Explorer, сайт может отображается не коректно, скачайте нормальный браузер!')
    }

    // показываем детальную информацию о питомце по клику на него
    $('.card_list_detail .card_item_btn').on('click', function() {
        let cardPopup = `<div class="card_popup outsideclick">
											<div class="card_popup_carousel">
												<div class="splide">
													<div class="splide__arrows">
														<button class="splide__arrow splide__arrow--prev">
															<i class="far fa-chevron-left"></i>
														</button>
														<button class="splide__arrow splide__arrow--next">
															<i class="far fa-chevron-right"></i>
														</button>
													</div>
													<div class="splide__track">
														<ul class="splide__list">
															
														</ul>
													</div>
												</div>
											</div>
											<div class="card_popup_content">
												<h2 class="card_popup_content_title"></h2>
												<ul class="card_popup_content_list"></ul>
												<a class="card_item_btn form_open" data-img="./images/dist/pexels-dog3.jpg" data-name="Батон" data-id="3">Забрать</a>
											</div>
										</div>`
        let parent = $('.card_list_detail')
        $(parent).append(cardPopup)
        let imgs = []
        if ($(this).data('imgs').includes('|')) {
            imgs = $(this).data('imgs').split('|')
            imgs.forEach(img => {
                $('.card_popup').find('.splide__list').append(`<li class="splide__slide"><div class="card_media" style="background-image: url('${img}');"></div></li>`)
            });
        } else {
            $('.card_popup').find('.splide__list').append(`<li class="splide__slide"><div class="card_media" style="background-image: url('${$(this).data('imgs')}');"></div></li>`)
        }
        let listItems = `
							<li><strong>Место отлова:</strong>${$(this).data('capture-address')}</li>
							<li><strong>Дата отлова:</strong>${$(this).data('capture-date')}</li>
							<li><strong>Лечение:</strong>${$(this).data('treatment')}</li>
							<li><strong>Пол:</strong>${$(this).data('sex')}</li>
							<li><strong>Описание:</strong>${$(this).data('desc')}</li>
							`
        $('.card_popup_content_title').text($(this).data('name'))
        $('.card_popup_content_list').append(listItems)
        setTimeout(() => {
            new Splide('.splide', {
                type: 'fade',
                rewind: true,
                pagination: false
            }).mount();
            $('.card_popup').addClass('show')
        }, 0)
        initOpenForm()
    })

    // отображаем форму (забрать питомца)
    function initOpenForm() {
        $('.form_open').on('click', function() {
            if ($('.form_adopt_get') && $('.form_adopt_get').length > 0) {
                $('.form_adopt_get').remove()
            }
            let adoptGetForm = `<form class="form form_adopt_get outsideclick" action="/">
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
            let parent = $('.form_parent')
            console.log(parent);
            $(parent).append(adoptGetForm)
            $('.form_adopt_get_media').css({ 'background-image': `url(${$(this).data('img')})` })
            setTimeout(() => {
                $('.form_adopt_get').addClass('show')
            }, 0)
            $('.form_adopt_get').on('submit', function(e) {
                e.preventDefault()
                e.stopPropagation()
                let succesRes = `<div class="group success">
													<i class="far fa-user-check"></i>
													<label class="label">Ваша заявка принята. Мы свяжемся с Вами в ближайшее время</label>
												</div>
												<button class="close" type="submit">Закрыть</button>
												`
                $(this).html(succesRes)
                $('.close').on('click', function() {
                    $('.form_adopt_get').removeClass('show')
                    setTimeout(() => {
                        $('.form_adopt_get').remove()
                    }, 200)
                })
            })
        })
    }
    initOpenForm()
        // отображаем форму (стать волонтером)
    $('.volunteer_item_action').on('click', function() {
        $('.volunteer_item').removeClass('active')
        if ($('.form_volunteer') && $('.form_volunteer').length > 0) {
            $('.form_volunteer').remove()
        }
        let volunteerForm = `<form class="form form_volunteer outsideclick">
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
        setTimeout(() => {
            $('.form_volunteer').addClass('show')
        }, 0)
        $('.form_volunteer').on('submit', function(e) {
            e.preventDefault()
            e.stopPropagation()
            let succesRes = `<div class="group success">
												<i class="far fa-user-check"></i>
												<label class="label">Ваша заявка принята. Мы свяжемся с Вами в ближайшее время</label>
											</div>
											<button class="close" type="submit">Закрыть</button>
											`
            $(this).html(succesRes)
            $('.close').on('click', function() {
                $('.form_volunteer').removeClass('show')
                setTimeout(() => {
                    $('.form_volunteer').remove()
                }, 200)
            })
            console.log($(this).serialize());
        })

    })

    // кнопка мобильного меню
    $('#mobnav').on('click', function() {
        $(this).toggleClass('active')
        if ($(this).hasClass('active')) {
            $('.header').addClass('full')
            setTimeout(() => {
                $('.nav_wrap').slideDown(200)
            }, 100)
        } else {
            $('.nav_wrap').slideUp(200)
                // setTimeout(()=>{
                // 	$('.header').removeClass('full')
                // }, 100)
        }
    })

    // плавный скрол до якоря по клику на ссылку
    $('.section_nav_link a').on('click', function() {
        let elId = $(this).attr('href').split('#')
        $('html, body').animate({
            scrollTop: $(`#${elId[1]}`).offset().top
        }, 800);
    })

    // табы
    $('.tabs_action_btn').on('click', function() {
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
        window.addEventListener('scroll', function() {
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
    // кнопки поделится
    $('.news_detail_socicon a').on('click', function() {
        let soc = $(this).data('soc')
        let purl = $(this).data('purl')
        let ptitle = $(this).data('ptitle')
        let pimg = $(this).data('pimg')
        let text = $(this).data('text')
        share(soc, purl, ptitle, pimg, text)
    })

    function share(soc, purl, ptitle, pimg, text) {
        let url = ''
        const Share = {
            vkontakte: function(purl, ptitle, pimg, text) {
                url = 'http://vkontakte.ru/share.php?';
                url += 'url=' + encodeURIComponent(purl);
                url += '&title=' + encodeURIComponent(ptitle);
                url += '&description=' + encodeURIComponent(text);
                url += '&image=' + encodeURIComponent(pimg);
                url += '&noparse=true';
                Share.popup(url);
            },
            odnoklassniki: function(purl, text) {
                url = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
                url += '&st.comments=' + encodeURIComponent(text);
                url += '&st._surl=' + encodeURIComponent(purl);
                Share.popup(url);
            },
            facebook: function(purl, ptitle, pimg, text) {
                url = 'http://www.facebook.com/sharer.php?s=100';
                url += '&p[title]=' + encodeURIComponent(ptitle);
                url += '&p[summary]=' + encodeURIComponent(text);
                url += '&p[url]=' + encodeURIComponent(purl);
                url += '&p[images][0]=' + encodeURIComponent(pimg);
                Share.popup(url);
            },
            twitter: function(purl, ptitle) {
                url = 'http://twitter.com/share?';
                url += 'text=' + encodeURIComponent(ptitle);
                url += '&url=' + encodeURIComponent(purl);
                url += '&counturl=' + encodeURIComponent(purl);
                Share.popup(url);
            },
            mailru: function(purl, ptitle, pimg, text) {
                url = 'http://connect.mail.ru/share?';
                url += 'url=' + encodeURIComponent(purl);
                url += '&title=' + encodeURIComponent(ptitle);
                url += '&description=' + encodeURIComponent(text);
                url += '&imageurl=' + encodeURIComponent(pimg);
                Share.popup(url)
            },

            popup: function(url) {
                window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
            }
        };
        switch (soc) {
            case 'vk':
                Share.vkontakte(purl, ptitle, pimg, text)
                break;
            case 'fb':
                Share.facebook(purl, ptitle, pimg, text)
                break;
            case 'tw':
                Share.twitter(purl, ptitle, pimg, text)
                break;

        }

    }
})