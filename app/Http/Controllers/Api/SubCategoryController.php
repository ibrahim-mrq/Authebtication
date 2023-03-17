<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use App\Http\Requests\SubCategoryRequest;
use App\Traits\BaseTrait;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class SubCategoryController extends Controller
{
    use BaseTrait;

    public function create(SubCategoryRequest $request)
    {
        $subCategory = SubCategory::where('name', $request->name)->first();
        if ($this->isExists($subCategory)) {
            return $this->returnError(422, ['Sub Category Already Exists!']);
        }
        $category = Category::where('id', $request->parent_id)->first();
        if (!$this->isExists($category)) {
            return $this->returnError(422, ['Category Parent Not FOund!']);
        }
        $request['is_active'] = true;
        $request['is_delete'] = false;
        $request['parent_name'] = $category->name;
        $subCategory = SubCategory::create($request->all());
        return $this->returnSuccess($subCategory);
    }

    public function getAll(Request $request)
    {
        $user_id = $request->header('user');
        $where = [
            'is_delete' => false,
            'is_active' => true,
        ];
        $subCategories = SubCategory::where($where)
            // ->paginate();
            // ->select('name_' . app()->getLocale() . ' as name ')
            ->get();
        return $this->returnSuccess($subCategories);
    }

    public function getById($id)
    {
        $subCategory = SubCategory::where($this->whereId($id))->first();
        if ($subCategory) {
            return $this->returnSuccess($subCategory);
        }
        return $this->returnError(404, ['Sub Category Not Found!']);
    }

    public function uploadImage(Request $request)
    {
        $file = $request->file('photo');
        $file->move(public_path("Images/"), $file->getClientOriginalName());
        $url = url('Images/' . $file->getClientOriginalName());
        return $this->returnSuccess($url);
    }

}