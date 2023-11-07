<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Location;
use App\Models\Vehicle;
use App\Models\Vehiclebrand;
use App\Models\Vehiclemodel;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::take(4)->get();
        $brands = Vehiclebrand::all()->sortBy('name'); 
        $locations = Location::all()->sortBy('name'); 
        $banners = Banner::all()->sortBy('title'); 

        return view('front.index')->with([
            'banners' => $banners,
            'brands' => $brands,
            'locations' => $locations,
            'vehicles' => $vehicles,
        ]);
    }

    public function getModels(Request $request)
    {
        $brand = $request->input('brand');
        $models = Vehiclemodel::where('brand_id', $brand)->pluck('name', 'id');
        $modelOptions = '<option value="" selected>Select..</option>';
        foreach ($models as $id => $name) {
            $modelOptions .= '<option value="' . $id . '">' . $name . '</option>';
        }
        return $modelOptions;
    }

    public function vehicles(Request $request, $condition = null)
    {

        $brand = $request->input('brand');
        $model = $request->input('model');

        $minKms = $request->input('minKms');
        $maxKms = $request->input('maxKms');
        $minAnio = $request->input('minAnio');
        $maxAnio = $request->input('maxAnio');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');

        $orderBy = $request->input('orderBy');
        $vehicles = Vehicle::query();
        $models = null;

        if ($condition) {
            $vehicles->where('condition', $condition);
        }

        if ($brand) {
            $vehicles->where('brand_id', $brand);
            $models = Vehiclemodel::query()->where('brand_id', $brand)->orderBy('name', 'asc')->get();
            //dd($models);
        }

        if ($model) {
            $vehicles->where('model_id', $model);
        }

        if ($maxPrice) {
            $vehicles->where('price', '<=', $maxPrice);
        }
        if ($minPrice) {
            $vehicles->where('price', '>=', $minPrice);
        }
        if ($maxAnio) {
            $vehicles->where('year', '<=', $maxAnio);
        }
        if ($minAnio) {
            $vehicles->where('year', '>=', $minAnio);
        }
        if ($maxKms) {
            $vehicles->where('kilometers', '<=', $maxKms);
        }
        if ($minKms) {
            $vehicles->where('kilometers', '>=', $minKms);
        }

        $order = 'year desc';
		switch($orderBy) {
			case 1: $order = 'price'; break;
			case 2: $order = 'price desc'; break;
			case 3: $order = 'brand_id'; break;
			case 4: $order = 'year desc'; break;
			case 5: $order = 'kilometers'; break;
		}
        //\DB::enableQueryLog();
        $vehicles = $vehicles->orderByRaw($order)->get();
        //dd(\DB::getQueryLog());
        $brands = Vehiclebrand::all()->sortBy('year'); 

        return view('front.vehicles')->with([
            'vehicles' => $vehicles,
            'brands' => $brands,
            'models' => $models,
            'selectedBrand' => $brand,
            'selectedModel' => $model,
            'maxPrice' => $maxPrice,
            'minPrice' => $minPrice,
            'maxAnio' => $maxAnio,
            'minAnio' => $minAnio,
            'maxKms' => $maxKms,
            'minKms' => $minKms,
        ]);
    }

    public function vehicle(Vehicle $vehicle)
    {
        // dd($vehicle);
        $similarPrice = Vehicle::where('price', '>=', $vehicle->price - 3000) // Ajusta el rango de precio según tus necesidades
        ->where('price', '<=', $vehicle->price + 3000)
        ->where('id', '!=', $vehicle->id) // Excluye el vehículo actual
        ->get();

        $similarModel = Vehicle::where('model_id', $vehicle->model_id)
        ->where('id', '!=', $vehicle->id) // Excluye el vehículo actual
        ->get();
         //dd($similarPrice, $similarModel);

        return view('front.usado')->with([
            'vehicle' => $vehicle,
            'similarPrice' => $similarPrice,
            'similarModel' => $similarModel,
        ]);
    }
}
