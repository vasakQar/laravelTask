<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const EN_CODE = 'en';

    protected $fillable = [
        'price',
        'currency',
        'stock',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function names(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductLocalization::class);
    }

    /**
     * @param null $langId
     * @return array
     */
    public function getName($langId = null)
    {
        $userLangId = auth()->user()->lang_id;

        $name = '';
        $languageId = '';

        if (!$langId) {
            $prodLocalization = $this->names()->where('lang_id', $userLangId)->first();
        } else {
            $prodLocalization = $this->names()->where('lang_id', $langId)->first();
        }

        if (!$prodLocalization) {
            $prodLocalization = $this->names()
                ->whereHas('language', function ($query) {
                    $query->where('code', $this::EN_CODE);
                })
                ->first();
            if (!$prodLocalization) {
                $prodLocalization = $this->names()->first();
            }
        }

        if ($prodLocalization) {
            $name = $prodLocalization->name;
            $languageId = $prodLocalization->lang_id;
        }

        return [
            'name' => $name,
            'lang_id' => $languageId
        ];
    }
}
