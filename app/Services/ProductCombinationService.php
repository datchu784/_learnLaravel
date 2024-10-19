<?php

namespace App\Services;

use App\Repositories\Interfaces\IProductAttributeRepository;
use App\Repositories\Interfaces\IProductCombinationRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IProductTypeRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductCombinationService extends BaseService
{
    protected  $productTypeRepository;
    protected  $productRepo;
    protected  $productAttributeRepo;

    public function __construct(
        IProductCombinationRepository $repository,
        IProductTypeRepository $productTypeRepository,
        IProductRepository $productRepo,
        IProductAttributeRepository $productAttributeRepo)
    {
        $this->repository = $repository;
        $this->productTypeRepository = $productTypeRepository;
        $this->productRepo= $productRepo;
        $this->productAttributeRepo = $productAttributeRepo;
    }

    public function paginate($perPage = 4)
    {
        $products = $this->repository->joinImage($perPage);
        return $products;
    }

    public function create(array $data)
    {
        $product = $this->repository->create($data['product']);
        foreach($data['attributes'] as $atribute)
        {
            $atribute['product_combination_id'] = $product->id;
            $this->productAttributeRepo->create($atribute);
        }

        $product->productAttributes;
        return $product;
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
