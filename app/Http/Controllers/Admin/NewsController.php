<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;
//Historyモデルの使用を宣言
use App\History;
//Carbon = 日付操作ライブラリ
use Carbon\Carbon;
//Storageファサードの追加
use Storage;

class NewsController extends Controller
{
      // 以下を追記
  public function add()
  {
      return view('admin.news.create');
  }

public function create(Request $request)
{
    //Varidationを行う
    $this->validate($request, News::$rules);
    
    $news = new News;
    $form = $request->all();
    
    //フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
    if (isset($form['image'])){
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);
    } else {
        $news->image_path = null;
    }
    
    //フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    //フォームから送信されてきたimageを削除する
    unset($form['image']);
    
    // データベースに保存する
    $news->fill($form);
    $news->save();
    
    // admin/news/createにリダイレクトする
    return redirect('admin/news/create');
}

public function index(Request $request)
{
    $cond_title = $request -> cond_title;
    if ($cond_title != ''){
        //検索されたら検索結果を取得する
        $posts = News::where('title', $cond_title)->get();
        } else {
            //それ以外はすべてのニュースを取得する
            $posts = News::all();
        }
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
}

//以下を追記

public function edit(Request $request)
{
    //News Modelからデータを取得する
    $news = News::find($request->id);
    if (empty($news)){
        abort(404);
    }
    return view('admin.news.edit',['news_form' => $news]);
}

public function update(Request $request)
{
    //Validationをかける
    $this->validate($request, News::$rules);
    //News Modelからデータを取得する
    $news = News::find($request->id);
    //送信されてきたフォームデータを格納する
    $news_form = $request->all();
    if (isset($news_form['image'])){
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);
        unset($news_form['image']);
    } elseif (isset($request->remove)){
        $news->image_path = null;
        unset($news_form['remove']);
    }
    unset($news_form['_token']);
    //該当するデータを上書きして保存する
    $news->fill($news_form)->save();
    
    //History Modelにも編集履歴を追加するよう実装
    $history = new History;
    $history->news_id = $news->id;
    /* Carbonで取得した現在時刻を、
    Historyモデルの edited_at として記録 */
    $history->edited_at = Carbon::now();
    $history->save();
    
    return redirect('admin/news/');
}

public function delete(Request $request)
{
    //該当するNews Modelを取得
    $news = News::find($request->id);
    //削除する
    $news->delete();
    return redirect('admin/news/');
}

}