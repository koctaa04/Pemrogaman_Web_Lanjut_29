<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
    ];

    //Relasi dengan tabel level
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    // Relasi dengan tabel stok
    public function stok()
    {
        return $this->hasMany(StokModel::class, 'user_id', 'user_id');
    }
}
