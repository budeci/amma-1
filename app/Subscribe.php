<?php

namespace App;

use App\Traits\ActivateableTrait;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use ActivateableTrait;

    /**
     * @var string
     */
    protected $table = 'subscribers';

    /**
     * @var array
     */
    protected $fillable = ['email', 'token', 'active'];
}