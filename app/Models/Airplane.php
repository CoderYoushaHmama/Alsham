<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airplane extends Model
{
    use HasFactory;

    protected $primaryKey = 'airplane_id';
    protected $table = 'airplanes';
    protected $fillable = [
        'model',
        'manufacturer',
        'range',
    ];

    public function classes()
    {
        return $this->hasMany(ClassM::class, 'airplane_id', 'airplane_id');
    }
}