<?php

namespace App\Http\Controllers;

use App\Services\MeliService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $meliService;

    use AuthorizesRequests, ValidatesRequests;

    public function __construct(MeliService $meliService)
    {
        $this->meliService = $meliService;
    }
}
