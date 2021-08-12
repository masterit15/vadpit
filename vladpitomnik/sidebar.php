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
        <button data-param="sex" data-value="male" class="filter_btn" title="Самцы"><i class="fas fa-mars"></i></button>
        <button data-param="sex" data-value="female" class="filter_btn" title="Самки"><i class="fas fa-venus"></i></button>
      </div>
    </div>
    <!-- <div class="filter_group">
      <label class="filter_label">Выберите питомца:</label>
      <div class="filter_action">
        <button data-param="petsType" data-value="dogs" class="filter_btn"><i class="fas fa-dog"></i></button>
        <button data-param="petsType" data-value="cats" class="filter_btn"><i class="fas fa-cat"></i></button>
      </div>
    </div> -->
    <div class="filter_group">
      <label class="filter_label" >Задайте дату отлова:</label>
      <input type="text"
      value="<?=$_GET['dateFrom'].' - '.$_GET['dateTo']?>"
      class="filter_input datepicker-here datepicker-filter"
      data-multiple-dates-separator=" - "
      />
    </div>
    <?if(isset($_GET['name'])||isset($_GET['sex'])||isset($_GET['type'])||isset($_GET['dateFrom'])||isset($_GET['dateTo'])){?>
      <a href="/pets-page/" class="clear_filter"><i class="fas fa-sync-alt"></i> Сбросить</a>
    <?}?>
  </div>
	<?}elseif(stripos($_SERVER['REQUEST_URI'], $post->post_name)){?>
    <ul class="sidebar_nav">
			<li><a href="/news-page/">Все новости</a></li>
			<li><a href="/news-page/">Главная</a></li>
			<?php next_post_link('<li>%link</li>', 'Следующая новость', true); ?>
			<?php previous_post_link('<li>%link</li>', 'Предыдущая новость', true); ?>
			<li><a href="#!" class="datapicker_trigger">Выбрать по дате</a></li>
		</ul>
    <div class="datepicker-here datepicker-news" data-range="true" data-multiple-dates-separator=" - "></div>
	<?}elseif(stripos($_SERVER['REQUEST_URI'], 'news-page')){?>
    <div class="datepicker-here datepicker-news" data-range="true" data-multiple-dates-separator=" - "></div>
  <?}?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>