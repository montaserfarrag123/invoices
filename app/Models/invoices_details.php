<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'Id_invoices',
        'invoices_number',
        'product',
        'section',
        'status',
        'value_status',
        'notes',
        'user',
        'Payment_date',
    ];
}
