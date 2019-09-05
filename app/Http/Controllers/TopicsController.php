<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function __construct()
    {
        // 对除了index show意外的方法使用auth中间件认证
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $topics = Topic::withOrder($request->order)->paginate(20);
        return view('topics.index', compact('topics'));
    }

    public function show(Request $request, Topic $topic, User $user)
    {
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->to($topic->link())->with('success', '创建话题成功。');
    }

    public function edit(Topic $topic)
    {
        $categories = Category::all();

        $this->authorize('update', $topic);
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->to($topic->link())->with('success', '创建话题成功。');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '删除成功.');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'success'   => false,
            'msg'       => '上传失败',
            'file_path' => '',
        ];
        // 校验是否有文件上传，并赋值给$file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = '上传成功';
                $data['success']   = true;
            }
        }

        return $data;
    }
}
