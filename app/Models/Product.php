<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'information',
        'filename',
        'price',
        'is_selling',
    ];

    public function users(){
        return $this->belongsToMany(User::class,'likes')
        ->withPivot(['id']);
    }

    public function is_liked_by_auth_user(){
        $id = Auth::id();

        $likers = array();
        foreach($this->likes as $like) {
            array_push($likers, $like->user_id);
        }

        if(in_array($id, $likers)) {
            return true;
        } else {
            return false;
        }
    }

    public function scopeSearchKeyword($query, $keyword){
        if(!is_null($keyword))
        {
            $spaceConvert = mb_convert_kana($keyword,'s'); //全角スペースを半角に
            $keywords = preg_split('/[\s]+/',$spaceConvert,-1,PREG_SPLIT_NO_EMPTY); //空白で区切る

            //単語をループで回す
            foreach($keywords as $word){
                $query->where('products.name','like','%'.$word.'%');
            }

            return $query;
        }else{
            return;
        }
    }
}