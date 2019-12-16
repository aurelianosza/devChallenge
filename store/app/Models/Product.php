<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use Illuminate\Database\QueryException;

class Product extends Model
{
    use SoftDeletes;

    protected $table        = 'product';
    protected $primaryKey   = 'id';

    protected $fillable= [
        'name',
        'description',
        'price',
        'category_id',
        'image'
    ];

    public function category()
    {
        return $this->hasOne('\App\Models\Category', 'id', 'category_id');
    }

    public static function loadCVS(string $products): int 
    {

        $products = explode(PHP_EOL, $products);

        array_pop($products);

        $saves = 0;

        foreach($products as $productData)
        {
            try{

                $productData = explode(',',$productData);

                $aux = Product::where('name', $productData[0])->first();

                if($aux != null)
                    continue;

                $product = Product::create([
                    'name'          => $productData[0],
                    'price'         => $productData[2],
                    'category_id'   => Category::where('name', $productData[1])->first()->id
                ]);

                $saves++;
            
            } catch(QueryException $e) {
                continue;
            }
        }

        return $saves;
    }
}
