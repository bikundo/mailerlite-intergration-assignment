<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public function has($key)
    {
        return (boolean) self::where('key', $key)->count();
    }

    public function value($key)
    {

        return self::where('key', $key)->pluck('value')->first();
    }

    public function set($key, $value)
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->$value = $value;
        $setting->save();

        return true;
    }
}
