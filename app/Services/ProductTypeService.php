<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductTypeRepositoryInterface;
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

    public function deleteProductType($id)
    {
        $this->productTypeRepository->deleteProductType($id);
    }

    public function createProductType(array $productTypeDetails)
    {
        return $this->productTypeRepository->createProductType($productTypeDetails);
    }

    public function updateProductType($id, array $newDetails)
    {
        return $this->productTypeRepository->updateProductType($id, $newDetails);
    }
}
