<?php
/**
 * RoyalPrint Theme pets fields
 *
 * @package RoyalPrint
 */

/**
 * Add postMessage support for site title and description for the Theme pets fields.
 *
 * @param WP_Customize_Manager $wp_customize Theme pets fields object.
 */
// require get_template_directory() . '/vendor/autoload.php';
// use ColorThief\ColorThief;
// Добавляем кастомный тип записи Продукты
add_action('init', 'my_custom_pets');
function my_custom_pets() {
	register_post_type('pets', array(
		'labels' => array(
			'name' => 'Питомцы',
			'singular_name' => 'Питомец',
			'add_new' => 'Добавить нового',
			'add_new_item' => 'Добавить нового питомца',
			'edit_item' => 'Редактировать питомца',
			'new_item' => 'Новый питомец',
			'view_item' => 'Посмотреть питомца',
			'search_items' => 'Найти питомца',
			'not_found' => 'Питомцов не найдено',
			'not_found_in_trash' => 'В корзине питомцев не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Питомцы',

		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'pets', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
		'show_in_rest' => true,
		'rest_base' => 'pets',
	));

	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"pets-cat",
		array("pets"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'pets', 'with_front' => false),
		)
	);
}
//Дополнительные поля продукта
add_action("admin_init", "pets_field_init");
add_action('save_post', 'save_pets_field');
function pets_field_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("pets_field", "Дополнительные поля", "pets_field", 'pets', "normal", "low");
	}
}
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');
if(get_post_type() == 'pets'){
	function admin_js() {
		wp_enqueue_script( 'jquery-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js' );
		wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/admin.js' );
		
	}
	add_action('admin_enqueue_scripts', 'admin_js');

}


// Функция сохранения полей продукта "Цена" и "Тираж"
function save_pets_field() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "pets_name", $_POST["name"]);
		update_post_meta($post->ID, "pets_sex", $_POST["sex"]);
		update_post_meta($post->ID, "pets_treatment", $_POST["treatment"]);
		update_post_meta($post->ID, "pets_vaccinated", $_POST["vaccinated"]);
		update_post_meta($post->ID, "pets_capturedate", $_POST["capturedate"]);
		update_post_meta($post->ID, "pets_captureaddress", $_POST["captureaddress"]);
		update_post_meta($post->ID, "_link", $_POST["link"]);
	}
}
//Дополнительные поля продукта html
function pets_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$link    = $custom["_link"][0];
	?>
	<div class="pets">
		<div class="pets_fields">
			<div class="group">
				<label>Имя питомца:</label>
					<?if ($custom['pets_name']) {?>
						<input class="pets_fields_name" name="name" type="text" value="<?=$custom['pets_name'][0]?>">
					<?} else {?>
						<input class="pets_fields_name" name="name" type="text">
					<?}?>
			</div>
			<div class="group">
				<label>Дата отлова:</label>
					<?if ($custom['pets_name']) {?>
						<input class="pets_fields_capturedate" name="capturedate" type="date" value="<?=$custom['pets_capturedate'][0]?>">
					<?} else {?>
						<input class="pets_fields_capturedate" name="capturedate" type="date">
					<?}?>
			</div>
			<div class="group">
				<label>Адрес отлова:</label>
					<?if ($custom['pets_name']) {?>
						<input class="pets_fields_captureaddress" name="captureaddress" type="text" value="<?=$custom['pets_captureaddress'][0]?>">
					<?} else {?>
						<input class="pets_fields_captureaddress" name="captureaddress" type="text">
					<?}?>
			</div>
			<div class="group">
				<label>Пол питомца:</label>
				<?if ($custom['pets_sex']) {?>
					<select name="sex">
						<option value="male" <?if($custom['pets_sex'][0] == "male"){?>selected<?}?>>Самец</option>
						<option value="female" <?if($custom['pets_sex'][0] == "female"){?>selected<?}?>>Самка</option>
					</select>
				<?} else {?>
					<select name="sex">
						<option value="male" selected>Самец</option>
						<option value="female">Самка</option>
					</select>
				<?}?>
			</div>
			<div class="group">
				<label>Лечение:</label>
				<?if ($custom['pets_treatment']) {?>
					<select name="treatment">
						<option value="Вылечен" <?if($custom['pets_treatment'][0] == "Вылечен"){?>selected<?}?>>Вылечен</option>
						<option value="Не вылечен" <?if($custom['pets_treatment'][0] == "Не вылечен"){?>selected<?}?>>Не вылечен</option>
					</select>
				<?} else {?>
					<select name="treatment">
						<option value="Вылечен" selected>Вылечен</option>
						<option value="Не вылечен">Не вылечен</option>
					</select>
				<?}?>
			</div>
			<div class="group">
				<label>Прививка питомца:</label>
				<?if ($custom['pets_sex']) {?>
					<select name="vaccinated">
						<option value="Привит" <?if($custom['pets_vaccinated'][0] == "Привит"){?>selected<?}?>>Привит</option>
						<option value="Не привит" <?if($custom['pets_vaccinated'][0] == "Не привит"){?>selected<?}?>>Не привит</option>
					</select>
				<?} else {?>
					<select name="vaccinated">
						<option value="Привит" selected>Привит</option>
						<option value="Не привит">Не привит</option>
					</select>
				<?}?>
			</div>
		</div>
		<div class="pets_images">
			<div class="frame"></div>
			<input type="hidden" name="link" class="field" value="<?=$link?>" />
			<div class="images_edition">
				<div class="load_more" 
				data-url="<?php echo site_url ()?>/wp-admin/admin-ajax.php" 
				data-post="<?=$post->ID?>"
				data-selectcount="<?=count(explode(',', $link))?>" 
				>Показать еще</div>
				<div class="edition-selected"></div>
			</div>
		</div>
	</div>
<?
}


add_action('wp_ajax_moreimage', 'moreimage_filter_function'); // wp_ajax_{ACTION HERE} 
function moreimage_filter_function(){
		global $post;
		$ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 3;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
		$custom = get_post_custom($_REQUEST['post']);
		$link    = $custom["_link"][0];
		$thelinks = explode(',', $link);
		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' => array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif' => 'image/gif',
				'png' => 'image/png',
			),
			'post_status' => 'inherit',
			'posts_per_page' => $ppp,
			'paged'    => $page,
		);
		$query_images = new WP_Query( $args );
		foreach ($query_images->posts as $file) {
		if (in_array($file->ID, $thelinks)) {?>
			<label class="checked" for="images_<?=$file->ID?>">
				<input type="checkbox" group="images" value="<?=$file->ID?>" checked />
				<div class="img" style="background-image: url('<?=$file->guid?>')"></div>
			</label>
		<?} else {?>
			<label for="images_<?=$file->ID?>">
				<input id="images_<?=$file->ID?>" type="checkbox" group="images" value="<?=$file->ID?>" />
				<div class="img" style="background-image: url('<?=$file->guid?>')"></div>
			</label>
		<?}
		$edition++;
		}
		die();
}


// Регистрируем колонку 'ID' и 'Миниатюра'. Обязательно.
add_filter( 'manage_pets_posts_columns', function ( $columns ) {
	$my_columns = [
		'id'    => 'ID',
		'thumb' => 'Фото питомца',
		'pets_name' => 'Имя питомца',
		'pets_sex'=> 'Пол питомца'
	];

	return array_slice( $columns, 0, 1 ) + $columns + $my_columns ;
} );
// Выводим контент для каждой из зарегистрированных нами колонок. Обязательно.
add_action( 'manage_pets_posts_custom_column', function ( $column_name ) {
	global $post;
	$custom = get_post_custom($post->ID);

	if ( $column_name === 'id' ) {
		the_ID();
	}
	if ( $column_name === 'pets_name' ) {
		echo $custom['pets_name'][0];
	}
	if ( $column_name === 'pets_sex' ) {
		echo $custom['pets_sex'][0] == 'male'? 'Самец' : 'Самка';
	}
	if ( $column_name === 'thumb' && has_post_thumbnail() ) {
		?>
		<a href="<?php echo get_edit_post_link(); ?>">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</a>
		<?php
	}

} );

// Добавляем стили для зарегистрированных колонок. Необязательно.
add_action( 'admin_print_footer_scripts-edit.php', function () {
	?>
	<style>
		.column-id {
			width: 50px;
		}

		.column-thumb img {
			max-width: 100%;
			height: auto;
		}
	</style>
	<?php
} );
function show_thumbnails_list() {
	global $post;
	$image = get_post_meta($post->ID, '_link', true);
	$image = explode(",", $image);
	$url = array();
	foreach ($image as $images) {
		$url[] = wp_get_attachment_image_src($images, 1, 1)[0];
	}
	return $url;
}