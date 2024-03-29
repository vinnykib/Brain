<?php
/**
 * Brain Train - Find the job you love!
 * Copyright (c) Brain Train Kenya. All Rights Reserved
 *
 * Website: http://www.braintrainke.com
 *
 * CODED WITH LOVE
 * ---------------
 * 	@author : Wanekeya Sam
 *  Title   : Full-stack Developer
 * 	created	: 02 September, 2017
 *	version : 1.0
 * 	website : https://www.wanekeyasam.co.ke
 *	Email   : contact@wanekeyasam.co.ke
 */

namespace App\Models;

use App\Models\Scopes\ActiveScope;

class PaymentMethod extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    // protected $primaryKey = 'id';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'display_name', 'description', 'has_ccbox', 'active', 'lft', 'rgt', 'depth'];
    
    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    // protected $hidden = [];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [];
    
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new ActiveScope());

        // DELETING - before delete() method call this
        static::deleting(function ($paymentMethod) {
            // $paymentMethod->payment()->delete();
        });
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function payment()
    {
        return $this->hasMany('App\Models\Payment', 'payment_method_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($builder)
    {
        return $builder->where('active', 1);
    }
    
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
