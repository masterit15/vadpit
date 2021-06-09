<?

add_action('init', 'application_pets');
function application_pets() {
	register_post_type('application_pets', array(
		'labels' => array(
			'name' => 'Заявки',
			'singular_name' => 'Заявка',
			'add_new' => 'Добавить нового',
			'add_new_item' => 'Добавить новоую заявку',
			'edit_item' => 'Редактировать заявку',
			'new_item' => 'Новый питомец',
			'view_item' => 'Посмотреть заявку',
			'search_items' => 'Найти заявку',
			'not_found' => 'Заявок не найдено',
			'not_found_in_trash' => 'В корзине заявок не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Заявки',
		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'application_pets', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
		'show_in_rest' => true,
		'rest_base' => 'application_pets',
	));
}
// Регистрируем колонку 'ID' и 'Миниатюра'. Обязательно.
add_filter( 'manage_application_pets_posts_columns', function ( $columns ) {
	$my_columns = [
		'email' => 'Е-почта',
		'phone'=> 'Телефон'
	];

	return array_slice( $columns, 0, 1 ) + $columns + $my_columns ;
} );
// Выводим контент для каждой из зарегистрированных нами колонок. Обязательно.
add_action( 'manage_application_pets_posts_custom_column', function ( $column_name ) {
	global $post;
	$custom = get_post_custom($post->ID);

	if ( $column_name === 'email' ) {
		echo $custom['email'][0];
	}
	if ( $column_name === 'phone' ) {
		echo $custom['phone'][0];
	}

} );

add_action( 'admin_menu', function() {
	global $menu;
	$posts = get_posts('post_type=application_pets&suppress_filters=0&posts_per_page=-1&post_status=draft');
	$count = count($posts); 
	$menu[27][0] = $count > 0 ? 'Заявок <span class="awaiting-mod">' . $count. '</span>' : 'Заявки';
});