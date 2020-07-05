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
      // データベースに保存する
      $profile->fill($form);
      $profile->save();
      
      return redirect('admin/profile/create');
    }
    
public function edit()
{
//Profile Modelからデータを取得する
$profile = Profile::find($request->id);
if (empty($profile)){
abort(404);
}
return view('admin.news.edit');
}

public function update()
{
    //Validationをかける
    $this->validate($request, Profile::$rules);
    //Profile Modelからデータを取得する
    $profile = Profile::find($request->id);
    //送信されてきたフォームデータを格納する
    $profile_form = $request->all();
    unset($profile_form['_token']);
   //該当するデータを上書きして保存する
   $profile->fill($profile_form)->save();

return redirect('admin/profile/edit');	
}

}