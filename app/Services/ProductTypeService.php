<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductTypeRepositoryInterface;
use App\Exceptions\ProductTypeNotFoundException;
use App\Models\ProductType;

class ProductTypeService
{
    protected $productTypeRepository;

    public function __construct(ProductTypeRepositoryInterface $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function getAllProductTypes()
    {
        return $this->productTypeRepository->getAllProductTypes();
    }

    public function getProductTypeById($id)
    {
        return $this->productTypeRepository->getProductTypeById($id);
    }

    public function createProductType(array $productTypeDetails)
    {
        return $this->productTypeRepository->createProductType($productTypeDetails);
    }

    public function updateProductType($id, array $newDetails)
    {
        return $this->productTypeRepository->updateProductType($id, $newDetails);
    }

    public function deleteProductType($id)
    {
        $productType =  $this->productTypeRepository->existsProductType($id);
        if (!$productType) {
            throw new ProductTypeNotFoundException($id);
        }
        $this->productTypeRepository->deleteProductType($id);
    }
}
