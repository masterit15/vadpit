<?php

// function true_breadcrumbs(){
 
// 	// получаем номер текущей страницы
// 	$page_num = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
 
// 	$separator = ' / '; //  разделяем обычным слэшем, но можете чем угодно другим
 
// 	// если главная страница сайта
// 	if( is_front_page() ){
 
// 		if( $page_num > 1 ) {
// 			echo '<a href="' . site_url() . '">Главная</a>' . $separator . $page_num . '-я страница';
// 		} else {
// 			echo 'Вы находитесь на главной странице';
// 		}
 
// 	} else { // не главная
 
// 		echo '<a href="' . site_url() . '">Главная</a>' . $separator;
 
 
// 		if( is_single() ){ // записи
 
// 			the_category( ', ' ); echo $separator; the_title();
 
// 		} elseif ( is_page() ){ // страницы WordPress 
 
// 			the_title();
 
// 		} elseif ( is_category() ) {
 
// 			single_cat_title();
 
// 		} elseif( is_tag() ) {
 
// 			single_tag_title();
 
// 		} elseif ( is_day() ) { // архивы (по дням)
 
// 			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $separator;
// 			echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a>' . $separator;
// 			echo get_the_time('d');
 
// 		} elseif ( is_month() ) { // архивы (по месяцам)
 
// 			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $separator;
// 			echo get_the_time('F');
 
// 		} elseif ( is_year() ) { // архивы (по годам)
 
// 			echo get_the_time( 'Y' );
 
// 		} elseif ( is_author() ) { // архивы по авторам
 
// 			global $author;
// 			$userdata = get_userdata( $author );
// 			echo 'Опубликовал(а) ' . $userdata->display_name;
 
// 		} elseif ( is_404() ) { // если страницы не существует
 
// 			echo 'Ошибка 404';
 
// 		}
 
// 		if ( $page_num > 1 ) { // номер текущей страницы
// 			echo ' (' . $page_num . '-я страница)';
// 		}
 
// 	}
 
// }