<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatisticsController extends Controller
{

    /**
     * Get statistic's for items
     *
     * @param Request $request
     * @return Illuminate\Http\Response
     */
    public function items(Request $request)
    {
        if (!$request->has('type') || !in_array($request->type, Item::STATISTICS_TYPES)) {
            $request->merge(['type' => '*']);
        }

        return new Response(['data' => Item::statistics($request->type)]);
    }
}
