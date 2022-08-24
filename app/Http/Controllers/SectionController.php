<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use App\Traits\GetDataFromModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{

    use GetDataFromModels;


    public function __construct()
    {


    }


    public  function getPorducts($id){

        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);

    }
    public function index()
    {
        return view('sections.sections')->with('sections',Section::all());
    }


    public function create()
    {
        //
    }


    public function store(PostRequest $request)
    {


        Section::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'created_by' => Auth::user()->name,
            ]);
            \session()->flash('Add','تم الاضافة بنجاح');
            return back();

    }


    public function show(Section $section)
    {
        //
    }


    public function edit(Section $section)
    {

    }


    public function update(PostRequest $request)
    {

  $post = $this->getDataById(new Section(),$request->id);
  $post->update([
      'section_name' => $request->section_name,
      'description' => $request->description,
      'created_by' => Auth::user()->name,
  ]);
  \session()->flash('edit','تم التعديل بنجاح');
  return back();

    }


    public function destroy(Request $request)
    {
      $post = $this->getDataById(new Section(),$request->id);
      $post->delete();
        \session()->flash('delete','تم الحذف  بنجاح');

        return back();
    }
}
