<html>
<head>
    <title></title>
    <style>
        .containerDiv {
            border: 1px solid #3697f6;
            width: 100%;
            display: table
        }

        .rowDivHeader {
            border: 1px solid #668db6;
            background-color: #336799;
            color: white;
            font-weight: bold;
            display: table-row
        }

        .rowDiv {
            border: 1px solid #668db6;
            background-color: #cee6fe;
            display: table-row
        }

        .cellDivHeader {
            border-right: 1px solid white;
            display: table-cell;
            width: 2%;
            padding: 1px;
            text-align: right;
        }

        .cellDiv {
            border-right: 2px solid white;
            display: table-cell;
            width: 10%;
            padding-right: 4px;
            text-align: left;
            border-bottom: none;
        }

        .lastCell {
            border-right: none;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>{{ isset($id) ? 'Edit' : 'Add' }} coupon {{$id}}</h1>
</div>

@if (count($errors) > 0)
    <div class="containerDiv" style=" border: 1px solid #ff0000;">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div class="containerDiv">
    <form action="/coupon/store" method="POST">
        @if(isset($id))
            <input type="hidden" name="id" value="{{$id}}">
        @endif
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="rowDiv">
            <div class="cellDivHeader">ชื่อคูปอง</div>
            <div class="cellDiv">
                <input type="text" name="coupon_name" value="{{@$coupon->coupon_name}}"/>
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">รายละเอียด</div>
            <div class="cellDiv">
                <textarea rows="3" column="5" name="coupon_detail">{{@$coupon->coupon_detail}}</textarea>
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">Code</div>
            <div class="cellDiv">
                <input type="text" name="coupon_code" value="{{@$coupon->coupon_code}}"/>
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">ส่วนลด</div>
            <div class="cellDiv">
                <input type="text" name="coupon_discount_number" value="{{@$coupon->coupon_discount_number}}"/>
                <select name="coupon_discount_type">
                    <option value="percent" {{ @$coupon->coupon_discount_type == 'percent' ? 'selected' : '' }}>%
                    </option>
                    <option value="price" {{ @$coupon->coupon_discount_type == 'price' ? 'selected' : '' }}>บาท</option>
                </select>
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">เงื่อนไข</div>
            <div class="cellDiv">
                <input type="checkbox"
                       name="coupon_condition_at_least_price_flag" {{ @$coupon->coupon_condition_at_least_price_flag == 'yes' ? 'checked' : '' }} />
                ราคาขั้นต่ำ <br/>
                <input type="checkbox"
                       name="coupon_condition_end_date_flag" {{ @$coupon->coupon_condition_end_date_flag == 'yes' ? 'checked' : '' }} />
                วันที่สิ้นสุด <br/>
                {{--<input type="checkbox" name="_flag"/> กำหนด id สินค้า <br/>--}}
                <input type="checkbox"
                       name="coupon_condition_max_use_per_user_flag" {{@$coupon->coupon_condition_max_use_per_user_flag == 'yes' ? 'checked' : ''}} />
                จำนวนการใช้งานต่อ user <br/>
                <input type="checkbox"
                       name="coupon_condition_max_user_flag" {{ @$coupon->coupon_condition_max_user_flag == 'yes' ? 'checked' : '' }}/>
                จำนวน user ที่สามารถใช้ได้ <br/>
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">ราคาขั้นต่ำ</div>
            <div class="cellDiv">
                <input type="text" name="coupon_condition_at_least_price"
                       value="{{@$coupon->coupon_condition_at_least_price}}"/>
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">วันที่สิ้นสุด</div>
            <div class="cellDiv">
                <input type="text" name="coupon_condition_end_date"
                       value="{{isset($coupon->coupon_condition_end_date) ? $coupon->coupon_condition_end_date : '2016-12-01 00:00:00'}}"/>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDivHeader">จำนวนการใช้งานต่อ user</div>
            <div class="cellDiv">
                <input type="text" name="coupon_condition_max_use_per_user"
                       value="{{isset($coupon->coupon_condition_max_use_per_user) ? $coupon->coupon_condition_max_use_per_user : 1}}"/>
                ครั้ง
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">จำนวน user ที่สามารถใช้ได้</div>
            <div class="cellDiv">
                <input type="text" name="coupon_condition_max_user" value="{{@$coupon->coupon_condition_max_user}}"/> คน
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader">สถานะ</div>
            <div class="cellDiv">
                <input type="radio" name="status"
                       value="enable" {{ @$coupon->status || !isset($id) == 'enable' ? 'checked' : '' }} />
                ใช้งาน <br/>
                <input type="radio" name="status" value="draft" {{ @$coupon->status == 'draft' ? 'checked' : '' }}/>
                ฉบับร่าง <br/>
                <?php
                $checked = '';
                if (@$coupon->status == 'disable')
                $checked = 'checked';
                if ($id) {
                echo '<input type="radio" name="status" value="disable" ' . $checked . ' /> ปิดการใช้งาน';
                }
                ?>
            </div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader"></div>
            <div class="cellDiv">
                <br/>
                <br/>
                <input type="submit" value="Save"/>
            </div>
        </div>
    </form>
</div>
</body>
</html>