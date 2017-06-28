<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;


class NewsController extends Controller
{
    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        $data = $this->news->all();
        return view('news.index')->with(compact('data'));
    }

    public function all()
    {
        $data = $this->news->all();
        $response = [
            "status" => 200,
            "data"=>json_encode($data)
        ];
        return response($response);
    }

    public function add(Request $request)
    {
        $rules = [
            "title" => "required",
            "description" => "required",
            "media" => "required|mimes:jpeg,jpg,png"
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $verrors = [];
            $message = $validator->messages();
            foreach ($rules as $key => $value){
                $verrors[$key] = $message->first($key);
            }
            $response = [
                "status" => 200,
                "data" => $verrors,
                "message" => "errors"
            ];
            return response($response);
        }
        $data = [
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "media" => ($request->file('media')) ? time().'.'.$request->file('media')->getClientOriginalExtension() : '',
            "status" => $request->input('status')
        ];
        if($data['media'] != ''){
            if(!file_exists(public_path('admin/upload_imgs/thumbnails'))){
                mkdir(public_path('admin/upload_imgs/thumbnails'),'0755');
            }
            $image = $request->file('media');
            $thumb_img = Image::make($image->getRealPath());
            $thumb_img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('admin/upload_imgs/thumbnails').'/thumb_'.$data['media'],100);
            $request->file('media')->move(public_path('admin/upload_imgs'),$data['media']);
        }

        $this->news->create($data);

        return response('flash_success');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $data = $this->news->find($id);
        $data->delete();
        if(!empty($data['media'])){
            unlink(public_path('admin/upload_imgs'.'/'.$data['media']));
            $thumb_exist = public_path('admin/upload_imgs/thumbnails').'/thumb_'.$data['media'];
            if(file_exists($thumb_exist)){
                unlink(public_path('admin/upload_imgs/thumbnails').'/thumb_'.$data['media']);
            }
        }
        $response = [
            "status"=>200,
            "message"=>"success"
        ];
        return response($response);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = $this->news->find($id);
        $response = [
            "status" => 200,
            "data" => json_encode($data)
        ];
        return response($response);
    }

    public function saveUpdate(Request $request)
    {
        $data = [
            "title"=>$request->input('title'),
            "description"=>$request->input('description'),
            "media" => ($request->file('media')) ? time().'.'.$request->media->getClientOriginalExtension() : $request->input('oldImg'),
            "status"=>$request->input('status')
        ];
        if($request->file('media')){
            unlink(public_path('admin/upload_imgs').'/'.$request->input('oldImg'));
            $request->file('media')->move(public_path('admin/upload_imgs'),$data['media']);
        }
        $this->news->find($request->input('id'))->update($data);
        $response = [
            "status" => 200,
            "message" => "successfully edited"
        ];
        return response($response);
    }
}
