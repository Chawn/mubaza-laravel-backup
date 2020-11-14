@extends('backend.layouts.master')
@section('css')
    <style>
        table#edit-campaign {
            width: 60%;
        }
        table label {
            margin-bottom:0px;
        }
    </style>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>

            <div class="box-body">

                <div class="clear-fix">&nbsp;</div>
                <form action="{{ action('BackendController@postUpdateCampaign', $campaign->id) }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                    <table id="edit-campaign" class="table">
                        <tr>
                            <td><label for="">รหัสผู้ใช้งาน</label></td>
                            <td>
                                <select name="user_id" id="user-id" class="form-control">
                                    @foreach(\App\User::all() as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $campaign->user_id ? 'selected' : '' }}>{{ $user->id . ' - ' . $user->full_name }}</option>
                                    @endforeach
                                </select>
                                {{--<input type="text" name="user_id" value="{{ $campaign->user_id }}" required class="form-control">--}}
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">ชื่อแคมเปญ</label></td>
                            <td>
                                <input type="text" name="title" value="{{ $campaign->title }}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">รายละเอียด</label></td>
                            <td>
                                <textarea name="description" id="" cols="30" rows="10"
                                          class="form-control">{{ $campaign->description }}</textarea>
                            </td>
                        </tr>
                        @if($campaign->type->name == 'sell')
                        <tr>
                            <td><label for="">URL</label></td>
                            <td>
                                <input type="text" name="url" value="{{ $campaign->url }}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="checkbox" name="back_cover" value="1">&nbsp;แสดงด้านหลังเป็นค่าเริ่มต้น {{ $campaign->back_cover ? 'checked' : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">เป้าหมาย</label></td>
                            <td>
                                <input type="text" name="goal" value="{{ $campaign->goal }}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">ค่าบล็อก</label></td>
                            <td>
                                <input type="text" name="block_cost" value="{{ $campaign->block_cost }}" required
                                       class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">ค่าสกรีน</label></td>
                            <td>
                                <input type="text" name="screen_cost" value="{{ $campaign->screen_cost }}" required
                                       class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">เริ่ม</label></td>
                            <td>
                                <input type="text" name="start" value="{{ $campaign->start }}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">สิ้นสุด</label></td>
                            <td>
                                <input type="text" name="end" value="{{ $campaign->end }}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="checkbox" name="is_recommended" value="1"
                                       {{ $campaign->is_recommended ? 'checked' : '' }}>&nbsp;แนะนำ
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="checkbox" name="is_checked" value="1"
                                       {{ $campaign->is_checked ? 'checked' : '' }}>&nbsp;ตรวจสอบการผลิตแล้ว
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="checkbox" name="is_user_deleted" value="1"
                                       {{ $campaign->is_user_deleted ? 'checked' : '' }}>&nbsp;ลบโดยผู้ใช้งาน
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td>ประเภท</td>
                            <td>
                                <select name="campaign_type_id" class="form-control">
                                    @foreach(\App\CampaignType::all() as $type)
                                        <option value="{{ $type->id }}"
                                                {{ $campaign->type->id == $type->id ? 'selected' : '' }}>
                                            {{ $type->detail }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>สถานะ</td>
                            <td>
                                <select name="campaign_status_id" class="form-control">
                                    @foreach(\App\CampaignStatus::all() as $status)
                                        <option value="{{ $status->id }}"
                                                {{ $campaign->status->id == $status->id ? 'selected' : '' }}>
                                            {{ $status->detail }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>สถานะการผลิต</td>
                            <td>
                                <select name="campaign_produce_status_id" class="form-control">
                                    @foreach(\App\CampaignProduceStatus::all() as $produce_status)
                                        <option value="{{ $produce_status->id }}"
                                                {{ $campaign->produce_status->id == $produce_status->id ? 'selected' : '' }}>
                                            {{ $produce_status->detail }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">จำนวนสีด้านหน้า</label></td>
                            <td>
                                <input type="text" name="block_front_count" value="{{ $campaign->design->block_front_count }}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">จำนวนสีด้านหลัง</label></td>
                            <td>
                                <input type="text" name="block_back_count" value="{{ $campaign->design->block_back_count }}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">หมายเหตุ</label></td>
                            <td>
                                <textarea name="remark" id="" cols="30" rows="10"
                                          class="form-control">{{ $campaign->remark }}</textarea>
                            </td>
                        </tr>
                        {{--<tr>--}}
                        {{--<td>วิธีการจัดส่ง</td>--}}
                        {{--<td>--}}
                        {{--<select name="shipping_type"  class="form-control">--}}
                        {{--@foreach(\App\ShippingType::all() as $shipping_type)--}}
                        {{--<option value="{{ $shipping_type->name }}" {{ $order->shipping_type->id == $shipping_type->id ? 'selected' : '' }}>{{ $shipping_type->detail }}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>ชื่อ นามสกุล ผู้รับสินค้า </td>--}}
                        {{--<td>--}}
                        {{--<input type="text" name="full_name" class="form-control" value="{{ $order->shipping_address->full_name }}" required>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>ที่อยู่</td>--}}
                        {{--<td>--}}
                        {{--<textarea name="address" placeholder="ที่อยู่" class="form-control" required>{{ $order->shipping_address->address }}</textarea>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>อาคาร</td>--}}
                        {{--<td>--}}
                        {{--<input type="text" name="building" class="form-control" value="{{ $order->shipping_address->building }}">--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>อำเภอ</td>--}}
                        {{--<td>--}}

                        {{--<input type="text" name="district" class="form-control" value="{{ $order->shipping_address->district }}" required>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>จังหวัด</td>--}}
                        {{--<td>--}}
                        {{--<select name="province" id="province" class="form-control" id="province"--}}
                        {{--required>--}}
                        {{--@foreach(Config::get('constant.provinces') as $province)--}}
                        {{--<option value="{{ $province }}" {{ $order->shipping_address->province == $province ? 'selected' : ''}}>{{ $province }}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>รหัสไปรษณีย์</td>--}}
                        {{--<td>--}}
                        {{--<input type="text" name="zipcode" class="form-control" value="{{ $order->shipping_address->zipcode }}">--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>เบอร์โทรศัพท์</td>--}}
                        {{--<td>--}}
                        {{--<input type="text" name="phone" placeholder="โทรศัพท์" class="form-control" value="{{ $order->shipping_address->phone }}">--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                        {{--<td>อีเมล</td>--}}
                        {{--<td>--}}
                        {{--<input type="text" name="email" placeholder="อีเมล" class="form-control" value="{{ $order->shipping_address->email }}">--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-success btn-lg">บันทึก</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@stop