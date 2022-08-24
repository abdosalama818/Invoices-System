<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class ReportInvoicesController extends Controller
{
  public function index(){
    return view('reports.invoices_report');
  }
public function Search_invoices(Request $request){

    $rdio = $request->rdio;


    // في حالة البحث بنوع الفاتورة

    if ($rdio == 1) {


        // في حالة عدم تحديد تاريخ
        if ($request->type && $request->start_at =='' && $request->end_at =='') {

            $invoices = Invoice::select('*')->where('Status','=',$request->type)->get();
            $type = $request->type;
            return view('reports.invoices_report',compact('type'))->withDetails($invoices);
        }

        // في حالة تحديد تاريخ استحقاق
        else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $type = $request->type;

            $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
            return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);

        }



    }

//====================================================================

// في البحث برقم الفاتورة
    else {

        $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
        return view('reports.invoices_report')->withDetails($invoices);

    }

}


public function customers_report(){
    $sections=Section::all();
      return view('reports.customers_report')->with(compact('sections'));
}

public function Search_customers(Request $request){

// في حالة البحث بدون التاريخ

    if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {


        $invoices = Invoice::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections = Section::all();
        return view('reports.customers_report',compact('sections'))->withDetails($invoices);


    }


    // في حالة البحث بتاريخ

    else {

        $start_at = date($request->start_at);
        $end_at = date($request->end_at);

        $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections = Section::all();
        return view('reports.customers_report',compact('sections'))->withDetails($invoices);


    }
}
}
