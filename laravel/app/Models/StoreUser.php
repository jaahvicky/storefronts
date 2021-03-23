<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use DB;
use Auth;

class StoreUser extends BaseModel
{

    protected $table = 'store_user';

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'user_id'
    ];

//    public function __construct()
  //  {
    //    $user = Auth::user();
      //  $this->user_id = $user->id;
      //  $this->last_activity = $user->last_activity;
   // }

    //public function storeUser(){

      //  $stores = DB::table('stores')
        //        ->join('store_user AS s_u', 'stores.id', '=', 's_u.store_id')
          //      ->select('stores.id AS store_id', 'stores.name')
            //    ->where('s_u.store_id', '=', $this->user_id)
              //  ->get();

      // return $stores;
   // }
    public function user() {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }
	
}
