<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoicedetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(invoices::class);
    }

    public function product()
    {
        return $this->belongsTo(products::class);
    }
}
