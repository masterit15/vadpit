<?
add_action('wp_ajax_newsFilter', 'news_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_newsFilter', 'news_filter_function');
 
function news_filter_function(){
		$dateFrom = $_POST['dateFrom'] ? date_format(new DateTime($_POST['dateFrom']), 'Y-m-d') : '';
		$dateTo = $_POST['dateTo'] ? date_format(new DateTime($_POST['dateTo']), 'Y-m-d') : '';
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'orderby' => 'date', // we will sort posts by date
			'post_status' => 'publish',
			'paged' => $paged
		);
		if($dateFrom && !$dateTo){
			$date = explode('-', $dateFrom);
			$args['date_query'] = array(
				array(
					'year'  => $date[0],
					'month' => $date[1],
					'day'   => $date[2],
				)
			);
		}
		if($dateFrom && $dateTo){
			$args['date_query'] = array(
				'before' => $dateTo,
				'after' => $dateFrom,
				'inclusive' => true,
				// 'compare'   => 'BETWEEN'
			);
		}
		?>
		<div class="ajax_content">
			<?
			if($dateFrom!=''||$dateTo!=''){
      	$filter = 'y';
			}else{
				$filter = 'n';
			}
			// PR($args);
			?>
			<div class="news_list_horizontal" data-filter="<?=$filter?>">
			<?
			$reviews = new WP_Query($args);
			if ($reviews->have_posts()) {while ($reviews->have_posts()) {
				$reviews->the_post();
				?>
					<a id="post-<?php the_ID(); ?>" href="<?the_permalink()?>" class="news_item">
						<div class="news_item_media" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>');"></div>
						<div class="news_item_content">
							<div class="news_item_title"><? the_title()?></div>
							<div class="news_item_bottom">
								<span class="news_item_date"><i class="far fa-table"></i> <?the_date()?></span>
								<span class="news_item_view_count"><i class="far fa-eye"></i> <?= gt_get_post_view(); ?></span>
							</div>
						</div>
					</a>
				<?
			}
		} else {
			echo 'Ничего не найдено';
		}
			wp_reset_postdata();
			?>
			</div>
			<nav class="navigation pagination" role="navigation" aria-label="Навигация по записям">
				<div class="nav-links">
						<?php
						$big = 999999999;
						echo paginate_links( array(
								'base' => site_url ().'/news-page/page/%#%/?dateFrom='.$dateFrom.'&dateTo='.$dateTo.'',// str_replace( $big, '%#%', get_pagenum_link( $big ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $reviews->max_num_pages,
								'prev_text' => '<i class="far fa-chevron-left"></i>',
								'next_text' => '<i class="far fa-chevron-right"></i>'
						) );
						?>
					</div>
				</nav>
			</div>
		<?
	die();
}
?>