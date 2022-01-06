<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attachment extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function invoice()
    {
        return $this->belongsTo(invoices::class);
    }
}
