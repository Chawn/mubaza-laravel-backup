<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Product;
use App\Category;
use Request;

class ProductController extends Controller {

    public function postOrderedProduct() {
        $inputs = Request::all();
        $products = Product::find($inputs['id']);

        return response()->json($products);
    }

    public function postGetProductByCategory()
    {
        $inputs = Request::all();
        if ($inputs['category_id'] == 'all') {
            $products = \App\Product::all();
        } else {
            $products = \App\Product::where('category_id', $inputs['category_id']);
        }
        return response()->json($products);
    }
    public function postGetRowProduct() {
        $inputs = Request::all();
        $id = $inputs['id'] ;
        $product = Product::find($id);

        $cover = $product->getCover();
        $color = $cover->color ;
        $image_front = $cover->image_front ;
        $image_back = $cover->image_back ;

        $colorhas = explode(",",$product->getColorHas($id)) ;
        $dropdown_color = "";
        $count = count($colorhas);
        
        foreach ($product->image as $product_image) {
            if ($product_image->color != $color) {
                    $dropdown_color = $dropdown_color . '<div class="new-color btn-color btn-lg" '
                    . 'data-image-front="' . $product_image->image_front . '" '
                    . 'data-color="' . $product_image->color . '" '
                    . 'data-image-id="' . $product_image->id . '" '
                    . 'style="background-color:' . $product_image->color . ';"></div>';
            }
        }
        
    

        $dropdown_color = '<div id="dropdown-color" class="dropdown-color dropdown-menu" role="menu">'
                            .$dropdown_color.'</div>';
        $html = '<div class="row-product" '
                . 'id="product-' . $id . '" '
                . 'data-product-id="' . $id  . '" '
                . 'data-name="' . $product->name  . '" '
                . 'data-color="' . $color  . '" '
                . 'data-image-id="' . $cover->id .'" '
                . 'data-unit-price="' . $product->price  . '" '
                . 'data-image-url="' . $image_front  . '" '
                . '"><div class="column col-image">'
                . '<img class="product_image" src="' . $image_front
                . '" style="width:40px"></div><div class="column col-color">'
                . '<div class="btn-group"><button data-color="' . $color
                . '" style="background-color:' . $color . ';" '
                . 'class="selected-color btn-color btn-lg dropdown-toggle" '
                . 'data-image-id="' . $cover->id . '" '
                . 'data-image-front="' . $cover->image_front . '" '
                . 'data-toggle="dropdown" aria-expanded="false"></button>'
                . $dropdown_color . '</div></div><div class="column col-name">'
                . $product->name . '</div><div class="column col-price">'
                . '<input type="number" class="form-control input-price" name="sell_price" placeholder="" value="" max="10000"></div>'
                . '<div class="column col-profit"><span>฿<span class="profit">0</span>/ตัว</span></div>'
                . '<div class="column col-trash">'
                . '<a class="trash"><i class="fa fa-times"></i></a></div></div>';
        return response()->json([
            'result'          => 'success',
            'color'           => $product->getCover()->color,
            'colorhas'        => $colorhas,
            'price'           => $product->price,
            'id'              => $product->id,
            'name'            => $product->name,
            'image_front'     => $product->getCover()->image_front,
            'image_back'      => $product->getCover()->image_back ,
            'html'                  => $html
        ]);

        //return response()->json($products);
    }
    public function postProductCategory() {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function postAllProducts() {
        $data = null;

        if(\Request::has('used_color'))
        {
            $used_color = \Request::get('used_color');
            $data = Product::with(['colors' => function($q) use($used_color) {
                $q->whereNotIn('id', $used_color);
            }]);
        }
        else {
            $data = Product::with(['colors']);
        }

        $data = $data->get();
        return response()->json([
            'success' => true,
            'products' => $data
        ]);
    }

    public function getFile ($id, $file_name)
    {
        $file_name_array = explode('.', $file_name);
        $ext = last($file_name_array);

        $file = \Storage::disk('local')->get('images/products/' . str_pad($id, 6, 0, STR_PAD_LEFT) . '/' . $file_name);

        $mime_type = '';

        if ( $ext == 'png' ) {
            $mime_type = 'image/png';
        } elseif ( $ext == 'jpg' ) {
            $mime_type = 'image/jpeg';
        }
        return response()->make($file, 200, array( 'content-type' => $mime_type ));
    }
}
