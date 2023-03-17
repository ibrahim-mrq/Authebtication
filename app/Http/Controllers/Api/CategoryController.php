<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{

    public function create(CategoryRequest $request)
    {
        if ($request->isCategoryExists()) {
            return response()->json($request->failure(422, ['Category Already Exists!']), 422);
        }
        $request['is_active'] = true;
        $request['is_delete'] = false;
        $category = Category::create($request->all());
        return response()->json($this->success('data', $category, 'Category created successful'), 200);
    }

    public function update(CategoryRequest $request, $id)
    {
        $where = [
            'is_delete' => false,
            'is_active' => true,
            'id' => $id,
        ];
        $category = Category::where($where)->first();
        if ($category) {
            $category['name'] = $request['name'];
            $category['description'] = $request['description'];
            $category->save();
            return response()->json($this->success('data', $category), 200);
        }
        return response()->json($this->failed(404, ['Category Not Found!']), 404);
    }

    public function delete($id)
    {
        $where = [
            'is_delete' => false,
            'id' => $id,
        ];
        $category = Category::where($where)->first();
        if ($category) {
            $category->is_delete = 1;
            $category->save();
            return response()->json($this->success('category', $category, 'Category deleted successful'), 200);
        }
        return response()->json($this->failed(404, ['Category Not Found!']), 404);
    }

    public function restore($id)
    {
        $where = ['id' => $id,];
        $category = Category::where($where)->first();
        if ($category == null) {
            return response()->json($this->failed(404, ['Category Not Found!']), 404);
        } else {
            if ($category->is_delete == 1) {
                $category->is_delete = 0;
                $category->save();
                return response()->json($this->success('category', $category, 'Category restore successful'), 200);
            } else {
                return response()->json($this->success('category', $category, 'Category already exists'), 200);
            }
        }

    }

    public function getAll()
    {
        $where = [
            'is_delete' => false,
            'is_active' => true,
        ];
        $categories = Category::where($where)->get();
        return response()->json($this->success('data', $categories), 200);
    }

    public function getSubCategories($id)
    {
        $where = [
            'is_delete' => false,
            'is_active' => true,
            // 'parent_id' => $id,
        ];
        $subCategories = SubCategory::where($where)->get();
        return response()->json($this->success('data', $subCategories), 200);
    }

    public function getById($id)
    {
        $where = [
            'is_delete' => false,
            'is_active' => true,
            'id' => $id,
        ];
        $category = Category::where($where)->first();
        if ($category) {
            return response()->json($this->success('data', $category), 200);
        }
        return response()->json($this->failed(404, ['Category Not Found!']), 404);
    }

}