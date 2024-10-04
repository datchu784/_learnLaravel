<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductAttributeRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IProductTypeRepository;


use Illuminate\Support\Facades\DB;
use Exception;

class ProductService extends BaseService
{
    protected  $productTypeRepository;
    protected  $productAttributeRepo;

    public function __construct(
        IProductRepository $repository,
        IProductTypeRepository $productTypeRepository,
        IProductAttributeRepository $productAttributeRepo)
    {
        $this->repository = $repository;
        $this->productTypeRepository = $productTypeRepository;
        $this->productAttributeRepo = $productAttributeRepo;
    }

    public function searchProducts($keyword)
    {
        return $this->repository->search($keyword);
    }


    public function updateQuantityProduct($id, $quantity)
    {
        DB::beginTransaction();
        try {
            $product = $this->repository->updateQuantity($id, $quantity);
            $productTypeId = $product->product_type_id;
            $productType = $this->productTypeRepository->updateQuantity($productTypeId, $quantity);

            DB::commit();
            $quantityStatistics = " {$product->name}:
             {$product->quantity} and {$productType->name}:
             {$productType->quantity}";

            return $quantityStatistics;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getById($id)
    {
         return $this->productAttributeRepo->joinToFilter()->where("product_id", $id);
    }



}



