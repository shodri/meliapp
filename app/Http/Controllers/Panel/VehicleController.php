<?php

namespace App\Http\Controllers\Panel;


use App\Models\Location;
use App\Models\Fuel;
use App\Models\Currency;
use App\Models\Segment;

use App\Models\Vehiclebrand;
use App\Models\Vehicleversion;
use App\Models\Vehicle;
use App\Http\Controllers\Controller;
use App\Models\Scopes\AvailableScope;
use App\Models\Vehiclemodel;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    
    public function index()
    {

        return view('vehicles.index')->with([
            'vehicles' => Vehicle::without('images')->get(),
        ]);
    }

    public function create()
    {
        $brands = Vehiclebrand::all()->sortBy('name'); 
        $locations = Location::all()->sortBy('name'); 
        $fuels = Fuel::all()->sortBy('name'); 
        $currencies = Currency::all()->sortBy('name'); 
        $segment = Segment::all()->sortBy('name'); 

        return view('vehicles.create')->with([
            'brands' => $brands,
            'locations' => $locations,
            'fuels' => $fuels,
            'currencies' => $currencies,
            'segment' => $segment,

        ]);
    }

    public function store(VehicleRequest $request)
    {
        //dd($request->validated());

        $vehicle = Vehicle::create($request->validated()); 

        if($request->images){
            foreach ($request->images as $image){
                $vehicle->images()->create([
                    'path' => 'images/' . $image->store('vehicles', 'images'),
                ]);
            }
        }


        return redirect()
                ->route('vehicles.index')
                ->withSuccess("The new vehicle with id {$vehicle->id} was created");

    }

    public function show(Vehicle $vehicle)
    {

        return view('vehicles.show')->with([
            'vehicle' => $vehicle,
        ]);

    }

    public function edit(Vehicle $vehicle){
        // dd ($vehicle);
        $selectedBrand = Vehiclebrand::find($vehicle->brand_id)->first();
        $selectedModel = Vehiclemodel::find($vehicle->model_id);
        $selectedLocation = Location::find($vehicle->location_id);
        
        $brands = Vehiclebrand::all()->sortBy('name'); 
        $locations = Location::all()->sortBy('name'); 
        $fuels = Fuel::all()->sortBy('name'); 
        $currencies = Currency::all()->sortBy('name'); 
        $segment = Segment::all()->sortBy('name'); 
        $models = $selectedBrand->models()->orderBy('name')->get();

        return view('vehicles.edit')->with([
            'vehicle' => $vehicle,
            'brands' => $brands,
            'models' => $models,
            'locations' => $locations,
            'fuels' => $fuels,
            'currencies' => $currencies,
            'segment' => $segment,
            'selectedBrand' => $selectedBrand, 
            'selectedModel' => $selectedModel, 
            'selectedLocation' => $selectedLocation, 
        ]);


    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {

        $vehicle->update($request->validated());

        if($request->hasFile('images')){

            foreach ($vehicle->images as $image){
                $path = storage_path("app/public/{$image->path}");

                File::delete($path);

                $image->delete();
            }

            foreach ($request->images as $image){
                $vehicle->images()->create([
                    'path' => 'images/' . $image->store('vehicles', 'images'),
                ]);
            }
        }
    

        return redirect()
                ->route('vehicles.index')
                ->withSuccess("El vehículo {$vehicle->brand->name} {$vehicle->vehiclemodel->name} patente {$vehicle->patent} fue editado correctamente");
    }

    public function destroy(Vehicle $vehicle)
    {
        foreach ($vehicle->images as $image){
            $path = storage_path("app/public/{$image->path}");

            File::delete($path);

            $image->delete();
        }

        $vehicle->delete();

        return redirect()
                ->route('vehicles.index')
                ->withSuccess("El vehiculo {$vehicle->brand->name} {$vehicle->model->name} {$vehicle->version->name} fue eliminado correctamente");
    }

    public function getVehicles(Request $request)
    {
        $vehicle = Vehicle::all(); 

        return json_encode($vehicle);
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

    public function getVersions(Request $request)
    {
        $model = $request->input('model');
        $models = Vehicleversion::where('model_id', $model)->pluck('name', 'id');
        $modelOptions = '<option value="" selected>Select..</option>';
        foreach ($models as $id => $name) {
            $modelOptions .= '<option value="' . $id . '">' . $name . '</option>';
        }
        return $modelOptions;
    }
}
