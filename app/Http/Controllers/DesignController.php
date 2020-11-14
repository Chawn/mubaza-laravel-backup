<?php namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductColor;
use App\Category;
use Image;
use Request;
use Session;
use Storage;

class DesignController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $products = Product::all();
        $categories = Category::all();

        return view('design.index', [
            'title' => 'ออกแบบ',
            'products' => $products,
            'categories' => $categories,
            'type' => 'design',
            'step' => 1
        ]);
    }

    public function getProductList($id)
    {
        $html = "";
        if ($id == 'all') {
            $products = Product::all();
            foreach ($products as $product) {
                $color = "";
                foreach ($product->colors as $product_color) {
                    $color = $color . '<button class="button-color select-product-color" ' .
                        'data-color="' . $product_color->color . '" ' .
                        'data-color-name="' . $product_color->color_name . '" ' .
                        'data-color-id="' . $product_color->id . '" ' .
                        'data-img-front="' . action('ProductController@getFile', $product_color->image_front) . '" ' .
                        'data-img-back="' . action('ProductController@getFile', $product_color->image_back) . '" ' .
                        'data-sizehas="' . $product_color->getAvailableSizeString() . '" ' .
                        'style="background-color:' . $product_color->color . ';"></button>';
                }

                $html = $html . '<li>
                                    <a href="javascript:void(0)" id="product-' . $product->id . '" class="btn-select-product" data-id="' . $product->id . '">
                                        
                                        <div class="picture colum">
                                            <img src="' . action('ProductController@getFile', $product->getCover()->image_front) . '">
                                        </div>
                                        <div class="detail colum">
                                        <b class="product-name">' . $product->name . '</b><br>
                                             <b class="product-detail">' . $product->detail . '</b>
                                        </div>
                                    </a>
                                    <div class="color-box hide">
                                    <b>สี</b>
                                        ' . $color . '
                                    </div> 
                                </li>';
            }
        } else {
            $category = Category::find($id);
            foreach ($category->products as $product) {
                $color = "";
                foreach ($product->colors as $color) {
                    $color = $color . "<button class='button-color select-product-color'
                                        data-color='" . $color->color . "'
                                        data-color-name='" . $color->color_name . "'
                                        data-color-id='" . $color->id . "'
                                        data-img-front='" . action('ProductController@getFile', $color->image_front) . "'
                                        data-img-back='" . action('ProductController@getFile', $color->image_back) . "'
                                        data-sizehas='" . $color->getAvailableSizeString() . "'
                                        style='background-color:" . $color->color . ";'>
                                    </button>";
                }
                $html = $html . '<li>
                                    <a href="javascript:void(0)" id="product-' . $product->id . '" class="btn-select-product" data-id="' . $product->id . '">
                                        
                                        <div class="picture colum">
                                            <img src="' . action('ProductControll@getFile', $product->getCover()->image_front) . '">
                                        </div>
                                        <div class="detail colum">
                                        <b class="product-name">' . $product->name . '</b><br>
                                             <b class="product-detail">' . $product->detail . '</b>
                                        </div>
                                    </a>
                                    <div class="color-box hide">
                                    <b>สี</b>
                                        ' . $color . '
                                    </div> 
                                </li>';
            }
        }

        return response()->json([ 'html' => $html ]);

    }

    public function getProductDetail($id)
    {
        if ($id === '0') {
            $product = Product::orderBy('id')->first();
        } else {
            $product = Product::find($id);
        }
        return response()->json([
            'result' => 'success',
            'color' => $product->getCover()->color,
            'category_id' => $product->category_id,
            'color_name' => $product->getCover()->color_name,
            'product_color_id' => $product->getCover()->id,
            'one_side_price' => $product->one_side_price,
            'two_side_price' => $product->two_side_price,
            'size' => 'false',
            'id' => $product->id,
            'name' => $product->name,
            'detail' => $product->detail,
            'left' => $product->outline->outline_left,
            'top' => $product->outline->outline_top,
            'width' => $product->outline->outline_width,
            'height' => $product->outline->outline_height,
            'image_front' => action('ProductController@getFile', $product->getCover()->image_front),
            'image_back' => action('ProductController@getFile', $product->getCover()->image_back)
        ]);

    }

    public function getCurrentSelectSize($id, $image_id)
    {

        $image = ProductColor::find($image_id);
        $color = $image->color;
        $color_name = $image->color_name;

        $products = Product::all();
        $product_current = Product::find($id);

        $option_product = "<option value=''>เลือกสินค้า</option>";
        /* Set Option Current */
        $data_colors = $product_current->getColorHas($product_current->id);
        $data_imagehas = $product_current->getImageHas($product_current->id);
        $option_product .= "<option value='" . $product_current->id .
            "' data-name='" . $product_current->name .
            "' data-sizehas='" . $product_current->available_size .
            "' data-colorhas='" . $data_colors .
            "' data-imagehas='" . $data_imagehas .
            "' data-price='" . $product_current->price . "' selected>" .
            $product_current->name . "</option>";
        /* End */

        /* Set Product Option Other */

        foreach ($products as $product) {
            if ($product->id != $product_current->id) {
                $data_colors = $product->getColorHas($product->id);
                $data_imagehas = $product->getImageHas($product->id);
                $option_product = $option_product . "<option value='" . $product->id .
                    "' data-name='" . $product->name .
                    "' data-sizehas='" . $product->available_size .
                    "' data-colorhas='" . $data_colors .
                    "' data-imagehas='" . $data_imagehas .
                    "' data-price='" . $product->price . "'>
                                    " . $product->name . "</option>";
            }
        }
        /* End  */
        $select_product = "<select name='' class='form-control set-product'>" . $option_product . "</select>";

        $color_option = "";

        if (count($product_current->image) > 1) {
            $color_option = '<div class="dropdown-color dropdown-menu" role="menu">';
            foreach ($product_current->image as $product_image) {
                if ($product_image->color != $color) {
                    $color_option = $color_option . '<div class="new-color btn-color btn-lg" data-image-id="' . $product_image->id . '"  data-color="' . $product_image->color . '" data-color-name="' . $product_image->color_name . '" style="background-color:' . $product_image->color . ';"></div>';
                }
            }
            $color_option = $color_option . '</div>';
            $select_color = '<div class="btn-group">
                                <button class="selected-color btn-color btn-lg dropdown-toggle disabled" data-image-id="' . $image_id . '" data-color="' . $color . '" data-color-name="' . $color_name . '" style="background-color:' . $color . ';"   data-toggle="dropdown" aria-expanded="false">
                                </button>'
                . $color_option .
                '</div>';
        } else {
            foreach ($product_current->image as $product_image) {
                $select_color = '<button data-image-id="' . $image_id . '" data-color="' . $color . '" data-color-name="' . $product_image->color_name . '" style="background-color:' . $color . ';" class="selected-color btn-color btn-lg" >
                            </button>';
            }
        }


        $size_has = $product_current->getAvailableSize();
        //$option_size ="";
        $option_size = '<option value="no_selected">เลือก</option>';
        foreach ($size_has as $size => $value) {
            $option_size = $option_size . "<option value='" . $size . "'>" . $size . "</option>";
        }
        $select_size = "<select name='' class='form-control set-size'>" . $option_size . "</select>";

        $html = '<table class="table">
                    <thead>
                        <tr>
                            <th width="80">ขนาด</th>
                            <th width="50">จำนวน</th>
                            <th width="50">สี</th>
                            <th width="50">ลบ</th>
                        </tr>
                    </thead>
                    <tbody id="product_body">
                        <tr id="current-product-row" class="product-row product-row-1" data-row="1" '
            . '" data-size="no_selected'
            . '" data-image-id="' . $image_id
            . '" data-color="' . $color
            . '" data-color-name="' . $color_name

            . '" data-qty="1">
                            <td>' . $select_size . '</td>
                            <td><input type="number" class="qty form-control" name="qty" value="1" min="1"></td>
                            <td>' . $select_color . '</td>
                            <td>
                                <button class="btn-remove btn btn-default disabled">     
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="pull-right"><b>รวมทั้งหมดจำนวน <span id="product_amount">1</span> ตัว</b></p> 

                <a id="add_new_product">เพิ่มสินค้าแบบอื่น</a>';

        return response()->json([
            'html' => $html,
        ]);
    }

    /**
     * @param $imageFile
     * @param $ext
     * @param $numColors
     * @param int $granularity
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Requests\FileFormRequest $request
     */
    public function colorPalette($imageFile, $ext, $numColors, $granularity = 5)
    {
        $granularity = max(1, abs((int)$granularity));
        $colors = array();
        $size = getimagesize($imageFile);
        if ($size === false) {
            user_error("Unable to get image size data");
            return false;
        }
        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'jpegs') {
            $img = imagecreatefromjpeg($imageFile);
        } elseif ($ext == 'png') {
            $img = @imagecreatefrompng($imageFile);
        }

        // Andres mentioned in the comments the above line only loads jpegs,
        // and suggests that to load any file type you can use this:
        // $img = @imagecreatefromstring(file_get_contents($imageFile));

        if (!$img) {
            user_error("Unable to open image file");
            return false;
        }

        for ($x = 0; $x < $size[0]; $x += $granularity)  //$size[0] = image width
        {
            for ($y = 0; $y < $size[1]; $y += $granularity)  //$size[1] = image height
            {
                $thisColor = imagecolorat($img, $x, $y);
                $rgb = imagecolorsforindex($img, $thisColor);
                $red = round(round(($rgb['red'] / 0x33)) * 0x33);
                $green = round(round(($rgb['green'] / 0x33)) * 0x33);
                $blue = round(round(($rgb['blue'] / 0x33)) * 0x33);
                $thisRGB = "#" . sprintf('%02X%02X%02X', $red, $green, $blue);
                if (array_key_exists($thisRGB, $colors)) {
                    $colors[$thisRGB]++;
                } else {
                    $colors[$thisRGB] = 1;
                }
            }
        }

        arsort($colors);
        $colors_count = count(array_slice(array_keys($colors), 0, $numColors));
        if ($colors_count <= 10 && $colors_count > 0) {
            $min = array_sum($colors) * 0.01;
            foreach ($colors as $key => $value) {
                if ($value <= $min) {
                    $colors = array_except($colors, $key);
                }
            }
        }
        /*
        print_r(array_sum($colors));
        print_r( $colors ); */
        return array_slice(array_keys($colors), 0, $numColors);
    }

    public function postUploadPicture()
    {
        Session::flush();
        $inputs = \Request::all();
        $bypass = false;

        $mime_type = config('constant.allow_mime_type');
        $mime = $inputs['file']->getMimeType();
        // echo($mime);
        if (!\Request::hasFile('file')) {
            return response()->json([
                'result' => false,
                'message' => 'ไม่พบข้อมูลไฟล์ที่อัพโหลด'
            ]);
        }

        if (!in_array($mime, $mime_type)) {
            return response()->json([
                'result' => false,
                'message' => 'อนุญาติให้อัพโหลดเฉพาะไฟล์รูปภาพแบบ JPG และ PNG เท่านั้น'
            ]);
        }

        if ($inputs['file']->getSize() > 5242880) {
            return response()->json([
                'result' => false,
                'message' => 'ขนาดไฟล์สูงสุดต้องไม่เปิน 5 mb'
            ]);
        }


        if ($inputs['file']->isValid()) {
            if (\Auth::user()->check()) {
                if (in_array(\Auth::user()->user()->role->name, [
                    config('constant.admin_role'), config('constant.super_role')
                ])) {
                    $bypass = true;
                }
            }

            $ext = $inputs['file']->getClientOriginalExtension();

            $directory = 'upload' . date('dmY');
            $base_folder = 'tmp/' . $directory . '/';
            Storage::makeDirectory($base_folder);
            $name = 'picture' . uniqid() . '.' . $ext;
            $full_path = $base_folder . '/' . $name;
            if (!\Storage::disk('local')->put($base_folder . '/' . $name, \File::get($inputs['file']))) {
                return response()->json([
                    'result' => false,
                    'message' => 'ไม่สามารถบันทึกรูปภาพได้กรุณาลองใหม่'
                ]);
            }

            // TODO : Intervention Image require edit memory_limit in php.ini for more memory consume
            $img = Image::make('../storage/app/' . $full_path);

            $width = $img->getWidth();
            $height = $img->getHeight();

            if ($width < 1200 || $width > 5000 || $height < 1200 || $height > 5000) {
                return response()->json([
                    'result' => false,
                    'message' => 'รูปภาพไม่ตรงตามขนาดที่กำหนดไว้คือ ต้องไม่น้อยกว่า 500 x 500 พิกเซล และ ต้องไม่เกิน 5000 x 5000 พิกเซล'
                ]);
            }
            $img = \Image::make('../storage/app/' . $full_path);

            $img->resize(200, NULL, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thmb_name = 'thmb_' . $name;
            if (!$img->save('../storage/app/' . $base_folder . '/' . $thmb_name)) {
                return response()->json([ 'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพได้' ]);
            }

            Session::push('user.image_upload', [
                'id' => uniqid(),
                'original' => action('DesignController@getTemp', [ $directory, $name ]),
                'real_original' => $base_folder . '/' . $name,
                'thumbnail' => action('DesignController@getTemp', [ $directory, $thmb_name ]),
                'real_thumbnail' => $base_folder . '/' . $thmb_name,
            ]);

            $result = true;
            //$message = "อัพโหลดไฟล์รูปภาพแล้ว";

            return response()->json([
                'result' => $result
            ]);
        }

        return response()->json([
            'result' => false,
            'message' => 'มีความเสียหายของข้อมูลกรุณาอัพใหม่'
        ]);
    }

    public function getGetUploadPicture()
    {
        return response()->json(Session::get('user.image_upload', NULL));
    }

    public function postDeleteUploadPicture()
    {
        $inputs = Request::all();
        Session::forget('user.image_upload.' . $inputs['index']);
        $path = str_replace('storage/', '', $inputs['original']);
        $path_thmb = str_replace('storage/', '', $inputs['thumbnail']);
        Storage::delete($path_thmb);
        Storage::delete($path);


        return response()->json([ 'result' => 'success', 'path' => $path ]);
    }

    public function postSavePreviewImage()
    {
        $inputs = Request::all();

        $base_folder = 'tmp/preview/' . date('dmY') . '/';
        Storage::makeDirectory($base_folder);

        $destination = $inputs['location'] . '-' . uniqid() . '.png';
        $img = str_replace('data:image/png;base64,', '', $inputs['image_data']);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        if (!\Storage::disk('local')->put($base_folder . '/' . $destination, $data)) {
            return NULL;
        }
        return response()->json([ 'image_url' => $destination ]);
    }

    public function postGenThumbnail()
    {
        $inputs = Request::all();

        $base_folder = 'tmp/preview/' . date('dmY') . '/';
        Storage::makeDirectory($base_folder);
        $uid = uniqid();
        $large_name = $inputs['location'] . '-' . $uid . '-thmb.png';
        $img = str_replace('data:image/png;base64,', '', $inputs['image_data']);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        if (!\Storage::disk('local')->put($base_folder . '/' . $large_name, $data)) {
            return NULL;
        }

        $medium_name = $inputs['location'] . '-' . $uid . '-thumbnail-medium.png';
        $medium = Image::make('../storage/app/' . $base_folder . $large_name)
            ->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        $medium->save('../storage/app/' . $base_folder . $medium_name);

        $mini_name = $inputs['location'] . '-' . $uid . '-thumbnail-mini.png';
        $thumbnail = Image::make('../storage/app/' . $base_folder . $medium_name)
            ->resize(270, NULL, function ($constraint) {
                $constraint->aspectRatio();
            });

        $thumbnail->save('../storage/app/' . $base_folder . $mini_name);

        return response()->json([
            'base_folder' => $base_folder,
            'thmb' => $large_name,
            'thmb_medium' => $medium_name,
            'thmb_mini' => $mini_name
        ]);
    }

    public function getTemp($directory, $file_name)
    {
        return Storage::get('tmp/' . $directory . '/' . $file_name);
    }

    public function getChooseProduct($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if(!$campaign) {
            return redirect()->back()->withErrors('ไม่พบข้อมูลแคมเปญนี้');
        }

        return view('order.choose-size', [
            'title' => 'เลือกขนาดและจำนวน',
            'campaign' => $campaign
        ]);
    }
    /*
     * AJAX add design canvas item to session
     */

    public function postAddNewItem()
    {
        $key = 'campaign.item';

        return response()->json([ 'result' => 'success' ]);
    }


    /*
     * END AJAX design canvas
     */

}
