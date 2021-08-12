<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
	<section class="section_offer" id="offer" style="background-image: url(<?=TURI?>/images/dist/bg-offer.jpg);">
		<div class="offer_text">
			<h1><?php bloginfo( 'name' ); ?></h1>
			<p><?php bloginfo( 'description' ); ?></p>
			<div class="section_nav_link">
				<a href="/#our_pets" class="btn section_nav_link">Найти друга</a>
			</div>
		</div>
		<?php
			wp_nav_menu(
				array(
					'theme_location' 	=> 'menu-socicon',
					'menu_id'        	=> 'menu-socicon',
					'menu_class'      => 'soc_icon',
				)
			);
		?>
	</section>

	<section class="section_news" id="news">
		<div class="news">
			<h2 class="section_sub_title">Последние новости</h2>
			<div class="news_list">
			<?
      $reviews = new WP_Query(
      array(
      'post_type' => 'post',
      'post_status' => 'publish',
			'posts_per_page' => 6,
			'category_name' => 'news'
      ));
      if ($reviews->have_posts()) {while ($reviews->have_posts()) {$reviews->the_post();?>
			<a href="<?the_permalink()?>" class="news_item">
				<div class="news_item_media" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>');">
					<span class="news_item_view_count"><i class="far fa-eye"></i> <?= gt_get_post_view(); ?></span>
				</div>
				<div class="news_item_date"><? the_date(); ?></div>
				<div class="news_item_title"><? the_title(); ?></div>
			</a>
      <?}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
			</div>
			<a class="news_all_btn" href="/news-page/">Смотреть все</a>
		</div>
		<div class="count">
			<h2 class="section_sub_title">Муниципальный приют в цифрах</h2>
			<div class="count_list">
				<?
				$reviews = new WP_Query(
				array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 4,
				'category_name' => 'count'
				));
				$i = 0;
				if ($reviews->have_posts()) {while ($reviews->have_posts()) {
					$reviews->the_post();
					$custom = get_post_custom($post->ID);
				?>
				<div class="count_item" data-target="<?=$i?>" data-start="0" data-end="<?=$custom['post_counter'][0]?>">
					<div class="count_item_num">0</div>
					<div class="count_item_title"><? the_title(); ?></div>
				</div>
				<?$i++;}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
			</div>
		</div>
	</section>

	<section class="section_our_pets" id="our_pets">
		<h2 class="section_sub_title">Наши питомцы</h2>
		<div class="tabs">
			<!-- <div class="tabs_action">
				<button class="tabs_action_btn active" data-item="1"><i class="fas fa-dog"></i> Собаки</button>
				<button class="tabs_action_btn" data-item="2">Кошки <i class="fas fa-cat"></i></button>
			</div> -->
			<div class="tabs_wrap">
				<div class="tabs_content active form_parent" data-content="1">
					<div class="card_list">
					<?
					$args = array(
						'orderby' => 'date', // we will sort posts by date
						'post_type' => 'pets',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'pets-cat' => 'dogs'
					);
					$reviews = new WP_Query($args);
					if ($reviews->have_posts()) {while ($reviews->have_posts()) {$reviews->the_post();
					$custom = get_post_custom($post->ID);
					$moreImg = show_thumbnails_list();
					$moreImg[] = get_the_post_thumbnail_url($post->ID, 'large');
					if(count(array_unique($moreImg)) > 1){ 
						$imgs = implode("|", array_unique($moreImg));
					}else{ 
						$imgs = get_the_post_thumbnail_url($post->ID, 'large');
					}
					?>
						<div class="card_item" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>');">
							<div class="card_item_content">
								<div class="card_item_title"><?=$custom['pets_name'][0]?></div>
								<div class="card_item_address"><i class="fal fa-map-pin"></i> <?=$custom['pets_captureaddress'][0]?></div>
								<div class="card_item_date"><i class="fal fa-clock"></i> <?=$custom['pets_capturedate'][0]?></div>
								<div class="card_item_desc"><?php the_excerpt();?></div>
							</div>
							<a class="card_item_btn outsideclick form_open"
								data-img="<?=get_the_post_thumbnail_url($post->ID, 'large')?>" 
								data-name="<?=$custom['pets_name'][0]?>" 
								data-capture-address="<?=$custom['pets_captureaddress'][0]?>"
								data-capture-date="<?=$custom['pets_capturedate'][0]?>"
								data-treatment="<?=$custom['pets_treatment'][0]?>"
								data-sex="<?=$custom['pets_sex'][0]?>"
								data-desc="<?php the_excerpt();?>"
								data-type="dog"
								data-id="<?=$post->ID?>"
							><i class="fas fa-paw-alt"></i> Забрать</a>
						</div>
						<?
						}} else {echo 'Ничего не найдено';}
						wp_reset_postdata();?>
					</div>
				</div>
				<div class="tabs_content form_parent" data-content="2">
				<div class="card_list">
					<?
					$args = array(
						'orderby' => 'date', // we will sort posts by date
						'post_type' => 'pets',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'pets-cat' => 'cats'
					);
					$reviews = new WP_Query($args);
					if ($reviews->have_posts()) {while ($reviews->have_posts()) {$reviews->the_post();
					$custom = get_post_custom($post->ID);
					$moreImg = show_thumbnails_list();
					$moreImg[] = get_the_post_thumbnail_url($post->ID, 'large');
					if(count(array_unique($moreImg)) > 1){ 
						$imgs = implode("|", array_unique($moreImg));
					}else{ 
						$imgs = get_the_post_thumbnail_url($post->ID, 'large');
					}
					?>
						<div class="card_item" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>');">
							<div class="card_item_content">
								<div class="card_item_title"><?=$custom['pets_name'][0]?></div>
								<div class="card_item_address"><i class="fal fa-map-pin"></i> <?=$custom['pets_captureaddress'][0]?></div>
								<div class="card_item_date"><i class="fal fa-clock"></i> <?=$custom['pets_capturedate'][0]?></div>
								<div class="card_item_desc"><?php the_excerpt();?></div>
							</div>
							<a class="card_item_btn outsideclick form_open"
								data-imgs="<?=$imgs?>" 
								data-name="<?=$custom['pets_name'][0]?>" 
								data-capture-address="<?=$custom['pets_captureaddress'][0]?>"
								data-capture-date="<?=$custom['pets_capturedate'][0]?>"
								data-treatment="<?=$custom['pets_treatment'][0]?>"
								data-sex="<?=$custom['pets_sex'][0]?>"
								data-desc="<?php the_excerpt();?>"
								data-type="cat"
								data-id="<?=$post->ID?>"
							><i class="fas fa-paw-alt"></i> Забрать</a>
						</div>
						<?
						}} else {echo 'Ничего не найдено';}
						wp_reset_postdata();?>
					</div>
				</div>
			</div>
			<a class="news_all_btn" href="/pets-page/">Все питомцы</a>
		</div>
	</section>

	<section class="for_volunteers" id="for_volunteers">
		<h2 class="section_sub_title">Стать волонтером</h2>
		<div class="volunteer_item_list">
			<?
			$args = array(
				'orderby' => 'id', // we will sort posts by date
				'order' => 'ASC',
				'post_type' => 'volunteer_app',
				'post_status' => 'publish',
				// 'posts_per_page' => 4,
				// 'pets-cat' => 'cats'
			);
			$reviews = new WP_Query($args);
			if ($reviews->have_posts()) {
				while ($reviews->have_posts()) 
				{$reviews->the_post();
			?>
				<div class="volunteer_item">
					<img class="volunteer_item_icon" src="<?=get_the_post_thumbnail_url($post->ID, 'large')?>"/>
					<div class="volunteer_item_title"><?= the_title()?></div>
					<div class="volunteer_item_desc"><?= the_content()?></div>
					<div class="volunteer_item_action outsideclick" data-title="<?= the_title()?>">Оставить заявку</div>
				</div>
			<?}} else {echo 'Ничего не найдено';}
				wp_reset_postdata();?>
		</div>
	</section>