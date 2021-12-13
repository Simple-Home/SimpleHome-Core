<?php

namespace App\Models;

use App\Models\Properties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Records extends Model
{
    public $incrementing = true;
    protected $table = 'sh_records';
    protected $primaryKey = 'id';
    public $fillable = [
        "value",
        "done",
    ];

    use HasFactory;

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            Cache::forget('api.enpoint.properties');
        });

        self::updated(function($model){
            Cache::forget('api.enpoint.properties');
        });

        self::deleted(function($model){
            Cache::forget('api.enpoint.properties');
        });
    }
    
    public function setAsDone()
    {
        $this->done = 1;
        $this->save();
    }

    public function property()
    {
        return $this->belongsTo(Properties::class);
    }

    public function properti()
    {
        return $this->belongsTo(Properties::class);
    }

    public function getValueAttribute($value) {
       $detectedType = gettype ($value);
       $rawValue = $value;

       try {
           if (settype($value,  $detectedType)) {
               return $value;
           }
       } catch (\Throwable $th) {
           //dump($this->type);
       }
       return $rawValue;
    }
}
