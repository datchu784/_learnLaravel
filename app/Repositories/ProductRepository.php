<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProduct(): Collection
    {
        return Product:: all();
    }

    public function getProductById($id): ?Product
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $productDetails): Product
    {

        return Product::create($productDetails);
    }

    public function updateProduct($id,array $newDetails) :bool
    {
        return Product:: where('id', $id)->update($newDetails);

    }

    public function deleteProduct(int $id): bool
    {

       $product = Product:: findOrFail($id);
       return $product->delete();
    }

}

?>
