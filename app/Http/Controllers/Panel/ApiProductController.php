<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Services\MeliService;
use App\Http\Controllers\Controller;

use \App\Models\Attribute;
use \App\Models\AttributeVehicle;
use \App\Models\Currency;
use \App\Models\Fuel;
use \App\Models\Location;
use \App\Models\Segment;
use \App\Models\Vehicle;
use \App\Models\Vehiclebrand;
use \App\Models\Vehiclemodel;
use \App\Models\Vehicleversion;
use \App\Models\Question;
use \App\Models\Answer;

use App\Http\Requests\AnswerRequest;
use App\Http\Controllers\Panel\DB;
use Carbon\Carbon;


class ApiProductController extends Controller
{

    public function __construct(MeliService $meliService)
    {
        $this->middleware('auth')->except(['showProduct']);

        parent::__construct($meliService);
    }

    public function showUser()
    {
        $user = $this->meliService->getUserInformation();
        dd($user);
            return view('products.show')->with([
                'product' => $user,
            ]);
    }
    public function sync()
    {
        return view('meli.sync');
    }

    public function updateVehicles()
    {
        $vehicles = $this->meliService->getVehicles();
		//$procId = date('YmdHis');
        //dd($vehicles);

            foreach($vehicles->results as $meliId) {
                $id = $this->updateVehicle($meliId);
            }

            return redirect()
                ->route('meli.sync')
                ->withSuccess("La sincronización fue realizada correctamente");

    }

    public function updateVehicle($meliId)
    {
        $item = $this->meliService->getItem($meliId);
        //dd($item);

        if ($item->category_id == 'MLU1744') {

            foreach($item->attributes as $key => $attribute) {

                $item->attributes2[$attribute->id] = $attribute;

            }

            

            $brand = Vehiclebrand::firstOrCreate(
                ['name' => strtoupper($item->attributes2["BRAND"]->value_name)],
                ['id' => $item->attributes2["BRAND"]->value_id],
            );

            $model = Vehiclemodel::firstOrCreate(
                ['id' => $item->attributes2["MODEL"]->value_id],
                [
                    'brand_id' => $brand->id,
                    'name' => strtoupper($item->attributes2["MODEL"]->value_name),
                ]
            );

            $version = Vehicleversion::updateOrCreate(
                ['model_id' => strtoupper($item->attributes2["MODEL"]->value_id),'name' => strtoupper($item->attributes2["TRIM"]->value_name)],
                [
                    'model_id' => strtoupper($item->attributes2["MODEL"]->value_id),
                    'name' => strtoupper($item->attributes2["TRIM"]->value_name)
                ],
            );

            $fuel = Fuel::firstOrCreate(
                [ 'name' => $item->attributes2["FUEL_TYPE"]->value_name],
            );

            $currency = Currency::firstOrCreate(
                [ 'name' => $item->currency_id],
            );

            if(isset($item->attributes2["VEHICLE_BODY_TYPE"]))
            {
                $segment = Segment::firstOrCreate(
                    [ 'name' => $item->attributes2["VEHICLE_BODY_TYPE"]->value_name],
                );
                $segment = $segment->id;

            }else{
                $segment = NULL;
            }

            $location = Location::updateOrCreate(
                [ 'meli_id' => $item->seller_address->id],
                [
                    'address' =>    $item->seller_address->address_line,
                    'country' =>    $item->seller_address->country->name,
                    'country_id' => $item->seller_address->country->id ? $item->seller_address->country->id : "",
                    'state' =>      $item->seller_address->state->name,
                    'state_id' =>   $item->seller_address->state->id,
                    'city' =>       $item->seller_address->city->name,
                    'city_id' =>    $item->seller_address->city->id,
                    'zip_code' =>   $item->seller_address->zip_code,
                    'lat' =>        $item->seller_address->latitude,
                    'long' =>       $item->seller_address->longitude,
                    //'seller' => $item->seller_contact->contact,
					'telephone' =>  trim($item->seller_contact->country_code . ' ' . $item->seller_contact->area_code . ' ' . $item->seller_contact->phone),
					'email' =>      $item->seller_contact->email,
                ]
            );

            $vehicle = Vehicle::updateOrCreate(
                ['meli_id' => $meliId],
                [
                    'brand_id' => $brand->id,
                    'model_id' => $model->id,
                    'version_id' => $version->id,
                    'currency_id' => $currency->id,
                    'fuel_id' => $fuel->id,
                    'location_id' => $location->id,
                    'segment_id' => $segment,
                    'title' => $item->title,
					'color' => $item->attributes2["COLOR"]->value_name, 
					'kilometers' => $item->attributes2["KILOMETERS"]->values[0]->struct->number, 
					'price' => $item->price,
					'year' => $item->attributes2["VEHICLE_YEAR"]->value_name,
					'license_plate' => (isset($item->attributes2["LICENSE_PLATE"]->value_name)) ? $item->attributes2["DOORS"]->value_name : "",
					'motor' => (isset($item->attributes2["ENGINE"]->value_name)) ? $item->attributes2["ENGINE"]->value_name : "",
					'steering' => (isset($item->attributes2["STEERING"]->value_name)) ? $item->attributes2["STEERING"]->value_name : "",
					'doors' => (isset($item->attributes2["DOORS"]->value_name)) ? $item->attributes2["DOORS"]->value_name : "",
					'condition' => (isset($item->attributes2["ITEM_CONDITION"]->value_name)) ? $item->attributes2["ITEM_CONDITION"]->value_name : "",
					'status' => $item->status == 'active',
					'created_at' => $item->date_created,
					'updated_at' => $item->last_updated,
					'meli_link' => $item->permalink,
					'description' => $this->getItemDescription($meliId),
					
                ],
            );

            $attributeIds = [];

            foreach ($item->attributes as $attribute) {
                $attributeModel = Attribute::updateOrCreate(
                    ['name' => $attribute->name],
                    [
                        'name' => $attribute->name,
                        'meli_id' => $attribute->id,
                        'type' => $attribute->value_type,
                    ]
                );
        
                $attributeId = $attributeModel->id;
                $attributeIds[$attribute->id] = $attributeId;
        
                AttributeVehicle::create([
                    'vehicle_id' => $vehicle->id,
                    'attribute_id' => $attributeId,
                    'value' => $attribute->value_name,
                ]);
            }

            foreach ($item->pictures as $image){
                $vehicle->images()->create([
                    'path' => $image->secure_url,
                ]);
            }

            $questions = $this->getItemQuestions($meliId);

            foreach($questions as $question){
                Question::updateOrCreate(
                    ['id' => $question->id],
                    [
                        'date_created'  => Carbon::parse($question->date_created)->toDateTimeString(),
                        'item_id'       => $question->item_id,
                        'status'        => $question->status,
                        'text'          => $question->text,
                        'from'          => $question->from->id,
                    ]
                );

                if($question->status == 'ANSWERED'){
                    Answer::updateOrCreate(
                        ['text' => $question->answer->text],
                        [
                            'date_created'  => Carbon::parse($question->answer->date_created)->toDateTimeString(),
                            'question_id'   => $question->id,
                            'status'        => $question->answer->status,
                            'text'          => $question->answer->text,
                        ]
                    );
                }
            }

        }
            return $vehicle->id;
    }

    public function getBrands()
    {
        $brands = $this->meliService->getBrands();
        dd($brands);
        foreach ($brands as $brand){
            $brand = Vehiclebrand::firstOrCreate(
                ['name' => strtoupper($item->attributes2["BRAND"]->value_name)],
                ['id' => $item->attributes2["BRAND"]->value_id],
            );  
        }

    }

    public function getModels()
    {
        $models = $this->meliService->getModels();
        dd($models);
        foreach ($brands as $brand){
            $brand = Vehiclebrand::firstOrCreate(
                ['name' => strtoupper($item->attributes2["BRAND"]->value_name)],
                ['id' => $item->attributes2["BRAND"]->value_id],
            );  
        }
    }

    public function getItemDescription($meliId)
    {
        $description = $this->meliService->getDescription($meliId);
        if($description){
            return $description->plain_text;
        }else{
            return null;
        }
    }

    public function getItemQuestions($meliId)
    {
        $questions = $this->meliService->getQuestions($meliId);
        return $questions->questions;
    }

    public function answerQuestion(AnswerRequest $request, Question $question)
    {
        $productData['question_id'] = $question->id;
        $productData['text'] = $request->input('answer');
        $questions = $this->meliService->publishAnswer($productData);
        return view('notifications.index')->withSuccess("La respuesta fue enviada correctamente");
    } 

    public function showVehicle($meliId)
    {
        $vehicle = $this->meliService->getVehicle($meliId);
        dd($vehicle);
            return view('products.show')->with([
                'product' => $vehicle,
            ]);
    }


    public function getErrorImage($imageId)
    {
        $error = $this->meliService->getErrorImage($imageId);
        dd($error);
    }

    public function pausePublication(Vehicle $vehicle)
    {
        $resp = $this->meliService->pausePublication($vehicle->meli_id);
        dd($resp);
    }





    public function showProduct($title, $id)
    {
        $product = $this->meliService->getProduct($id);
        //dd($products);
            return view('products.show')->with([
                'product' => $product,
            ]);
    }

        /**
     * Purchase a product
     *
     * @return 
     */
    public function purchaseProduct(Request $request, $title, $id)
    {
        $this->meliService->purchaseProduct($id, $request->user()->service_id, 1);

        return redirect()
        ->route('products.show', 
        [
            $title,
            $id,
        ])
        ->with('success', ['Product purchased']);
    }

        /**
     * Show the form to publish a product.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showPublishProductForm()
    {
        $categories = $this->meliService->getCategories();

        return view('products.publish')->with([
            'categories' => $categories,
        ]);
    }

    /**
     * Publish a product.
     *
     */



    public function publishProduct(Request $request)
    {
        $rules = [
            'title' => 'required',
            'details' => 'required',
            'stock' => 'required|min:1',
            'category' => 'required',
        ];

        $productData = $this->validate($request, $rules);

        $productData['picture'] = fopen($request->picture->path(), 'r');

        $productData = $this->meliService->publishProduct($request->user()->service_id, $productData);

        $this->meliService->setProductCategory($productData->identifier, $request->category);

        $this->meliService->updateProduct($request->user()->service_id, $productData->identifier, ['situation' => 'available']);

        return redirect()
            ->route('products.api-show', 
            [
                $productData->title,
                $productData->identifier,
            ])
            ->with('success', ['Product created successfully']);

    }
    
}
