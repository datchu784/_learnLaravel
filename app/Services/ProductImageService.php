<?php

namespace App\Services;

use App\Http\Requests\ProductImageRequest;
use App\Models\Product;
use App\Repositories\Interfaces\IProductImageRepository;
use Illuminate\Support\Str;

use Exception;
use Illuminate\Support\Facades\Storage;

class ProductImageService extends BaseService
{
    public function __construct(IProductImageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete($id)
    {
        $productImage = $this->repository->getByid($id);
        $path = $productImage->path;
        $path = ltrim($path, '/storage/');

        $disk = 'public';
        if(Storage::disk($disk)->exists($path))
        {
            Storage::disk($disk)->delete($path);
        }

        return $this->repository->delete($id);


    }

    public function uploadImage(ProductImageRequest $request)
    {
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            $permitted = ['png','jpg','svg','jpeg'];

            if(in_array(strtolower($fileExtension), $permitted))
            {
                if($fileSize < 100000)
                {
                    $fileNameEnd = time().'_'.Str::random(10). '_'.$fileName;
                    $path = $file->storeAs('public/images',$fileNameEnd);

                    $data['product_id'] = $request->product_id;
                    $data['file_name'] = $fileNameEnd;
                    $data['path'] = Storage:: url($path);
                     $this->repository->create($data);
                    return $path;
                }
                else
                {
                    throw new Exception( 'File size is too large');
                }
            }
            else
            {
                throw new Exception('File exception invalid');
            }
        }

    }


}
