<?php

namespace App\Services;

use App\Repositories\Interfaces\IAttributeRepository;
use App\Repositories\Interfaces\IProductAttributeRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IProductTypeRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Exception;

class ProductService extends BaseService
{
    protected  $productTypeRepository;
    protected  $productAttributeRepo;
    protected $attributeRepo;

    public function __construct(
        IProductRepository $repository,
        IProductTypeRepository $productTypeRepository,
        IProductAttributeRepository $productAttributeRepo,
        IAttributeRepository $attributeRepo)
    {
        $this->repository = $repository;
        $this->productTypeRepository = $productTypeRepository;
        $this->productAttributeRepo = $productAttributeRepo;
        $this->attributeRepo = $attributeRepo;

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

    public function filter($data,$id)
    {
        $filteredProducts  = $this->getById($id);

        $attributes = $this->attributeRepo->getAll();

        // vì ở trên đã được sữa lại trả về collection nên không cần câu lệnh dưới nữa
        //$filteredProducts = collect($query);

        foreach ($attributes as $attribute) {
            $attributeName = strtolower($attribute->name);
            if (isset($data[$attributeName])) {
                $filteredProducts = $filteredProducts->where("attributes.{$attribute->name}", $data[$attributeName]);
            }
        }

        return $filteredProducts;
    }

    public function getById($id)
    {
         return $this->productAttributeRepo->joinToFilter()->where("product_id", $id);
    }



    public function uploadImage($request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            $permitted = ['png', 'jpg', 'svg', 'jpeg'];

            if (in_array(strtolower($fileExtension), $permitted)) {
                if ($fileSize < 10000000) {
                    $fileNameEnd = time() . '_' . Str::random(10) . '_' . $fileName;
                    $path = $file->storeAs('public/images', $fileNameEnd);

                    $url = Storage::url($path);
                    return $url;
                } else {
                    throw new Exception('File size is too large');
                }
            } else {
                throw new Exception('File extension is not valid');;
            }
        }
    }

    public function updateImage($id, $request)
    {
        $product = $this->repository->getByid($id);
        $url= $product->url;
        $url = ltrim($url, '/storage/');

        $disk = 'public';
        if (Storage::disk($disk)->exists($url)) {
            Storage::disk($disk)->delete($url);
        }

        $productImageUpload = $this->uploadImage($request);

        $product->url = $productImageUpload;
        $product->save();
        return $product;
    }



}



