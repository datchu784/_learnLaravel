<?php

namespace App\Services;

use App\Repositories\Interfaces\IAttributeRepository;
use App\Repositories\Interfaces\IProductAttributeRepository;
use App\Repositories\Interfaces\IProductTypeRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductAttributeService extends BaseService
{
    protected $attributeRepo;
    protected  $productTypeRepository;

    public function __construct(
        IProductAttributeRepository $repository,
        IAttributeRepository $attributeRepo,
        IProductTypeRepository $productTypeRepository
    ) {
        $this->repository = $repository;
        $this->attributeRepo = $attributeRepo;
        $this->productTypeRepository = $productTypeRepository;
    }

    public function paginate($perPage = 4)
    {
        $collection = $this->repository->joinToFilter();

        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $items = $collection->slice($offset, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $items,
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginator;
    }

    public function filter($data)
    {
        $filteredProducts  = $this->repository->joinToFilter();

        $attributes = $this->attributeRepo->getAll();

         // vì ở trên đã được sữa lại trả về collection nên không cần câu lệnh dưới nữa
        //$filteredProducts = collect($query);

        foreach ($attributes as $attribute) {
            $attributeName = strtolower($attribute->name);
            if (isset($data[$attributeName])) {
                $filteredProducts = $filteredProducts->where("attributes.{$attribute->name}", $data[$attributeName]);
            }
        }


        if (isset($data['min_price'])) {
            $filteredProducts = $filteredProducts->where('product_price', '>=', $data['min_price']);
        }
        if (isset($data['max_price'])) {
            $filteredProducts = $filteredProducts->where('product_price', '<=', $data['max_price']);
        }

        if (isset($data['stock'])) {
            $filteredProducts = $filteredProducts->where('stock', '>=', $data['stock']);
        }

        return $filteredProducts->values();
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
        $filteredProducts  = $this->repository->joinToFilter()->where('product_combination_id',$id);
        return $filteredProducts->values();

    }
}
