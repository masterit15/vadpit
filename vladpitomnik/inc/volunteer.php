<?

add_action('init', 'volunteer');
function volunteer() {
	register_post_type('volunteer', array(
		'labels' => array(
			'name' => 'Волонтеры',
			'singular_name' => 'Волонтер',
			'add_new' => 'Добавить волонтера',
			'add_new_item' => 'Добавить нового волонтера',
			'edit_item' => 'Редактировать волонтера',
			'new_item' => 'Новый волонтер',
			'view_item' => 'Посмотреть волонтера',
			'search_items' => 'Найти волонтера',
			'not_found' => 'Волонтеров не найдено',
			'not_found_in_trash' => 'В корзине волонтеров не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Волонтеры',
		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'volunteer', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
		'show_in_rest' => true,
		'rest_base' => 'volunteer',
	));
}

add_action('init', 'volunteer_app');
function volunteer_app() {
	register_post_type('volunteer_app', array(
		'labels' => array(
			'name' => 'Стать волонтером',
			// 'singular_name' => 'Волонтер',
			// 'add_new' => 'Добавить запись',
			// 'add_new_item' => 'Добавить новую заявку',
			// 'edit_item' => 'Редактировать заявку',
			// 'new_item' => 'Новая заявка',
			// 'view_item' => 'Посмотреть заявку',
			// 'search_items' => 'Найти заявку',
			// 'not_found' => 'Заявок не найдено',
			// 'not_found_in_trash' => 'В корзине заявок не найдено',
			// 'parent_item_colon' => '',
			'menu_name' => 'Стать волонтером',
		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'volunteer_app', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
		'show_in_rest' => true,
		'rest_base' => 'volunteer_app',
	));
}
