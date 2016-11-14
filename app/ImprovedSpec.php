<?php

namespace App;

use Keyhunter\Administrator\Repository;

class ImprovedSpec extends Repository
{
    /**
     * @var string
     */
    protected $table = 'product_improved_specifications';

    /**
     * @var array
     */
    protected $fillable = [ 'product_id', 'size', 'color_hash', 'amount' ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @var bool
     */
    public $timestamps = false;
}