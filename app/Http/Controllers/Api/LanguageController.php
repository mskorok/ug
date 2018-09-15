<?php

namespace App\Http\Controllers\Api;

use App\Models\Geo\Language;

/**
 * Class LanguageController
 * @package App\Http\Controllers\Api
 */
class LanguageController extends RestController
{
    const MODEL_CLASS = Language::class;

    public function index()
    {
        try {
            $qb = Language::query();

            return parent::getCollection($qb);
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }
}
