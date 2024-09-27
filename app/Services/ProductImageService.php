<?php

namespace App\Services;

use App\Http\Requests\ProductImageRequest;
use App\Repositories\Interfaces\IProductImageRepository;

class ProductImageService extends BaseService
{
    public function __construct(IProductImageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function uploadImage(ProductImageRequest $request)
    {
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
        }

    }
}
