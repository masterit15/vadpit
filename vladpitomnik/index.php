<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

get_header();
?>


<main id="main">
    <?get_sidebar();?>
    <div id="content">
      <h2 class="page_title"><?php single_post_title(); ?></h2>
      <?true_breadcrumbs()?>
      <div id="workarea">
        <div class="news_list_horizontal">
					<?php
					if ( have_posts() ) {
						/* Start the Loop */
						while ( have_posts() ){
							the_post();
							get_template_part( 'template-parts/content', get_post_type() );
						};
						the_posts_navigation();
					}else{
						get_template_part( 'template-parts/content', 'none' );
					};
					?>
        </div>
        <?
        $args = array(
          'show_all'     => false, // показаны все страницы участвующие в пагинации
          'end_size'     => 1,     // количество страниц на концах
          'mid_size'     => 1,     // количество страниц вокруг текущей
          'prev_next'    => true,  // выводить ли боковые ссылки "предыдущая/следующая страница".
          'prev_text'    => __('<i class="far fa-chevron-left"></i>'),
          'next_text'    => __('<i class="far fa-chevron-right"></i>'),
          'add_args'     => false, // Массив аргументов (переменных запроса), которые нужно добавить к ссылкам.
          'add_fragment' => '',     // Текст который добавиться ко всем ссылкам.
          'screen_reader_text' => __( 'Posts navigation' ),
        );
        the_posts_pagination( $args );
        ?>
      </div>
    </div>
  </main>
<?php
get_footer();
