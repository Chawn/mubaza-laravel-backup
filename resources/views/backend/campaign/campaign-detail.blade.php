@extends('backend.layouts.master')
@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('css')
<style>
.art-thumbnail,.shirt-thumbnail{
    background: transparent;
}
</style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script src="{{ asset('js/countdown/jquery.countdown.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		
    });
</script>
@stop
@section('content')
<div class="row">
    <div class="col-sm-9">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">ชื่อแคมเปญ : {{ $campaign->title }}</h3>
            </div>
            <div class="box-body">
                    <strong>ลิงค์สินค้า:</strong> {{ url($campaign->url) }}.html
                    <a href="{{ url($campaign->url)}}.html" class="btn btn-default ">
                        <fa class="fa fa-search"></fa> ดูแคมเปญนี้
                    </a>
                    
                    <p>
                        <strong>Product id:</strong> {{ $campaign->id }}
                    </p>
                    
                    <p>
                        <strong>ครีเอเตอร์:</strong> <a class="text-grey" href="{{ action('BackendController@getUserDetail',$campaign->user->getID()) }}">
                             {{ $campaign->user->getName() }}
                         </a>
                    </p>
                    <p>
                        <strong>วันที่สร้าง:</strong> {{ $campaign->created_at }}
                    </p>
                    <p>
                        <strong>วันที่แก้ไขล่าสุด:</strong> {{ $campaign->updated_at }}
                    </p>
                
                
                
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">แก้ไขรายละเอียด</h3>
            </div>

            <div class="box-body">
                <label class="title" for="title">หัวข้อ</label>
                <input id="title" name="title" class="form-control" value="{{ $campaign->title }}" required>


                <br>
                <label class="title" for="category">หมวดหมู่</label>
                {{-- <select id="category" name="category" class="form-control" required>
                   <option value="0">เลือกหมวดหมู่สินค้า</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($category->id === $campaign->campaign_category_id) ? 'selected' : ''  }}>{{ $category->name }}</option>
                    @endforeach
                </select> --}}
                <br>
                <label class="title" for="description">รายละเอียด</label><br>
                <textarea name="description" id="description" class="form-control description" rows="3"
                          required>{{ $campaign->description }}</textarea>

                <p>
                    <small>บอกเรื่องราว ที่มา หรือความหมาย เพื่อเพิ่มความน่าสนใจให้กับสินค้า</small>
                </p>
                <script>
                    CKEDITOR.replace('description');
                </script>
                <br>
                <label class="title" for="tags">แท็ก</label>
                <input type="text" class="form-control" id="tags" name="tags"
                       value="{{ $campaign->allTags() }}" required>

                <p>
                    <small>สามารถใส่ได้สูงสุด 5 แท็ก ขั้นแต่ละคำด้วย "," (คอมม่า) เช่น แมว, แมวสีขาว, Cat,
                        White Cat
                        <br><strong class="">ใช้คำที่เกี่ยวข้องกับลาย</strong>
                        จะช่วยให้ลูกค้าค้นหาเจอได้ง่ายขึ้นบนเว็บของเรา และจากเว็บค้นหาอื่นๆ
                    </small>
                </p>


            </div>
        </div>

        <div class="box">
            <div class="box-header">
                สินค้าที่เปิดขาย
            </div>

            <div class="box-body row">
                <div class="col-sm-4">
                        <img class="thumbnail img-responsive"
                             src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->frontCover()]) }}">
                        <p class="text-center">รูปหลัก</p>
                    <img class="art-thumbnail  thumbnail  img-responsive" src="{{ action('CampaignController@getFile', [$campaign->id, $campaign->image_front]) }}" style="background:#eee;">
                    <p class="text-center">Art</p>

                    
                </div>
                <div class="col-sm-8">
                    <table class="table table-hover dataTable ">
                        <tr>
                            <th width="140">
                                รูปตัวอย่างสินค้า
                            </th>
                            <th>
                                ชื่อสินค้า
                            </th>
                        </tr>
                        @foreach($campaign->products as $product)
                            <tr class="">
                                <td>
                                    <a href="javascript:void(0)">
                                        <div class="product-img">
                                            <img class="thumbnail img-responsive product-thumbnail {{ $product->is_primary ? 'active' : '' }}"
                                                 data-campaign-product-id="{{ $product->id }}"
                                                 data-remove-btn="{{ '#remove-' . $product->id }}"
                                                 src="{{ action('CampaignController@getFile', [$campaign->id, $product->image_front_small]) }}">
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <p>{{ $product->color->product->name }}</p>

                                    <p>{{ $product->color->color_name }}</p>
                                    <p>
                                        <strong>
                                            ฿{{ $product->sell_price }}
                                        </strong>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>

    </div>
    <div class="col-sm-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    เครื่องมือ
                </h3>
            </div>
            <div class="box-body">
                <p>
                    สถานะการขาย: 
                    @if($campaign->status->name == 'ban')
                        <span class="label label-danger">
                            <i class="fa fa-ban"></i> BANNED
                        </span>
                        &nbsp;
                    @elseif($campaign->status->name == 'active')
                        <span class="label label-success">
                            <i class="fa fa-check"></i> Active
                        </span>
                    @else 
                        {{ $campaign->status->name }}
                    @endif
                </p>
                <p>
                    Set New: 
                    @if($campaign->is_recommended)
                        <span class="label label-primary">
                            <i class="fa fa-thumbs-up"></i>  NEW
                        </span>
                    @else
                        -
                    @endif
                </p>
                <p>
                    Set Hot: 
                    @if($campaign->is_hot)
                        <span class="label label-primary">
                            <i class="fa fa-star"></i> HOT
                        </span>
                    @else
                        -
                    @endif
                </p>
                <hr>
                <div class="dropdown column">
                    <button class="btn-block btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i
                                class="fa fa-gear"></i>
                        การกำหนดค่าแสดงผล <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        {{--<li>--}}
                            {{--<a href="{{ action('BackendController@getSetApprove', $campaign->id) }}">--}}
                                {{--<i class="fa {{ $campaign->is_active ? 'fa-times' : 'fa-check' }}"></i> {{ $campaign->is_active ? 'Not Approve' : 'Approve' }}--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ action('BackendController@getSetRecommended', $campaign->id) }}" class="">
                                <i class="fa {{ $campaign->is_recommended ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}">
                                </i> {{ $campaign->is_recommended ? 'Remove New' : 'Set New' }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('BackendController@getSetHot', $campaign->id) }}" class="">
                                <i class="fa {{ $campaign->is_hot ? 'fa-star' : 'fa-star-o' }}">
                                </i> {{ $campaign->is_hot ? 'Remove Hot' : 'Set Hot' }}
                            </a>
                        </li>
                        <li>
                            @if($campaign->status->name == 'ban' || $campaign->status->name == 'check')
                                <a class="" href='{{ action('BackendController@getActivateCampaign', $campaign->id) }}'><i
                                            class="fa fa-check"></i> อนุมัติแคมเปญนี้</a>
                            @else
                                <a class="" data-toggle="modal" href='#modal-ban-{{ $campaign->id }}'><i
                                            class="fa fa-ban"></i> ไม่อนุมัติแคมเปญนี้</a>
                            @endif
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
        

<div class="modal fade" id="modal-ban-{{ $campaign->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">เหตุผลในการระงับ</h4>
            </div>
            <form action="{{ action('BackendController@postBanCampaign', $campaign->id) }}" method="post">
                {!! csrf_field() !!}
                <div class="modal-body">
                <textarea name="remark" id="remark" cols="30" rows="10"
                          class="form-control">
                    ไม่เป็นไปตามเงื่อนไข
                </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>
</div>  


				    <!-- End comfirm dialog box -->
@stop