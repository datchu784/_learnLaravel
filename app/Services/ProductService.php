<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProduct()
    {
        return $this->productRepository->getAllProduct();
    }

    public function getProductById($id)
    {
        return $this->productRepository->getProductById($id);
    }

    public function deleteProduct($id)
    {
        $this->productRepository->deleteProduct($id);
    }

    public function createProduct(array $productTypeDetails)
    {

        return $this->productRepository->createProduct($productTypeDetails);
    }

    public function updateProduct($id, array $newDetails)
    {
        return $this->productRepository->updateProduct($id, $newDetails);
    }
}
