<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ai_analysis_log;

class ImagesController extends Controller
{
    //画像パスを送信、保存したデータを表示する
    public function index(Request $request){
        $datas = Ai_analysis_log::all();
        return view('image.index', compact(
            'datas',
        ));
    }

    //POSTされた画像パスを受け取り、APIへリクエストし保存する
    public function create(Request $request){
        $this->validate($request, Ai_analysis_log::$rules);
        
        $request_timestamp = time(); 
        $image_path = 'http://example.com/image/' . $request->path; 
        $result = $this->return_path($image_path); //APIへのリクエスト
        $response_timestamp = time();
        
        //APIのレスポンス結果のjsonを配列に変換
        $result_json = $result->content();
        $result_array = json_decode( $result_json, true ); 

        if($result_array['success'] === true){
            //保存処理
            unset($result_array['_token']);
            $image_data = new Ai_analysis_log;
            $image_data->image_path = $request->path;
            $image_data->success = var_export($result_array['success'], true );//trueを文字列として保存するため変換
            $image_data->message = $result_array['message'];
            $image_data->class = $result_array['estimated_data']['class'];
            $image_data->confidence = $result_array['estimated_data']['confidence'];
            $image_data->request_timestamp = $request_timestamp;
            $image_data->response_timestamp = $response_timestamp;
            $image_data->save();

            session()->flash('flash_message', $result_array['message']);
        }else{
            session()->flash('flash_message', $result_array['message']);
        }

        return redirect('/image');
    }

    //モックアップAPI
    public function return_path($image_path){
        
        //成功パターン
        $result = [
            'success' => true,
            'message' => 'success',
            'estimated_data' => [
            'class' => 3,
            'confidence' => 0.8683,
            ]
        ];

        //失敗パターン
        // $result = [
        //     'success' => false,
        //     'message' => 'Error:E50012',
        //     'estimated_data' => [],
        // ];
        return response()->json($result);
        
    }

}
