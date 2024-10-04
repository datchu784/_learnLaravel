<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductCombinationRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IProductTypeRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductCombinationService extends BaseService
{
    protected  $productTypeRepository;
    protected  $productRepo;

    public function __construct(
        IProductCombinationRepository $repository,
        IProductTypeRepository $productTypeRepository,
        IProductRepository $productRepo)
    {
        $this->repository = $repository;
        $this->productTypeRepository = $productTypeRepository;
        $this->productRepo= $productRepo;
    }

    public function paginate($perPage = 4)
    {
        $products = $this->repository->joinImage($perPage);
        return $products;
    }

    public function getById($id)
    {
        return $this->repository->joinImageById($id);
    }

    public function updateQuantityProduct($id, $quantity)
    {
        DB::beginTransaction();
        try {
            $productCombination = $this->repository->updateQuantity($id, $quantity);
            $productId = $productCombination->product_id;
            $product = $this->productRepo->getById($productId);
            $productTypeId = $product->product_type_id;
            $productType = $this->productTypeRepository->updateQuantity($productTypeId, $quantity);

            DB::commit();
            $quantityStatistics = " {$productCombination->name}:
             {$productCombination->stock} and {$productType->name}:
             {$productType->quantity}";

            return $quantityStatistics;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
