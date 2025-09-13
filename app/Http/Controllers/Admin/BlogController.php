<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    const IMAGE_PATH = 'uploads/blog/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $blog = new Blog();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['user'];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['title'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }


            $blog = $blog->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($blog);
        }
        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $data = [
                'user_id' => auth()->user()->id,
                'slug' =>Str::slug($request->title),
                'title' => $request->title,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'status' => $request->status ? $request->status : 1,
            ];
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = time() . '_' . rand(111, 99999) . '.' . $extension;
                    $image_tmp->move(self::IMAGE_PATH, $fileName);
                    $data['image'] = $fileName;
                }
            }
            Blog::create($data);
            return sendSuccess('Successfully created !');
        } catch (\Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $data['blog'] = $blog;
        return view('admin.blog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        try {
           $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'status' => $request->status ? $request->status : 1,
            ];
            if ($request->hasFile('image')) {
                $logo = self::IMAGE_PATH . $blog->image;
                if (file_exists($logo)) {
                    unlinkFile($logo);
                }
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = time() . '_' . rand(111, 99999) . '.' . $extension;
                    $image_tmp->move(self::IMAGE_PATH, $fileName);
                    $data['image'] = $fileName;
                }
            }
            $blog->update($data);
            return sendSuccess('Successfully Update!');
        } catch (\Exception $e) {
            DB::rollBack();
            return sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            $logo = self::IMAGE_PATH . $blog->image;
            if (file_exists($logo)) {
                unlinkFile($logo);
            }
            $blog->delete();
            return sendMessage('Successfully Delete');
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
    }
}
