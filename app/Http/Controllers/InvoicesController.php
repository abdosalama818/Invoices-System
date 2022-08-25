<?php

namespace App\Http\Controllers;

use App\Events\MyEventNotification;
use App\Events\SendEmailEvent;
use App\Models\Invoice;
use App\Models\invoice_attachments;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Notifications\InvoiceNotification;
use App\Repository\InvoicesRepository;
use App\Traits\GetDataFromModels;
use App\Traits\InvoicesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    use GetDataFromModels ;
    use InvoicesTrait ;

    public  $invoice ;
 public function __construct(InvoicesRepository $InvoicesRepository)
 {
     $this->middleware('permission:الفواتير|اضافة فاتورة', ['only' => ['index','store']]);
     $this->middleware('permission:اضافة فاتورة|الفواتير', ['only' => ['create','store']]);
     $this->middleware('permission:الفواتير|تعديل الفاتورة', ['only' => ['edit','update']]);
     $this->middleware('permission:الفواتير', ['only' => ['destroy']]);
     return $this->invoice = $InvoicesRepository;
 }

    public function index()
    {
        $invoices = $this->getDataAll(new Invoice());
       return view('invoices.invoices')->with(compact('invoices'));
    }


    public function create()
    {
        $sections = $this->getDataAll(new Section());
        $products = $this->getDataAll(new Product());

        return view('invoices.add_invoice')->with(compact('sections',"products"));
    }


    public function store(Request $request)
    {
       // dd('ggg');
        $this->invoice->create($request);
        $user = User::where('id',Auth::id())->first();
       // dd( $user);
      /*  event(new SendEmailEvent($user));*/
       // $users = User::where('id','<>',Auth::id())->get();
        $users = User::get();
        $invoice = Invoice::latest()->first();
       // dd($invoice);
        Notification::send($users, new InvoiceNotification($invoice));
        event(new MyEventNotification());
        return redirect('invoices');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $sections = $this->getDataAll(new Section());
        $invoices = $this->getDataById(new Invoice(),$id);
       return view('invoices.edit_invoice')->with(compact('sections','invoices'));
    }


    public function update(Request $request)
    {

        $incoices= $this->getDataById(new Invoice(),$request->invoice_id);

         $this->invoice->update_invoice($request,$incoices);

         session()->flash('edit','تم التعديل بنجاح');
         return back();
    }


    public function destroy(Request $request, $id)
    {
   //return $request;
        $invoice = $this->getDataById(new Invoice(),$request->invoice_id);
        $detailsa = $this->getDataBywhere(new invoice_attachments(),'invoice_id',$request->invoice_id);
        foreach ( $detailsa as $x){
            Storage::disk('uploads')->delete( $x->file_name);
        }


   $invoice->forceDelete();
   session()->flash('delete','تم  الحذف  بنجاح');
   return back();

    }

    public function archieve(Request $request,$id){
        $invoice = $this->getDataById(new Invoice(),$request->invoice_id);
        $invoice->delete();
        session()->flash('archieve','تم  ارشفة الفاتوره  بنجاح');

        return back();

    }

    public function edit_status($id){
        $sections = $this->getDataAll(new Section());
        $products = $this->getDataAll(new Product());
        $invoices = $this->getDataById(new Invoice(),$id);

        return view('invoices.status_update')->with(compact('sections',"products","invoices"));

    }

    public function update_status(Request $request , $id){

        $invoices = $this->getDataById(new Invoice(),$id);
        $this->invoice->update_status($request,$invoices);
        session()->flash('Status_Update','تم  تحديث الفاتوره  بنجاح');

        return redirect('invoices');

    }

    public function invoicespaid(){
        $invoices = $this->getDataBywhere(new Invoice(),'Value_Status',1);
        return view('invoices.invoices_paid')->with(compact("invoices"));

    }
    public function uninvoicespaid(){
        $invoices = $this->getDataBywhere(new Invoice(),'Value_Status',2);
        return view('invoices.invoices_unpaid')->with(compact("invoices"));

    }
    public function partilainvoices(){
        $invoices = $this->getDataBywhere(new Invoice(),'Value_Status',3);
        return view('invoices.invoices_Partial')->with(compact("invoices"));

    }

    public function Print_invoice($id){
     $invoices = Invoice::findOrFail($id);
     return view('invoices.Print_invoice')->with(compact('invoices'));
    }


}
