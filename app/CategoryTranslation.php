<?php

namespace App;

use App\Libraries\TranslatableModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class CategoryTranslation extends TranslatableModel implements SluggableInterface
{
    use SluggableTrait;

    /**
     * @var string
     */
    protected $table = 'category_translations';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'seo_title', 'seo_description', 'seo_keywords'
    ];

    /**
     * @var array
     */
    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug'
    );
}