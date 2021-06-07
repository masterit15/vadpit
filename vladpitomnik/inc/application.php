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