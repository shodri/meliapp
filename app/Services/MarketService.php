<?php

namespace App\Services;
use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithMarketResponses;
use App\Traits\AuthorizesMarketResquests;

class MarketService
{
    use ConsumesExternalServices, InteractsWithMarketResponses, 
        AuthorizesMarketResquests;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
    }

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

    /**
     * Update a product on the API
     * @param integer $sellerId
     * @param int $productId
     * @param array $productData
     * @return \stdClass
     */
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


    /**
     * Update a product on the API
     * @param int $productId
     * @param int $buyerId
     * @param int $quantity
     * @return \stdClass
     */
    public function purchaseProduct($productId, $buyerId, $quantity)
    {
        return $this->makeRequest(
            'POST', 
            "products/{$productId}/buyers/{$buyerId}/transactions", 
            [], 
            ['quantity' => $quantity], 
        );
    }


    public function getCategories()
    {
        return $this->makeRequest('GET', 'categories');
    }

    public function getCategoryProducts($id)
    {
        return $this->makeRequest('GET', "categories/{$id}/products");
    }

    public function getUserInformation()
    {
        return $this->makeRequest('GET', "users/me");
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