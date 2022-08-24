<?php

namespace App\Repository;

use App\Models\Invoice;
use App\Traits\GetDataFromModels;
use App\Traits\InvoicesTrait;

class InvoicesRepository
{
use GetDataFromModels;
 use InvoicesTrait;
    public function create($request){
       return $this->create_invoicesTrait($request);
    }

    public function update_invoice($request,$incoices){



        return $this->update_invoicesTrait($request,$incoices);


    }

    public function update_attachment($request,$incoices){
        return $incoices ;
}

    public function update_status($request,$incoices){
        return $this->update_statusTrait($request,$incoices);
    }
}
