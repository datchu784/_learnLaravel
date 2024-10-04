<?php

namespace App\Services;

use App\Repositories\Interfaces\IAttributeRepository;
use App\Repositories\Interfaces\IProductAttributeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
class ProductAttributeService extends BaseService
{
    protected $attributeRepo;

    public function __construct(
        IProductAttributeRepository $repository,
        IAttributeRepository $attributeRepo)
    {
        $this->repository = $repository;
        $this->attributeRepo = $attributeRepo;

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


    public function getById($id)
    {
        $products  = $this->repository->joinToFilter()->where('product_combination_id', $id);
        return $products;

    }
}
