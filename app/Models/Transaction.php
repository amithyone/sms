<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $casts = [
        'detail' => 'array'
    ];

    protected $hidden = ['detail']; 
    
    protected $fillable = [
        'user_id',
        'amount',
        'charge',
        'final_amount',
        'ref_id',
        'method',
        'type',
        'status',
        'detail'
    ];
    
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
