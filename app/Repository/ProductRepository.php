<?php

namespace App\Repository;

use App\Traits\ProductTrait;

class ProductRepository
{
 use ProductTrait ;

 public function createProduct($request){
   return  $this->create($request);
 }

public function updateProduct($request){
    return $this->update($request);
 }
}
