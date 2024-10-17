<?php

namespace App\Services;

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

    public function updateImage($id, $request)
    {
        $productImage = $this->repository->getByid($id);
        $path = $productImage->path;
        $path = ltrim($path, '/storage/');

        $disk = 'public';
        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }

        $productImageUpload = $this->updatePathImage($request);

        $productImage->path= $productImageUpload;
        $productImage->save();
    }

    public function updatePathImage($request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            $permitted = ['png', 'jpg', 'svg', 'jpeg'];

            if (in_array(strtolower($fileExtension), $permitted)) {
                if ($fileSize < 10000000) { //10.000.000 byte. ,10.000.000 byte ÷ 1024 byte/KB ≈ 9765.62 KB
                    $fileNameEnd = time() . '_' . Str::random(10) . '_' . $fileName;
                    $path = $file->storeAs('public/images', $fileNameEnd);

                    $data = Storage::url($path);
                    return $data;
                } else {
                    throw new Exception('File size is too large');
                }
            } else {
                throw new Exception('File exception invalid');
            }
        }
    }

    public function delete($id)
    {
        $productImage = $this->repository->getByid($id);
        $path = $productImage->path;
        $path = ltrim($path, '/storage/');

        $disk = 'public';
        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }

        return $this->repository->delete($id);
    }

    public function createImage($request)
    {
        $productImage = $this->uploadImage($request);
        if($productImage)
        {
            return $this->repository->create($productImage);
        }
        else
        {
            throw new Exception('Error uploading image');
        }

    }

    public function uploadImage($request)
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
                if($fileSize < 10000000)
                {
                    $fileNameEnd = time().'_'.Str::random(10). '_'.$fileName;
                    $path = $file->storeAs('public/images',$fileNameEnd);

                    $data['product_combination_id'] = (int)$request->product_combination_id;
                    $data['file_name'] = $fileNameEnd;
                    $data['path'] = Storage:: url($path);
                    return $data;
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

    public function changeMain($id)
    {
        return $this->repository->changeMain($id);
    }


}
