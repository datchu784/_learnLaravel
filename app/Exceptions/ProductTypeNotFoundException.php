<?php

namespace App\Exceptions;

use Exception;

class ProductTypeNotFoundException extends Exception
{
    public function __construct($id)
    {
        parent::__construct("Product type with Id {$id} not found");
    }
}
