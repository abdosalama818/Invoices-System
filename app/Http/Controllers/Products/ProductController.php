<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Section;
use App\Repository\ProductRepository;
use App\Traits\GetDataFromModels;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   use GetDataFromModels;
   protected  $ProducRepository ;

   public function __construct(ProductRepository $ProducRepository)
   {
       $this->middleware('permission:الاعدادات|المنتجات|الاقسام', ['only' => ['index','store']]);
       $this->middleware('permission:الاعدادات|المنتجات|الاقسام', ['only' => ['create','store']]);
       $this->middleware('permission:الاعدادات|المنتجات|الاقسام', ['only' => ['edit','update']]);
       $this->middleware('permission:الاعدادات|المنتجات|الاقسام', ['only' => ['destroy']]);
       return $this->ProducRepository=$ProducRepository;
   }

    public function index()
    {
        $sections = $this->getDataAll(new Section());
        $products = $this->getDataAll(new Product());
      return  view('products.products')->with(compact('sections','products'));
    }


    public function create()
    {
        //
    }


    public function store(ProductRequest $request)
    {

        $this->ProducRepository->createProduct($request);
        session()->flash('Add',"تم اضافة المنتج بنجاح ");
        return redirect()->back();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(ProductRequest $request)
    {
       /* dd('ddddddd');*/
    $this->ProducRepository->updateProduct($request);
        session()->flash('edit',"تم تعديل المنتج بنجاح ");
        return redirect()->back();

    }


    public function destroy(Request $request)
    {
        $product = $this->getDataById(new Product(),$request->pro_id);
        $product->delete();

        return redirect()->back();

    }
}
