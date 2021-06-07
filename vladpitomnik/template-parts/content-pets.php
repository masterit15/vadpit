<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
<div id="content">
  <h2 class="page_title">Наши питомцы</h2>
  <?true_breadcrumbs()?>
  
  <div class="loader" data-filter="dog">
    <img src="<?=TURI?>images/dist/dog.gif" alt="">
    <img src="<?=TURI?>images/dist/cat.gif" alt="">
  </div>
  <div id="workarea">
    <div class="card_list_detail form_parent">
      <?
      $name = isset($_GET['name']) ? $_GET['name'] : '';
      $sex = isset($_GET['sex']) ? $_GET['sex'] : '';
      $type = isset($_GET['petsType']) ? $_GET['petsType'] : '';
      $dateFrom = isset($_GET['dateFrom']) ? new DateTime($_GET['dateFrom']) : '';
      $dateTo = isset($_GET['dateTo']) ? new DateTime($_GET['dateTo']) : '';
      if($dateFrom && $dateTo){
        $dateFrom = date_format($dateFrom, 'Y-m-d');
        $dateTo = date_format($dateTo, 'Y-m-d');
      }
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = array(
        'orderby' => 'date', // we will sort posts by date
        'post_type' => 'pets',
        'post_status' => 'publish',
        'paged' => $paged
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
        $args['pets-cat'] = $type;
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
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
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
      <div class="card_item" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>')">
        <div class="card_item_content">
          <div class="card_item_title"><?=$custom['pets_name'][0]?></div>
          <div class="card_item_address"><i class="fal fa-map-pin"></i> <?=$custom['pets_captureaddress'][0]?></div>
          <div class="card_item_date"><i class="fal fa-clock"></i> <?=$custom['pets_capturedate'][0]?></div>
          <div class="card_item_desc"><?php the_excerpt();?></div>
        </div>
        <?php show_thumbnails_list(); ?>
        <a class="card_item_btn outsideclick" 
        data-imgs="<?=$imgs?>" 
        data-name="<?=$custom['pets_name'][0]?>" 
        data-capture-address="<?=$custom['pets_captureaddress'][0]?>"
        data-capture-date="<?=$custom['pets_capturedate'][0]?>"
        data-treatment="<?=$custom['pets_treatment'][0]?>"
        data-sex="<?=$custom['pets_sex'][0]?>"
        data-desc="<?php the_excerpt();?>"
        data-id="<?=$post->ID?>"><i class="fas fa-paw-alt"></i> Забрать</a>
      </div>
      
      <?
    
    }} else {echo 'Ничего не найдено';}
    wp_reset_postdata();?>
    </div>
    <nav class="navigation pagination" role="navigation" aria-label="Навигация по записям">
      <div class="nav-links">
        <?php
        $big = 999999999;
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
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
</div>