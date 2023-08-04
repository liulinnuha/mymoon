<?php

$menu = [
	'sidebar' => [
		[
			'category' => 'Main',
			'label' => 'Dashboard',
			'icon' => 'fa fa-home',
			'route' => 'dashboard'
		],
		[
			'category' => 'Items',
			'label' => 'Products',
			'icon' => 'fa fa-cube',
			'childs' => [
				[
					'label' => 'Categories',
					'route' => 'category',
				],
			]
		],
	]
];

return $menu;