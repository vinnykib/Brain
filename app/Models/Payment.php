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


class Payment extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';
    
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
    // public $timestamps = false;
    
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
    protected $fillable = ['ad_id', 'package_id', 'payment_method_id'];
    
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
    public function getAdTitleHtml()
    {
        if ($this->ad) {
            return '<a href="/' . config('app.locale') . '/' . slugify($this->ad->title) . '/' . $this->ad_id . '.html" target="_blank">' . $this->ad->title . '</a>';
        } else {
            return $this->ad_id;
        }
    }
    
    public function getPackNameHtml()
    {
        $package = Package::transById($this->package_id);
        if (!empty($package)) {
            return $package->name . ' (' . $package->price . ' ' . $package->currency_code . ')';
        } else {
            return $this->package_id;
        }
    }

    public function getPaymentMethodNameHtml()
    {
        $paymentMethod = PaymentMethod::find($this->payment_method_id);
        if (!empty($paymentMethod)) {
            return $paymentMethod->display_name;
        } else {
            return '--';
        }
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function ad()
    {
        return $this->belongsTo('App\Models\Ad', 'ad_id');
    }
    
    public function package()
    {
        return $this->belongsTo('App\Models\Package', 'package_id');
    }
    
    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method_id');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    
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
