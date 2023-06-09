<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'customer_id',
        'status',
        'amout',
        'billed_date',
        'paid_date'
    ]; 

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}