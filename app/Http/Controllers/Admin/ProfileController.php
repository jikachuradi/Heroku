<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

class ProfileController extends Controller
{
    //Actionを追加
public function add()
{
    return view('admin.profile.create');
}

public function create(Request $request)
{
     $this->validate($request, Profile::$rules);
     $profile = new Profile;
     $form = $request->all();
     

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);
      
      // データベースに保存する
      $profile->fill($form);
      $profile->save();
        
        
        return redirect('admin/profile/create');
    }
}
