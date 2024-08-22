<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','requested_time'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
