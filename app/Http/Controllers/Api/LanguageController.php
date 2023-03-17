<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $languages = language::all();

        return response()->json($languages);
    }
}
