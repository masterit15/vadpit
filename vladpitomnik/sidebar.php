<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vladpitomnik
 */

// if ( ! is_active_sidebar( 'sidebar-1' ) ) {
// 	return;
// }
?>
<div id="sidebar">
	<?if(stripos($_SERVER['REQUEST_URI'], 'pets-page')){?>
  <div id="filter" data-url="<?php echo site_url ()?>/wp-admin/admin-ajax.php">
    <div class="filter_group">
      <label class="filter_label" for="filter_name">Имя:</label>
      <input id="filter_name" type="text" class="filter_input">
    </div>
    <div class="filter_group">
      <label class="filter_label">Выберите пол:</label>
      <div class="filter_action">
        <button data-param="sex" data-value="male" class="filter_btn"><i class="fas fa-mars"></i></button>
        <button data-param="sex" data-value="female" class="filter_btn active"><i class="fas fa-venus"></i></button>
      </div>
    </div>
    <div class="filter_group">
      <label class="filter_label">Выберите питомца:</label>
      <div class="filter_action">
        <button data-param="petsType" data-value="dog" class="filter_btn active"><i class="fas fa-dog"></i></button>
        <button data-param="petsType" data-value="cat" class="filter_btn"><i class="fas fa-cat"></i></button>
      </div>
    </div>
    <div class="filter_group">
      <label class="filter_label" >Задайте дату отлова::</label>
      <input type="text"
      class="filter_input datepicker-here"
      data-multiple-dates="3"
      data-multiple-dates-separator=" - "
      />
    </div>
  </div>
	<?}elseif(stripos($_SERVER['REQUEST_URI'], $post->post_name)){?>
    <ul class="sidebar_nav">
			<li><a href="/news-page/">Все новости</a></li>
			<li><a href="/news-page/">Главная</a></li>
			<?php next_post_link('<li>%link</li>', 'Следующая новость', true); ?>
			<?php previous_post_link('<li>%link</li>', 'Предыдущая новость', true); ?>
			<li><a href="/">Выбрать по дате</a></li>
		</ul>

    <div class="datepicker-here"></div>
	<?}elseif(stripos($_SERVER['REQUEST_URI'], 'news-page')){?>
    <div class="datepicker-here"></div>
  <?}?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>