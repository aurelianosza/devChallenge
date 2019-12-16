<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\Responser;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Http\Resources\Categories\CategoryResource;

class CategoryController extends Controller
{
    private $responser;
    private $model;

    public function __construct(Responser $responser, Category $category)
    {
        $this->responser    = $responser;
        $this->model        = $category;
    }

    public function index(Request $request):Response
    {

        $query      = $request->input('query') ? $request->input('query') : '';
        $page       = $request->input('page') ?  $request->input('page')  : 1;

        $products = $this->search($query, $page);

        $data['length'] = $products['length'];
        $data['categories'] = CategoryResource::collection($products['categories']);

        $this->responser->setData($data);

        return $this->responser->respond();
    }

    private function search(string $query, int $page): array
    {
        $sql = $this->model::where('name',  'LIKE', '%'.$query.'%')
                         ->orWhere('id',     'LIKE', '%'.$query.'%')
                         ->orderBy('name');

        $data = [];
        $data['length']     = $sql->count();
        $data['categories']   = $sql->skip(10*($page-1))->limit(10)->get();

        return $data;
                         
    }

    public function show(int $id):Response
    {
        $product = $this->model::findOrFail($id);

        $this->responser->setData(new CategoryResource($product));

        return $this->responser->respond();
    }

}
