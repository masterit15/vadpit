<?
add_action('customize_register', function($customizer) {
	$customizer->add_section(
		'section_one', array(
			'title' => 'Настройки сайта',
			'description' => '',
			'priority' => 11,
		)
	);
  // телефон 1
	$customizer->add_setting('phone_1', 
		array('default' => '+78672202020')
	);
	$customizer->add_control('phone_1', array(
    'label' => 'Телефон 1',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // телефон 2
	$customizer->add_setting('phone_2', 
    array('default' => '+78672303030')
  );
  $customizer->add_control('phone_2', array(
    'label' => 'Телефон 2',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // телефон 3
  $customizer->add_setting('phone_3', 
    array('default' => '+79188335516')
  );
  $customizer->add_control('phone_3', array(
    'label' => 'Телефон 3',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // Е-почта флексопечать
  $customizer->add_setting('email', 
    array('default' => 'flexa.royalprint@inbox.ru')
  );
  $customizer->add_control('email', array(
    'label' => 'Е-почта',
    'section' => 'section_one',
    'type' => 'text',
  ));
  
  // адрес
  $customizer->add_setting('address', 
		array('default' => 'п. Заводской, ул. Пролетарская, 3')
	);
	$customizer->add_control('address', array(
    'label' => 'Адрес',
    'section' => 'section_one',
    'type' => 'text',
	));
  // копирайт сайта
  $customizer->add_setting('copyright', 
    array('default' => 'ВМКУ "Владпитомник" © 2021. Все права защищены')
  );
  $customizer->add_control('copyright', array(
    'label' => 'Копирайт сайта (copyright ©)',
    'section' => 'section_one',
    'type' => 'text',
  ));
  
});