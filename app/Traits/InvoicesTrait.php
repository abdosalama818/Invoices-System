<?php

namespace App\Traits;

use App\Models\Invoice;
use App\Models\invoice_attachments;
use App\Models\invoices_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait InvoicesTrait
{

    public function create_invoicesTrait($request){


        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        $invoice_id = Invoice::latest()->first()->id;
       $this->create_invoices_detailsTrait($request,$invoice_id);
       $this->create_attchmentTrait($request,$invoice_id);
    }


    public function update_invoicesTrait($request,$incoices){



       $attachments = invoice_attachments::where('invoice_number',$incoices->invoice_number)->get();
       foreach ($attachments as $attachment){
           $attachment->update([
               'invoice_number' => $request->invoice_number,
           ]);
       }



        $incoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);



    }


    public function create_invoices_detailsTrait($request,$invoice_id){

        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

    }

    public function store_image_indesc($request,$path){
        if ($request->pic){
            $imgpath = Storage::putFile($path,$request->pic);
                   return  $imgpath ;
        }
     return 'pleace add the image';
    }
    public  function create_attchmentTrait($request,$invoice_id){
        $imgpath = $this->store_image_indesc($request,'image');
        invoice_attachments::create([
                    "file_name"=>$imgpath,
                    'invoice_number'=>$request->invoice_number,
                    "invoice_id"=>$invoice_id,
                    "Created_by"=> Auth::user()->name,
        ]);
    }



    public function update_statusTrait($request,$incoices){
        if ($request->Status == 'مدفوعة'){
            $incoices->update([
                'Status' => $request->Status,
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_Date,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);
        }/*elseif ($request->Status =='مدفوعة جزئيا')*/else{
            $incoices->update([

                'Status' => $request->Status,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);

        }

    }


    /*    $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
    */
}
