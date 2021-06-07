<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package vladpitomnik
 */

get_header();
// if($_SESSION['userip'] !== $_SERVER['REMOTE_ADDR']){
// 	// считет количество просмотров
// 	$_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];
	gt_set_post_view();
// }
?>
<main id="main">
    <?get_sidebar();?>
    <div id="content">
      <h2 class="page_title"><?php single_post_title(); ?></h2>
      <?true_breadcrumbs()?>
      <div id="workarea">
					<?php
					while ( have_posts() ) :
						the_post();
			
						get_template_part( 'template-parts/detail', get_post_type() );

					endwhile;
					?>
      </div>
    </div>
  </main>

<?php
get_sidebar();
get_footer();
