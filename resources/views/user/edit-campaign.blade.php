@extends('user.layouts.master')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.bootstrap3.css') }}"/>
    @stop
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('ckeditor-custom/ckeditor.js') }}"></script>
    <script src="{{ asset('js/selectize/selectize.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var products = null;
            getProductData();
            enableInputPrice();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            baseEventProduct();
            $('#tags').selectize({
                delimiter: ',',
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });

            $("#close-date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy',
                isBuddhist: true,
                dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
            });
            $('#close-date').change(function () {
                var current_date = moment($('#close-date').attr('data-current-date'), 'DD/MM/YYYY');
                var choose_date = moment($('#close-date').val(), 'DD/MM/YYYY');
                var diff_day = parseInt(choose_date.diff(current_date, 'd'));
                if (current_date.isAfter(choose_date) || current_date.isSame(choose_date)) {
                    alert('ไม่สามารถเลือกเป็นวันปัจจุบันได้');
                    $('#close-date').val(current_date.add(7, 'd').format('DD/MM/YYYY'));
                }
                if (diff_day > 30) {
                    alert('ไม่สามารถกำหนดวันที่สิ้นสุดเกิน 30 วันได้');
                    $('#close-date').val(current_date.add(7, 'd').format('DD/MM/YYYY'));
                }
            });

            $('input[name=end]').change(function () {
                if ($('input[name=end]:checked').val() == 1) {
                    $('#close-date').closest('tr').removeClass('hidden');
                }
                else {
                    $('#close-date').closest('tr').addClass('hidden');
                }
            });

            function loadCategory() {
                $.each(products, function (k, v) {
                    $('#select-category').append('<option value="' + v.id + '">' + v.detail + '</option>');
                });
                getProduct($('#select-category').val());
            }

            $('#select-category').change(function () {
                getProduct($(this).val());
            });

            function getProduct(category_id) {
                var category = null;
                $('#product').empty();
                if (category == "") {
                    $('#product').append('<option value="">ไม่มีสินค้า</option>');
                }
                else {
                    category = $(products).filter(function () {
                        return this.id == category_id;
                    })[0];
                    if (category.products.length > 0) {
                        $.each(category.products, function (k, v) {
                            $('#product').append('<option value="' + v.id + '">' + v.name + '</option>');
                        });
                    }
                    else {
                        $('#product').append('<option value="">ไม่มีสินค้า</option>');
                    }
                }

            }

            $('#add-product').click(function () {
                var id = $("#product-id").find(":selected").val();
                var used_color = $("#used_color").attr('data-color');
                if ($('.row-product').length < 10) {
                    addRowProduct($('#select-category').val(), $('#product').val());
                } else {
                    alert("สำนวนสินค้าที่คุณขายได้สูงสุดคือ 10 แบบ");
                }
            });
            $("#save-campaign").click(function(){
                saveCampaign();
            });
            function addRowProduct(category_id, product_id) {
                var new_item = false;
                var category = $(products).filter(function () {
                    return this.id == category_id;
                })[0];

                var product = $(category.products).filter(function () {
                    return this.id == product_id;
                })[0];
                var row_html = '';
                if (product != undefined) {
                    var image = null;
                    $.each(product.image, function (k, v) {
                        if (checkDuplicateProduct(v.id)) {
                            image = v;
                            return false;
                        }
                    });

                    if (image == null) {
                        alert("ไม่มีสีในสินค้าแบบนี้แล้ว");
                        return false;
                    }
                    row_html += '<tr class="row-product new-product row-price-' + product.id +'" ' +
                                'data-product-id="' + product.id +'" ' +
                                'data-name="' + product.name +'" ' +
                                'data-image-id="' + image.id +'" ' +
                                'data-unit-price="' + product.price + '" ' +
                                'data-image-url="' + image.image_front + '">';
                    row_html += '<td><img class="product_image" ' +
                                'src="' + image.image_front + '" ' +
                                'style="width:40px"></td>';
                    row_html += '<td>' +
                            '<div class="btn-group">' +
                            '<button data-color="' + image.color + '" ' +
                            '        style="background-color:' + image.color + ';" ' +
                            '        class="selected-color btn-color btn-lg dropdown-toggle" ' +
                            '        data-image-id="' + image.id + '" ' +
                            '        data-image-front="' + image.image_front + '" ' +
                            '        data-toggle="dropdown" aria-expanded="false"></button>';
                    row_html += '<div id="dropdown-color" class="dropdown-color dropdown-menu" role="menu">';
                    $.each(product.image, function (k, v) {
                        if (image.id != v.id) {
                            row_html += '<div class="new-color btn-color btn-lg" data-image-front="' + v.image_front + '" ' +
                                    'data-color="' + v.color + '" data-image-id="' + v.id + '" style="background-color:' + v.color + ';"></div>';
                        }
                    });
                    row_html += '</div></div></td>';
                    row_html += '<td>' + product.name + '</td>';
                    row_html += '<td>';

                    if ($('.row-price-' + product.id).attr('data-product-id') == undefined) {
                        row_html += '<input type="number" class="form-control input-price price-' + product.id + '" name="sell_price" max="10000" >';
                        new_item = true;
                    }
                    else {
                        row_html += '<input type="number" class="form-control input-price price-' + product.id + '" disabled name="sell_price" value="' + $('.row-price-' + product.id).find(".input-price").val() + '" max="10000" >';
                    }

                    row_html += '</td>';
                    row_html += '<td><a class="trash"><i class="fa fa-times"></i></a></td></tr>';
                    $('.product-selected tbody').append(row_html);
                    baseEventProduct();

                    if (new_item) {
                        getRealPrice(product.id, $('.row-price-' + product.id).find('.input-price'));
                    }
                }
            }
            function change_color(new_color_btn) {
                if (checkDuplicateProduct(new_color_btn.attr('data-image-id'))) {
                    var new_color = new_color_btn.attr('data-color');
                    var new_image = new_color_btn.attr('data-image-front');
                    var new_image_id = new_color_btn.attr('data-image-id');
                    var selected_btn = new_color_btn.closest('.btn-group').find(".selected-color");

                    var selected_image = new_color_btn.attr('data-image-front');
                    var current_color = selected_btn.attr('data-color');
                    var current_image = selected_btn.attr('data-image-front');
                    var current_image_id = selected_btn.attr('data-image-id');
                    new_color_btn.css('background-color', current_color);

                    new_color_btn.attr('data-color', current_color);
                    new_color_btn.attr('data-image-front', current_image);
                    new_color_btn.attr('data-image-id', current_image_id);
                    selected_btn.css('background-color', new_color);

                    selected_btn.attr('data-color', new_color);
                    selected_btn.attr('data-image-front', new_image);
                    selected_btn.attr('data-image-id', new_image_id);
                    selected_btn.closest('div.row-product').attr('data-image-id', new_image_id);
                    var product_image = new_color_btn.closest('.row-product').find(".product_image");

                    product_image.attr("src", new_image);
                } else {
                    alert('สินค้านี้มีอยู่แล้วกรุณาเลือกใหม่');
                }
            }
            function baseEventProduct() {
                $(".new-color").unbind("click");
                $(".input-price").unbind("change");
                $('body').off('.trash');
                $('body').off('.input-price');
                $(".new-color").click(function () {
                    change_color($(this));
                });
                $(".trash").click(function () {
                    $(this).closest('.row-product').remove();
                    refreshInputPrice();
                });
                $('.input-price').keyup(function () {
                    var product_id = $(this).closest('.row-product').attr('data-product-id');
                    $('.price-' + product_id).val($(this).val());
                    if (parseInt($(this).val()) > parseInt($(this).attr("min"))) {
                    }
                });
            }

            // Remove product modal
            $('#remove-product-modal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var modal = $(this);
                modal.find('#confirm-remove').attr('href', button.attr('data-url'));
            });

            /*
            AJAX
             */

            function saveCampaign() {
                var campaign_id = $('#save-campaign').attr('data-campaign-id');
                var tags = $('#tags').val().split(",");
                var tag_array = [];
                $.each(tags, function (k, v) {
                    tag_array.push(v);
                });

                var products = [];
                $('.row-product').each(function() {
                    var campaign_product_id = null;
                    if($(this).attr('data-campaign-product-id') != undefined)
                    {
                        campaign_product_id = $(this).attr('data-campaign-product-id');
                    }
                   var product = {
                       id: campaign_product_id,
                       product_id: $(this).attr('data-product-id'),
                       product_image_id: $(this).attr('data-image-id'),
                       sell_price: $(this).find(".input-price").val(),
                       campaign_id: campaign_id
                   };

                    products.push(product);
                });

                var end_amount = $('input[name=end]:checked').val();
                if (end_amount == '1') {
                    var current_date = moment($('#close-date').attr('data-current-date'), 'DD/MM/YYYY');
                    var choose_date = moment($('#close-date').val(), 'DD/MM/YYYY');
                    end_amount = choose_date.diff(current_date, 'd');
                }
                else {
                    end_amount = parseInt(end_amount);
                }

                $.ajax({
                    type: "POST",
                    url: "/user/{{ $user->getID() }}/update-campaign/" + campaign_id,
                    data: {
                        title: $('#title').val(),
                        description: CKEDITOR.instances.description.getData(),
                        tags: tag_array,
                        back_cover : $('input[name=back_cover]:checked').val(),
                        goal: $("#goal").val(),
                        limit: $("#limit").val(),
                        end_amount: end_amount,
                        products: products
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data.error)
                        {
                            alert(data.message);
                        }
                        else
                        {
                            window.location.reload();
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }
            function getProductData() {
                $.ajax({
                    method: 'GET',
                    url: '/product/all-products',
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            products = data.products;
                            loadCategory();
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function getRealPrice(product_id, element) {
                $.ajax({
                    type: "POST",
                    url: "/sell/real-price/" + product_id,
                    data: {
                        campaign_id: $('#save-campaign').attr('data-campaign-id')
                    },
                    dataType: "json",
                    success: function (data) {
                        element.val(data.price);
                        element.attr('min', data.price);
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            /*
            END AJAX
             */

            /*
            None AJAX function
             */
            function checkDuplicateProduct(id) {
                var result = true;
                $('.row-product').each(function () {
                    if ($(this).attr('data-image-id') == id) {
                        result = false;
                        return false;
                    }
                });

                return result;
            }

            function enableInputPrice() {
                var old_id = "";
                $(".row-product").each(function() {
                    var current_id = $(this).attr("data-product-id");
                    if(old_id != current_id)
                    {
                        $(this).find('.input-price').removeAttr("disabled");
                        old_id = current_id;
                    }
                });
            }
        });
    </script>
@stop
@section('content')
    <div id="set-goal">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="title">รายละเอียดสินค้า</div>
                <div class="box">
                    <div class="wrapper">
                        <div class="detail">
                            <form id="campaign-detail" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <b>ชื่อแคมเปญ</b>
                                            <span class="badge"><i class=" fa fa-question"></i></span>
                                            <input type="text" id="title" class="form-control" maxlength="40" value="{{ $campaign->title }}" required>
                                            <span>สรุปแคมเปญของคุณใน 40 ตัวอักษรหรือน้อยกว่า</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b class="">คำอธิบาย</b>
                                        <textarea name="description" id="description" class="form-control description"
                                                  rows="3" required>{{ $campaign->description }}</textarea>
                                            <script>
                                                CKEDITOR.replace('description');
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>แท็ก</b>
                                            <input type="text" class="form-control" id="tags" name="tags" value="{{ $campaign->allTags() }}"required>
                                            <span>แท็กผลิตภัณฑ์ของคุณ จะช่วยให้ลูกค้าค้นหาเจอได้ง่ายบนเว็บของเรา และจากเว็บค้นหาอื่นๆ (เช่น แมว, จักรยาน, ท่องเที่ยว)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>ตัวเลือกการแสดง</b>
                                        </td>
                                    <tr>
                                        <td><label for="front_cover">
                                                <input type="radio" name="back_cover" id="front_cover" value="0" {{ $campaign->back_cover ? '' : 'checked' }}>
                                                แสดงด้านหน้าเป็นค่าปริยาย
                                            </label></td>
                                    </tr>
                                    <tr>
                                        <td><label for="back_cover">
                                                <input type="radio" name="back_cover" id="back_cover" value="1" {{ $campaign->back_cover ? 'checked' : '' }}>
                                                แสดงด้านหลังเป็นค่าปริยาย
                                            </label></td>
                                    </tr>

                                </table>
                            </form>
                        </div>

                    </div>
                </div>
                </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="title">ตั้งเป้าการขาย</div>
                <div class="box">
                    <div class="wrapper">
                        <div class="detail">
                            <form action="#" id="goal-form">
                                <table class="table-form set-goal-table">
                                    <tr>
                                        <td class="topic">เป้าหมาย</td>
                                        <td>
                                            <div class="column spinner-none">
                                                <input type="number" id="goal"
                                                       class="form-control" name="goal"
                                                       min="10"
                                                       value="{{ $campaign->goal }}" placeholder="ต่ำสุด 10">

                                            </div>
                                            <div class="column">ตัว</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="topic">จำนวนสูงสุด</td>
                                        <td>
                                            <div class="column spinner-none">
                                                <input type="number" id="limit"
                                                       class="form-control" name="limit"
                                                       min="0"
                                                       value="{{ $campaign->limit }}">

                                            </div>
                                            <div class="column">ตัว</div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <div class="description">
                                เมื่อระยะเวลาเปิดขายสิ้นสุดลง แต่การขายน้อยกว่าเป้าหมาย อย่างไรก็ตาม เรายังคงผลิตให้
                                หากมีจำนวนผู้สั่งซื้อมากพอที่จะคุณจะได้กำไร
                            </div>
                        </div>
                    </div>
                    <div class="wrapper set-price">
                        <div class="title">เลือกสินค้าและตั้งราคา</div>
                        <div class="detail">
                            <table class="table product-selected">
                                <thead>
                                <tr>
                                    <th>รูปภาพ</th>
                                    <th>สี</th>
                                    <th>ชื่อสินค้า</th>
                                    <th width="20%">ราคา</th>
                                    <th width="10%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaign->products as $key => $product)
                                        <tr class="row-product row-price-{{ $product->product->id }}"
                                            data-campaign-product-id="{{ $product->id }}"
                                            data-product-id="{{ $product->product->id }}"
                                            data-name="{{ $product->product->name }}"
                                            data-image-id="{{ $product->product_image_id }}"
                                            data-unit-price="{{ $product->unit_price }}"
                                            data-image-url="{{ $product->product_image->image_front }}">
                                            <td><img class="product_image"
                                                     src="{{ $product->product_image->image_front }}"
                                                     style="width:40px"></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-color="{{ $product->product_image->color }}"
                                                            style="background-color:{{ $product->product_image->color }};"
                                                            class="selected-color btn-color btn-lg dropdown-toggle"
                                                            data-image-id="{{ $product->product_image_id }}"
                                                            data-image-front="{{ $product->product_image->image_front }}"
                                                            data-toggle="dropdown" aria-expanded="false"></button>
                                                    <div id="dropdown-color" class="dropdown-color dropdown-menu"
                                                         role="menu">
                                                        @foreach($product->product->image as $image)
                                                            @if($image->id != $product->product_image_id)
                                                                <div class="new-color btn-color btn-lg"
                                                                     data-image-front="{{ $image->image_front }}"
                                                                     data-color="{{ $image->color }}"
                                                                     data-image-id="{{ $image->id }}"
                                                                     style="background-color:{{ $image->color }};"></div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $product->product->name }}</td>
                                            <td><input type="number" class="form-control input-price price-{{ $product->product->id }}" name="sell_price"
                                                       placeholder="" value="{{ $product->sell_price }}" max="10000" disabled>
                                                </td>
                                            <td>
                                            @if($key > 0)
                                                    <a class="db-trash" data-toggle="modal"
                                                       data-target="#remove-product-modal"
                                                       data-url="{{ action('UserController@getRemoveProduct', [$user->getID(), $product->id]) }}">
                                                        <i class="fa fa-times"></i></a>
                                            @endif</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="wrapper new-product">
                                <a id="new-product">เพิ่มสินค้าแบบอื่น</a>

                                <div id="select-product" class="row-fluid">
                                    <div class="column col-cat-option">
                                        <select name="select_category" id="select-category" class="form-control">
                                        </select>
                                    </div>
                                    <div class="column col-product-option">
                                        <select name="product" id="product" class="form-control">
                                        </select>
                                    </div>
                                    <div class="column">
                                        <button name="add_product" id="add-product" type="button"
                                                class="btn btn-primary"> +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="set-goal-table">
                            <tbody>
                            <tr>
                                <td class="topic">ระยะเวลาเปิดขาย</td>
                                <td>
                                    <input type="radio" name="end" id="no" value="0" {{ $campaign->end_amount == 0 ? 'checked' : '' }}>&nbsp;ไม่มี
                                </td>
                                <td>
                                    <input type="radio" name="end" id="customize" value="1" {{ $campaign->end_amount > 0 ? 'checked' : '' }}>&nbsp;กำหนดเวลา
                                </td>
                            </tr>
                            <tr class="{{ $campaign->end_amount == 0 ? 'hidden' : '' }}">
                                <td>กำหนดเวลาสิ้นสุด</td>
                                <td colspan="2"><input type="text" name="close_date" id="close-date"
                                                       data-current-date="{{ \Carbon::now()->format('d/m/Y') }}"
                                                       placeholder="เวลาสิ้นสุด"
                                                       class="form-control"
                                            value="{{ $campaign->end_amount > 0 ? $campaign->end->format('d/m/Y') : \Carbon::now()->format('d/m/Y') }}"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="clear-fix">&nbsp;</div>
                <div class="wrapper">
                    <button type="submit" id="save-campaign" data-campaign-id="{{ $campaign->id }}" class="btn btn-success btn-medium"><i class="fa fa-check"></i>&nbsp;ต่อไป
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="remove-product-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ยืนยันการลบสินค้า</h4>
                </div>
                <div class="modal-body">
                    คุณแน่ใจว่าต้องการลบสินค้าชิ้นนี้?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="" class="btn btn-primary"  id="confirm-remove">Save changes</a>
                </div>
            </div>
        </div>
    </div>
@stop