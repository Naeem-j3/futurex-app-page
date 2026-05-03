<?php
namespace FutureX\AppPage\Models;

use Illuminate\Database\Eloquent\Model;
class AppPageImage extends Model
{
    protected $fillable = [
        'app_page_id',
        'image',
        'order'
    ];
}
