<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transection extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['type', 'TxnId', 'amount', 'status'];

    /**
     * Get all of the owning transectionable models.
     */
    public function transectionable()
    {
        return $this->morphTo();
    }

    protected $casts = [
    	'amount' => 'float',
  	];
}
