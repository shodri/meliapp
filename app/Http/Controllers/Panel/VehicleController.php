<?php

namespace App\Http\Controllers\Panel;


use App\Models\Attribute;
use App\Models\Location;
use App\Models\Fuel;
use App\Models\Currency;
use App\Models\Segment;
use App\Models\Vehiclebrand;
use App\Models\Vehicleversion;
use App\Models\Vehicle;

use App\Services\MeliService;
use App\Http\Controllers\Controller;
use App\Models\Scopes\AvailableScope;
use App\Models\Vehiclemodel;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    
    public function __construct(MeliService $meliService)
    {
        $this->middleware('auth')->except(['showProduct']);

        parent::__construct($meliService);
    }

    public function index($condition = null)
    {
        $query = Vehicle::without('images');

        if ($condition == 'usados') {
            $query->where('kilometers', '!=', 0);
        } elseif ($condition == '0km') {
            $query->where('kilometers', 0);
        }
    
        return view('vehicles.index')->with([
            'vehicles' => $query->get(),
            'condition' => $condition,
        ]);
    }

    public function create()
    {
        // $brands = Vehiclebrand::all()->sortBy('name'); 
        $brands = $this->meliService->getBrands();
        $models = $this->meliService->getModels();
        $locations = Location::all()->sortBy('name'); 
        $fuels = Fuel::all()->sortBy('name'); 
        $currencies = Currency::all()->sortBy('name'); 
        $segment = Segment::all()->sortBy('name'); 

        return view('vehicles.create')->with([
            'brands' => $brands,
            'models' => $models,
            'locations' => $locations,
            'fuels' => $fuels,
            'currencies' => $currencies,
            'segment' => $segment,

        ]);
    }

    public function store(VehicleRequest $request)
    {
        $attributes = $request->input('attributes');
        $brand_id = $request->input('brand_id');
        $model_id = $request->input('model_id');
        $brand_name = $request->input('brand_name');
        $model_name = $request->input('model_name');

        $brand = Vehiclebrand::firstOrCreate(
            ['name' => strtoupper($brand_name)],
            ['id' => $brand_id],
        );

        $model = Vehiclemodel::firstOrCreate(
            ['name' => strtoupper($model_name)],
            [
                'brand_id' => $brand_id,
                'name' => strtoupper($model_name),
            ]
        );

        $data = $request->validated();
        $data['model_id'] = $model->id;
        $data['brand_id'] = $brand->id;
        $vehicle = Vehicle::create($data); 

        foreach($attributes as $attribute){
            Attribute::create(['parameter' => $attribute, 'value' => 'Sí', 'vehicle_id' => $vehicle->id]); 
        }


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
        $selectedBrand = Vehiclebrand::find($vehicle->brand_id)->first();
        $selectedModel = Vehiclemodel::find($vehicle->model_id);
        $selectedLocation = Location::find($vehicle->location_id);
        
        $attributes = Attribute::where('vehicle_id', $vehicle->id)->get(); 
        $brands = Vehiclebrand::all()->sortBy('name'); 
        $locations = Location::all()->sortBy('name'); 
        $fuels = Fuel::all()->sortBy('name'); 
        $currencies = Currency::all()->sortBy('name'); 
        $segment = Segment::all()->sortBy('name'); 
        $models = $selectedBrand->models()->orderBy('name')->get();

        return view('vehicles.edit')->with([
            'attributes' => $attributes,
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

    public function publish(Vehicle $vehicle)
    {
        //dd ($vehicle);

        $pictures = [];
        $attributes = Attribute::all();

        foreach($vehicle->images as $image) {
            $pictures[] = [
                "source" => asset($image->path),
            ];
        }

        $vehicleData = [
            "title" => $vehicle->title,
            "description" => $vehicle->description,
            "channels" => ["marketplace"],
            "pictures" => $pictures,
            "video_id" => "",
            "category_id" => "MLU1744",
            "price" => $vehicle->price,
            "currency_id" => $vehicle->currency->name,
            "listing_type_id" => "silver",
            "available_quantity" => "1",
            "location" => [
                "address_line" => $vehicle->location->address,
                "zip_code" => $vehicle->location->zip_code,
                "city" => [
                    "id" => $vehicle->location->city_id,
                ]
            ],
            "attributes" => [
                [
                    "id" => "BRAND",
                    "value_name" => $vehicle->brand->name,
                ],
                [
                    "id" => "MODEL",
                    "value_name" => $vehicle->model->name,
                ],
                [
                    "id" => "TRIM",
                    "value_name" => $vehicle->version->name,
                ],
                [
                    "id" => "VEHICLE_YEAR",
                    "value_name" => $vehicle->year,
                ],
                [
                    "id" => "KILOMETERS",
                    "value_name" => $vehicle->kilometers."km",
                ],
                [
                    "id" => "FUEL_TYPE",
                    "value_name" => $vehicle->fuel->name,
                ],
                [
                    "id" => "COLOR",
                    "value_name" => $vehicle->color,
                ],
                [
                    "id" => "DOORS",
                    "value_name" => $vehicle->puertas,
                ]
            ]
        ];
    
        foreach ($attributes as $attribute) {
            $vehicleData["attributes"][] = [
                "id" => $attribute->parameter,
                "value_name" => $attribute->value
            ];
        }

        $resp = $this->meliService->publishVehicle($vehicleData);

        dd($resp);

        //$json = json_encode($data);
    
        // Luego, puedes usar $json para enviarlo a tu API
    
        // echo $json;
        // die();
    

        return redirect()
                ->route('vehicles.index')
                ->withSuccess("El vehículo {$vehicle->brand->name} {$vehicle->vehiclemodel->name} fue publicado correctamente");
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle = Vehicle::with('adicionalAttributes')->find($vehicle->id);
        //dd($vehicle->adicionalAttributes);
        foreach ($vehicle->adicionalAttributes as $attribute){
            $attribute->delete();
        }

        foreach ($vehicle->images as $image){
            $path = storage_path("app/public/{$image->path}");

            File::delete($path);

            $image->delete();
        }

        $vehicle->delete();

        return redirect()
                ->route('vehicles.index')
                ->withSuccess("El vehiculo {$vehicle->brand->name} {$vehicle->model->name} fue eliminado correctamente");
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
