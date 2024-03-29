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
use Illuminate\Support\Facades\Storage;

class Resume extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resumes';
    
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
    public $timestamps = true;
    
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
    protected $fillable = ['country_code', 'user_id', 'filename', 'active'];
    
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
	protected $dates = ['created_at', 'updated_at'];
    
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
        static::deleting(function ($resume) {
            // Remove resume files (if exists)
            if (!empty($resume->filename)) {
                $filename = str_replace('uploads/', '', $resume->filename);
                Storage::delete($filename);
            }
        });
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function ad()
    {
        return $this->hasMany('App\Models\Ad');
    }
    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'user_id', 'id');
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
    public function getFilenameAttribute()
    {
        if (!isset($this->attributes) || !isset($this->attributes['filename'])) {
            return null;
        }

        $value = $this->attributes['filename'];

        // Fix path
        $value = str_replace('uploads/resumes/', '', $value);
        $value = str_replace('resumes/', '', $value);
        $value = 'resumes/' . $value;

        if (!Storage::exists($value)) {
            return null;
        }

        $value = 'uploads/' . $value;

        return $value;
    }
    
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setFilenameAttribute($value)
    {
        $attribute_name = 'filename';
        $disk = config('filesystems.default');

        if (!isset($this->country_code) || !isset($this->user_id)) {
            $this->attributes[$attribute_name] = null;
            return false;
        }

        // Path
        $destination_path = 'resumes/' . strtolower($this->country_code) . '/' . $this->user_id;

        // Upload
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
