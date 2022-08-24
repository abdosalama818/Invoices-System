<?php

namespace App\Http\Controllers\invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Traits\GetDataFromModels;
use Illuminate\Http\Request;

class ArcheiveInvoicesController extends Controller
{
 use GetDataFromModels ;
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.Archive_Invoices')->with(compact("invoices"));

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
    public function destroy(Request $request ,$id)
    {
    //return $request ;
        //return response($request->invoice_id);
        $id = $request->invoice_id ;
        $invoice = Invoice::withTrashed()->where('id',$id)->first();
        $invoice->forceDelete();

        return back();
    }

    public function restoreInvoice(Request $request)
    {
        $id = $request->invoice_id ;
        $invoice = Invoice::withTrashed()->where('id',$id)->first();
        $invoice->restore();
        return back();

    }
}
