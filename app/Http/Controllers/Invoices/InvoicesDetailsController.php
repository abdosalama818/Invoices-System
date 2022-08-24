<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\invoice_attachments;
use App\Models\invoices_details;
use App\Traits\GetDataFromModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    use GetDataFromModels ;

    public  function getData($id){
        $details = $this->getDataBywhere(new invoices_details(),'id_Invoice',$id);
        $attachments = $this->getDataBywhere(new invoice_attachments(),'invoice_id',$id);
        $invoices = $this->getDataById(new Invoice(),$id);
        return view('invoices.details_invoice')->with(compact('invoices','details','attachments'));
    }

    public function viewFile($invoice_number){

        $attachments = $this->getDataBywhereuseFirst(new invoice_attachments(),'invoice_number',$invoice_number);
       // return $attachments->file_name;
        return response()->file('uploads' . '/'. $attachments->file_name);

    }


    public function downloadFile($invoice_number){

        $attachments = $this->getDataBywhereuseFirst(new invoice_attachments(),'invoice_number',$invoice_number);
        // return $attachments->file_name;
        return response()->download('uploads' . '/'. $attachments->file_name);

    }

    public function deletefile(Request $request){

       // return $request ;
          $attachment = $this->getDataById(new invoice_attachments(),$request->id_file);

       Storage::delete($attachment->file_name);
       $attachment->delete();
        return redirect()->back();

    }
    /*
     *
     * "invoice_number": "dfgdfgdfg",
"invoice_id": "5",
"uploadedFile": null,
"file_name": {}*/

    public  function update_attachment(Request $request){
   /* //    return $request ;
        $attachment = invoice_attachments::where('invoice_id',$request->invoice_id)->first();
        if ($attachment !==null){
            $imgpath = $attachment->file_name;
            if($request->file_name){
                Storage::delete($attachment->file_name);
            }
            $imgpath = Storage::putFile('image',$request->file_name);

            $attachment->updated([
                "file_name"=>$imgpath,


            ]);
            return back() ;
        }*/

        $imgpath = Storage::putFile('image',$request->file_name);

        invoice_attachments::create([
            "file_name"=>$imgpath,
            'invoice_number'=>$request->invoice_number,
            'invoice_id'=>$request->invoice_id,
            "Created_by"=> Auth::user()->name,



        ]);

        return back() ;


    }


    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
