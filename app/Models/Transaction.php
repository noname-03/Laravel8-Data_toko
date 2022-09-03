<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DetailTransaction;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user_from()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function user_to()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}
