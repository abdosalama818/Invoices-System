<?php

namespace App\Traits;

use App\Models\Product;

trait ProductTrait
{

    use GetDataFromModels ;

    public function create($request){
       return Product::create([
            'product_name'=>$request->Product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id
        ]);
    }


 public  function update($request){
     $product = $this->getDataById(new Product(),$request->pro_id);

     return  $product->update([
         'product_name'=>$request->Product_name,
         'description'=>$request->description,
         'section_id'=>$request->section_id
     ]);
 }
}
