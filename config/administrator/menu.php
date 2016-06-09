<?php

/**
 * The menu structure of the site. For models, you should either supply the name of a model config file or an array of names of model config
 * files. The same applies to settings config files, except you must prepend 'settings.' to the settings config file name. You can also add
 * custom pages by prepending a view path with 'page.'. By providing an array of names, you can group certain models or settings pages
 * together. Each name needs to either have a config file in your model config path, settings config path with the same name, or a path to a
 * fully-qualified Laravel view. So 'users' would require a 'users.php' file in your model config path, 'settings.site' would require a
 * 'site.php' file in your settings config path, and 'page.foo.test' would require a 'test.php' or 'test.blade.php' file in a 'foo' directory
 * inside your view directory.
 *
 * @type array
 *
 * 	array(
 *		'E-Commerce' => array('collections', 'products', 'product_images', 'orders'),
 *		'homepage_sliders',
 *		'users',
 *		'roles',
 *		'colors',
 *		'Settings' => array('settings.site', 'settings.ecommerce', 'settings.social'),
 * 		'Analytics' => array('E-Commerce' => 'page.ecommerce.analytics'),
 *	)
 */
return [
//     'App' => [
//          'page_header' => 'Some Title' // work only for parent category
//          'dashboard' => [
//          'icon'  => 'fa-dashboard',
//          'route' => 'admin_dashboard',
//          ]
//     ]
    'Roles' => [
        'page_header' => 'memberships',
//        'icon' => 'fa fa-circle-o',
        'pages' => [
            'admins' => [
                'icon' => 'fa fa-graduation-cap'
            ],
            'members' => [
                'icon' => 'fa fa-users'
            ]
        ]
    ],
    'Content' => [
        'page_header' => 'main content site',
        'pages' => [
            'categories' => [
                'icon' => 'fa fa-tags'
            ],
            'products' => [
                'icon' => 'fa fa-shopping-cart'
            ],
            'sellers' => [
                'icon' => 'fa fa-shopping-bag'
            ],
        ]
    ],
    'Secondary Content' => [
        'page_header' => 'secondary content site',
        'pages' => [
            'pages' => [
                'icon' => 'fa fa-file-text-o'
            ],
            'socials' => [
                'icon' => 'fa fa-hashtag'
            ],
            'partners' => [
                'icon' => 'fa fa-group'
            ],
            'banners' => [
                'icon' => 'fa fa-object-group'
            ]
        ]
    ],
    'Relations' => [
        'page_header' => 'relationship tables',
        'icon' => 'fa fa-sitemap',
        'pages' => [
            'users_products' => [
                'icon' => 'fa fa-circle-o'
            ]
        ]
    ]
];
