<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */
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
