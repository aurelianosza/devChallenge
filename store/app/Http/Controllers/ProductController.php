<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\Responser;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Models\Csv;
use App\Http\Requests\Products\ProductPostRequest;
use App\Http\Requests\Products\ProductPutRequest;
use App\Http\Requests\Products\ProductLoadCVSRequest;
use App\Http\Requests\Products\SetImageRequest;
use App\Http\Resources\Products\ProductResource;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    private $responser;
    private $model;

    public function __construct(Responser $responser, Product $product)
    {
        $this->responser    = $responser;
        $this->model        = $product;
    }

    public function index(Request $request):Response
    {

        $query      = $request->input('query') ? $request->input('query') : '';
        $page       = $request->input('page') ? $request->input('page') : 1;
        $category   = $request->input('category', null);

        $products = $this->search($query, $page, $category);

        $data['length'] = $products['length'];
        $data['products'] = ProductResource::collection($products['products']);

        $this->responser->setData($data);

        return $this->responser->respond();
    }

    private function search(string $query, int $page, ?int  $category): array
    {
        $sql = $this->model::where('name',  'LIKE', '%'.$query.'%')
                         ->orderBy('name');

        if($category)
            $sql = $sql->where('category_id', $category);
            
        $data = [];
        $data['length']     = $sql->count();
        $data['products']   = $sql->skip(10*($page-1))->limit(10)->get();

        return $data;
                         
    }

    public function show(int $id):Response
    {
        $product = $this->model::findOrFail($id);

        $data['product'] = new ProductResource($product);

        $this->responser->setData($data);

        return $this->responser->respond();
    }

    public function random(): Response 
    {
        $products = $this->model->inRandomOrder()->limit(10)->get();

        $data['products'] = ProductResource::collection($products);

        $this->responser->setData($data);
        
        return $this->responser->respond();

    }

    public function create(ProductPostRequest $request): Response
    {
        $product = $this->model::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $request->price,
            'category_id'   => $request->category_id
        ]);

        $data['product'] = new ProductResource($product);

        $this->responser->setData($data);
        $this->responser->setStatus(Responser::CREATED);

        return $this->responser->respond();
    }

    public function setImage(SetImageRequest $request,int $id):Response 
    {
        $product = $this->model::findOrFail($id);

        $image = $request->file("image")->store('products');

        Storage::delete($product->image);

        $product->fill([
            'image' => $image
        ]);

        $product->save();
    
        $data['product'] = new ProductResource($product);
        $this->responser->setData($data);

        return $this->responser->respond();
    }

    public function loadCVS(ProductLoadCVSRequest $request) : Response 
    {

        $file = $request->file('file')->storeAs('csv', date('Y-m-d H:i:s').'.csv', 'local');

        Csv::create([
            'file'      => $file,
            'user_id'   => $request->auth->id
        ]);

        return $this->responser->respond();
    }

    public function update(ProductPutRequest $request, int $id): Response
    {
        $product = $this->model::findOrFail($id);

        $product->fill([
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $request->price,
            'category_id'   => $request->category_id
        ]);
        
        $product->save();
        
        return $this->responser->respond();
    }

    public function delete(int $id): Response 
    {
        $product = $this->model::findOrFail($id);

        Storage::delete($product->image);

        $product->delete();

        return $this->responser->respond();
    }

}
