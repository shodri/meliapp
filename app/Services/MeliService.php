<?php

namespace App\Services;
use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithMarketResponses;
use App\Traits\AuthorizesMarketResquests;

class MeliService
{
    use ConsumesExternalServices, InteractsWithMarketResponses, 
        AuthorizesMarketResquests;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.meli.base_uri');
    }

    public function getCategories()
    {
        return $this->makeRequest('GET', 'sites/MLA/categories');
    }

    public function getBrands()
    {
        return $this->makePostRequest('POST', 'catalog_domains/MLU-CARS_AND_VANS/attributes/BRAND/top_values');
    }

    public function getModels()
    {
        return $this->makePostRequest('POST', 'catalog_domains/MLU-CARS_AND_VANS/attributes/MODEL/top_values');
    }
    public function getCurrencies()
    {
        return $this->makeRequest('GET', 'currencies');
    }
    public function getCategoryProducts($id)
    {
        return $this->makeRequest('GET', "categories/{$id}/products");
    }
    
    public function getUser($userId)
    {
       return $this->makeRequest('GET', "users/{$userId}");
    }

    public function getUserInformation()
    {
       return $this->makeRequest('GET', "users/me");

    }

    public function getVehicles()
    {
        return $this->makeRequest('GET', "/users/273451002/items/search?category_id=MLU1744");
    }

    public function getItem($meliId)
    {
        return $this->makeRequest('GET', "/items/{$meliId}");
    }

    public function getDescription($meliId)
    {
        return $this->makeRequest('GET', "/items/{$meliId}/description");
    }

    public function getQuestions($meliId)
    {
        return $this->makeRequest('GET', "/questions/search" ,"item={$meliId}&api_version=4");
    }

    public function publishAnswer( $productData)
    {
        return $this->makeRequest(
            'POST', 
            "answers", 
            [], 
            $productData, 
            ['Content-Type' => 'application/json'], 
            $hasFile = false,
            $isJson = true
        );
    }

    public function publishVehicle($vehicletData)
    {
        return $this->makeRequest(
            'POST', 
            "items", 
            [], 
            $vehicletData, 
            ['Content-Type' => 'application/json'], 
            $hasFile = false,
            $isJson = true
        );
    }

    public function publishDescription($meliId, $description)
    {
        return $this->makeRequest(
            'POST', 
            "items/{$meliId}/description", 
            [], 
            $description, 
            ['Content-Type' => 'application/json'], 
            $hasFile = false,
            $isJson = true
        );
    }


    public function getErrorImage($pictureId)
    {
        return $this->makeRequest('GET', "/pictures/{$pictureId}/errors?");
    }

    public function pausePublication($meliId)
    {
        return $this->makeRequest(
            'PUT', 
            "items/{$meliId}", 
            [], 
            ['status' => 'paused'], 
            ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 
            $hasFile = false,
            $isJson = false
        );

    }





    /*************  Curso ***************/

    public function getProducts()
    {
        return $this->makeRequest('GET', 'products');
    }

    public function getProduct($id)
    {
        return $this->makeRequest('GET', "products/{$id}");
    }

    /**
     * Publish a product on the API
     * @param integer $sellerId
     * @param array $productData
     * @return \stdClass
     */
    public function publishProduct($sellerId, $productData)
    {
        return $this->makeRequest(
            'POST', 
            "sellers/{$sellerId}/products", 
            [], 
            $productData, 
            [], 
            $hasFile = true
        );
    }

    /**
     * Associate a created product with an existing category
     * @param int $productId
     * @param int $categoryId
     * @return \stdClass
     */
    public function setProductCategory($productId, $categoryId)
    {
        return $this->makeRequest(
            'PUT', 
            "products/{$productId}/categories/{$categoryId}",
        );
    }

    public function updateProduct($sellerId, $productId, $productData)
    {
        $productData['_method'] = 'PUT';

        return $this->makeRequest(
            'POST', 
            "sellers/{$sellerId}/products/{$productId}", 
            [], 
            $productData, 
            [], 
            $hasFile = isset($productData['picture'])
        );
    }

    public function purchaseProduct($productId, $buyerId, $quantity)
    {
        return $this->makeRequest(
            'POST', 
            "products/{$productId}/buyers/{$buyerId}/transactions", 
            [], 
            ['quantity' => $quantity], 
        );
    }
    
    public function getPurchases($buyerId)
    {
        return $this->makeRequest('GET', "buyers/{$buyerId}/products");
    }

    public function getPublications($sellerId)
    {
        return $this->makeRequest('GET', "sellers/{$sellerId}/products");
    }

}