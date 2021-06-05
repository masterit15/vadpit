<?
add_action('wp_ajax_petsFilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 
// add_action('wp_ajax_nopriv_petsFilter', 'misha_filter_function');
 
function misha_filter_function(){
		$name = $_POST['name'] ? $_POST['name'] : '';
		$sex = $_POST['sex'] ? $_POST['sex'] : '';
		$type = $_POST['petsType'] ? $_POST['petsType'] : '';
		$dateFrom = $_POST['dateTo'] ? new DateTime($_POST['dateFrom']) : '';
		$dateTo = $_POST['dateTo'] ? new DateTime($_POST['dateTo']) : '';
		$dateFrom = date_format($dateFrom, 'Y-m-d');
		$dateTo = date_format($dateTo, 'Y-m-d');
		$args = array(
			'orderby' => 'date', // we will sort posts by date
			'post_type' => 'pets',
			'post_status' => 'publish',
			// 'paged' => $paged
		);
		if($name){
			$args['meta_query'][] = array(
				'key' => 'pets_name',
				'value' => $name,
				'compare' => 'LIKE',
			);
		}
		if($sex){
			$args['meta_query'][] = array(
				'key' => 'pets_sex',
				'value' => $sex,
				'compare' => '=',
			);
		}
		if($type){
			$args['meta_query'][] = array(
				'key' => 'pets_type',
				'value' => $type,
				'compare' => '=',
			);
		}
		if($dateFrom && !$dateTo){
			$args['meta_query'][] = array(
				'key' => 'pets_capturedate',
				'value' => $dateFrom,
				'compare' => '>=',
				'type' => 'DATE'
			);
		}
		if($dateFrom && $dateTo){
			$args['meta_query'][] = array(
				'key' => 'pets_capturedate',
				'value' => array($dateFrom, $dateTo),
				'compare' => 'BETWEEN',
				'type' => 'DATE'
			);
		}
		
		$reviews = new WP_Query($args);

		if ($reviews->have_posts()) {while ($reviews->have_posts()) {
			$reviews->the_post();
			$custom = get_post_custom($post->ID);
			$moreImg = show_thumbnails_list();
			$moreImg[] = get_the_post_thumbnail_url($post->ID, 'large');
			if(count(array_unique($moreImg)) > 1){ 
				$imgs = implode("|", array_unique($moreImg));
			}else{ 
				$imgs = get_the_post_thumbnail_url($post->ID, 'large');
			}
			?>
				<div class="card_item" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>')">
					<div class="card_item_content">
						<div class="card_item_title"><?=$custom['pets_name'][0]?></div>
						<div class="card_item_address"><i class="fal fa-map-pin"></i> <?=$custom['pets_captureaddress'][0]?></div>
						<div class="card_item_date"><i class="fal fa-clock"></i> <?=$custom['pets_capturedate'][0]?></div>
						<div class="card_item_desc"><?php the_excerpt();?></div>
					</div>
					<?php show_thumbnails_list(); ?>
					<a class="card_item_btn outsideclick" data-imgs="<?=$imgs?>" data-name="<?=$custom['pets_name'][0]?>" 
					data-capture-address="<?=$custom['pets_captureaddress'][0]?>"
					data-capture-date="<?=$custom['pets_capturedate'][0]?>"
					data-treatment="<?=$custom['pets_treatment'][0]?>"
					data-sex="<?=$custom['pets_sex'][0]?>"
					data-desc="<?php the_excerpt();?>"
					data-id="2"><i class="fas fa-paw-alt"></i> Забрать</a>
				</div>
			<?
		}
	} else {
		echo 'Ничего не найдено';
	}
		wp_reset_postdata();
		PR($args);
	die();
}
?>