<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {




        return response()->json([
            'users' => User::query()->statistics()->first(),
            'agents' => Agent::query()->statistics()->first(),
            'deliveries' => Delivery::query()->statistics()->first(),
            'invoices' => Invoice::query()->statistics()->first(),
            'products'=>Product::selectRaw('count(*) as total')->first(),
            'offers'=>Product::selectRaw('count(*) as total')->first(),
        ]);
    }
}
