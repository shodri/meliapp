<?php

namespace App\Http\Controllers\Panel;

use App\Models\PanelProduct;
use App\Http\Controllers\Controller;
use App\Models\Scopes\AvailableScope;
use App\Services\MeliService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    
    public function __construct(MeliService $meliService)
    {
        $this->middleware('auth')->except(['showProduct']);

        parent::__construct($meliService);
    }

    
    public function index()
    {

        return view('products.index')->with([
            'products' => PanelProduct::without('images')->get(),
        ]);
    }

    public function create()
    {

        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        //dd($request->validated());}}
        $product = PanelProduct::create($request->validated()); //los fillable

        foreach ($request->images as $image){
            $product->images()->create([
                'path' => 'images/' . $image->store('products', 'images'),
            ]);
        }


        return redirect()
                ->route('products.index')
                ->withSuccess("The new product with id {$product->id} was created");

    }

    public function show(PanelProduct $product)
    {

        return view('products.show')->with([
            'product' => $product,
        ]);

       // dd($product);

    }

    public function edit(PanelProduct $product){

        return view('products.edit')->with([
            'product' => $product,
        ]);


    }

    public function update(ProductRequest $request, PanelProduct $product)
    {
        // $request->validate();
        // dd($request->validated());

        // $product = Product::findOrFail($product);

        $product->update($request->validated());

        if($request->hasFile('images')){

            foreach ($product->images as $image){
                $path = storage_path("app/public/{$image->path}");

                File::delete($path);

                $image->delete();
            }

            foreach ($request->images as $image){
                $product->images()->create([
                    'path' => 'images/' . $image->store('products', 'images'),
                ]);
            }
        }
    

        return redirect()
                ->route('products.index')
                ->withSuccess("The product with id {$product->id} was edited");


    }

    public function destroy(PanelProduct $product){

        // $product = Product::findOrFail($product);

        $product->delete();

        return redirect()
                ->route('products.index')
                ->withSuccess("The new product with id {$product->id} was deleted");;


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
        $this->meliService->purchaseProduct($id, $request->user()->meli_id, 1);

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
       // dd($categories);
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

        $productData = $this->meliService->publishProduct($request->user()->meli_id, $productData);

        $this->meliService->setProductCategory($productData->id, $request->category);

        $this->meliService->updateProduct($request->user()->meli_id, $productData->id, ['situation' => 'available']);

        return redirect()
            ->route('products.api-show', 
            [
                $productData->title,
                $productData->id,
            ])
            ->with('success', ['Product created successfully']);

    }
    
}
