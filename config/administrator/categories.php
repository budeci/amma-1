<?php

use App\Category;

return [
    'title' => 'Categories',

    'description' => 'Parent categories',

    'model' => Category::class,

    /*
    |-------------------------------------------------------
    | Columns/Groups
    |-------------------------------------------------------
    |
    | Describe here full list of columns that should be presented
    | on main listing page
    |
    */
    'columns' => [
        'id',

        'name',

        'slug',

        'show' => [
            'title' => 'Show in',
            'elements' => [
                'show_in_footer' => [
                    'title' => 'footer',
                    'output' => function($row) {
                        if($row->show_in_footer == 1)
                            return '<b>Yes</b>';

                        return '<b>No</b>';
                    }
                ],
                'show_in_sidebar' => [
                    'title' => 'sidebar',
                    'output' => function($row) {
                        if($row->show_in_sidebar == 1)
                            return '<b>Yes</b>';

                        return '<b>No</b>';
                    }
                ]
            ]
        ],

        'active' => [
            'visible' => function() {},
            'output' => function($row) {
                return output_boolean($row);
            }
        ],

        'dates' => [
            'elements' => [
                'created_at',
                'updated_at'
            ]
        ]
    ],

    /*
    |-------------------------------------------------------
    | Actions available to do, including global
    |-------------------------------------------------------
    |
    | Global actions
    |
    */
    'actions' => [

    ],

    /*
    |-------------------------------------------------------
    | Eloquent With Section
    |-------------------------------------------------------
    |
    | Eloquent lazy data loading, just list relations that should be preloaded
    |
    */
    'with' => [

    ],

    /*
    |-------------------------------------------------------
    | QueryBuilder
    |-------------------------------------------------------
    |
    | Extend the main scaffold index query
    |
    */
    'query' => function ($query) {
        return $query->parent();
    },

    /*
    |-------------------------------------------------------
    | Global filter
    |-------------------------------------------------------
    |
    | Filters should be defined here
    |
    */
    'filters' => [
        'id' => filter_hidden(),

        'name' => filter_text('Name', function ($query, $value) {
            return $query->select('*')
                ->where('name', 'like', '%'.$value.'%')
                ->translated();
        }),

        'show_in_footer' => filter_select('Show in footer only', [
            '' => '-- Any --',
            '1' => '-- Yes --',
            '0' => '-- No --',
        ]),

        'show_in_sidebar' => filter_select('Show in sidebar only', [
            '' => '-- Any --',
            '1' => '-- Yes --',
            '0' => '-- No --',
        ]),

        'active' => filter_select('Active', [
            '' => '-- Any --',
            '1' => '-- Active --',
            '0' => '-- None Active --',
        ]),
    ],

    /*
    |-------------------------------------------------------
    | Editable area
    |-------------------------------------------------------
    |
    | Describe here all fields that should be editable
    |
    */
    'edit_fields' => [

        'id' => form_key(),

        'name' => form_text() + translatable(),

        'type' => [
            'type' => 'hidden',
            'value' => 'parent'
        ],

        'show_in_footer' => form_select('Show in footer', [
            0 => '-- No --',
            1 => '-- Yes --'
        ]),

        'show_in_sidebar' => form_select('Show in sidebar', [
            0 => '-- No --',
            1 => '-- Yes --'
        ]),

        'active' => form_select('Active', [
            1 => '-- Yes --',
            0 => '-- No --'
        ]),
    ]
];