<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeliService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MeliService $meliService)
    {
        $this->middleware('auth');

        parent::__construct($meliService);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the purchases of the user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPurchases(Request $request)
    {
        $purchases = $this->meliService->getPurchases($request->user()->service_id);

        return view('purchases')->with([
            'purchases' => $purchases,
        ]);
    }

        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showProducts(Request $request)
    {
        $publications = $this->meliService->getPublications($request->user()->service_id);

        return view('publications')->with([
            'publications' => $publications,
        ]);
    }
}
