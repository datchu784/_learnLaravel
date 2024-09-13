<?php
namespace App\Repositories;

use App\Models\ProductType;
use App\Repositories\Interfaces\ProductTypeRepositoryInterface;
use App\Services\ProductTypeService;
use Illuminate\Database\Eloquent\Collection;

class ProductTypeRepository implements ProductTypeRepositoryInterface
{
    public function getAllProductTypes(): Collection
    {
        return ProductType:: all();
    }

    public function getProductTypeById($id): ?ProductType
    {
        return ProductType:: find($id);
    }

    public function createProductType(array $productTypeDetails): ProductType
    {
        return ProductType:: create($productTypeDetails);
    }

    public function updateProductType($id, array $newDetails) :bool
    {
        return ProductType:: where('id', $id)->update($newDetails);
    }

    public function deleteProductType(int $id): bool
    {
        $productType = ProductType:: find($id);
        return $productType->delete();
    }
    public function existsProductType($id) : bool
    {
        $productType = ProductType::where('id', $id)->exists();
        return $productType;

    }

}

?>
