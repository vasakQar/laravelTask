<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLocalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'lang_id',
        'name'
    ];

    public function language(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(language::class, 'lang_id', 'id');
    }
}
