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
        'page_header' => 'Lots and Vendors',
        'pages' => [
            'allvendors' => [
                'icon' => 'fa fa-shopping-bag'
            ],
            'lot' => [
                'icon' => 'fa fa-users'
            ],
            /*'products' => [
                'icon' => 'fa fa-shopping-cart'
            ],*/
        ]
    ],
    'Categories' => [
        'icon' => 'fa fa-list',
        'pages' => [
            'categories' => [
                'icon' => 'fa fa-circle-o'
            ],

            'sub_categories' => [
                'icon' => 'fa fa-circle-o'
            ],

//            'category_filters' => [
//                'icon' => 'fa fa-circle-o'
//            ],
//
//            'sub_category_filters' => [
//                'icon' => 'fa fa-circle-o'
//            ],

//            'category_rel' => [
//                'icon' => 'fa fa-circle-o'
//            ],

//            'category_images' => [
//                'icon' => 'fa fa-circle-o'
//            ]
        ]
    ],
    'Tags' => [
        'icon' => 'fa fa-tags',
        'pages' => [
            'taggs' => [
                'icon' => 'fa fa-circle-o'
            ],

//            'taggable_products' => [
//                'icon' => 'fa fa-circle-o'
//            ],

            'taggable_subcategories' => [
                'icon' => 'fa fa-circle-o'
            ]
        ]
    ],
    'Blog' => [
        'icon' => 'fa fa-archive',
        'pages' => [
            'posts' => [
                'icon' => 'fa fa-file-text-o'
            ],

            'post_images' => [
                'icon' => 'fa fa-file-text-o'
            ]
        ]
    ],
    'Secondary Content' => [
        'page_header' => 'secondary content site',
        'pages' => [
            'pages' => [
                'icon' => 'fa fa-clone'
            ],
            'banners' => [
                'icon' => 'fa fa-object-group'
            ],
            'socials' => [
                'icon' => 'fa fa-facebook'
            ],
            'faq' => [
                'icon' => 'fa fa-comment'
            ]
        ]
    ],
    'Partners' => [
        'icon' => 'fa fa-group',
        'pages' => [
            'partners' => [
                'icon' => 'fa fa-circle-o'
            ],
            'partners_images' => [
                'icon' => 'fa fa-circle-o'
            ],
        ]
    ],
    'translate' => [
        'icon' => 'fa fa-graduation-cap'
    ],
    'General settings' => [
        'icon' => 'fa fa-gears',
        'pages' => [
            'method-delivery' => [
                'icon' => 'fa fa-circle-o'
            ],
            'method-payment' => [
                'icon' => 'fa fa-circle-o'
            ],
            'video' => [
                'icon' => 'fa fa-circle-o'
            ]
        ]
    ]
];
