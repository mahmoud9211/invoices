<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];

    public function section ()
    {
        return $this->hasOne(sections::class,'id','section_id');
    }

    public function products()
    {
        return $this->hasOne(products::class,'id','product');
    }

    public function attachment()
    {
        return $this->hasMany(attachment::class);
    }

    public function invoice_det()
    {
        return $this->hasMany(invoicedetails::class);
    }
}
