<?php
namespace App\Repositories;

use App\Models\ProductType;
use App\Repositories\Interfaces\ProductTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductTypeRepository implements ProductTypeRepositoryInterface
{
    public function getAllProductTypes(): Collection
    {
        return ProductType:: all();
    }

    public function getProductTypeById($id): ?ProductType
    {
        return ProductType:: findOrFail($id);
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
        return ProductType:: destroy($id);
    }

}

?>
