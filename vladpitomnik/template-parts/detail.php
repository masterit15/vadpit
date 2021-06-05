<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
<div id="post-<?php the_ID(); ?>" class="news_detail">
	<div class="news_detail_media" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large') ?>');">
		<div class="news_detail_head">
			<div class="news_detail_title"><? the_title()?></div>
			<div class="news_detail_date_and_views">
				<span class="news_detail_date"><i class="far fa-table"></i> <?the_date()?></span>
				<span class="news_detail_view_count"><i class="far fa-eye"></i> <?= gt_get_post_view(); ?></span>
			</div>
		</div>
	</div>
	<div class="news_detail_content"><? the_content()?></div>
	<ul class="news_detail_socicon">
		<li><a data-soc="vk" data-purl="<?php the_permalink(); ?>" data-ptitle="<?php the_title(); ?>" data-pimg,="<?=get_the_post_thumbnail_url($post->ID, 'large') ?>" data-text="<? the_excerpt()?>"><i class="fab fa-facebook-f"></i></a></li>
		<li><a data-soc="fb" data-purl="<?php the_permalink(); ?>" data-ptitle="<?php the_title(); ?>" data-pimg,="<?=get_the_post_thumbnail_url($post->ID, 'large') ?>" data-text="<? the_excerpt()?>"><i class="fab fa-vk"></i></a></li>
		<li><a data-soc="tw" data-purl="<?php the_permalink(); ?>" data-ptitle="<?php the_title(); ?>" data-pimg,="<?=get_the_post_thumbnail_url($post->ID, 'large') ?>" data-text="<? the_excerpt()?>"><i class="fab fa-twitter"></i></a></li>
	</ul>
</div>