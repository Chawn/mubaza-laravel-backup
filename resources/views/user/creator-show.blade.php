@extends('layouts.full_width')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <style type="text/css">
        .lock{
            height: 100%;
            overflow: hidden;
        }
        .lazy:not(.lazy-loaded){
            background: url(./images/tshirt-loading-s.gif);
            background-size: contain;
            background-repeat: no-repeat;
        }
        .profile-circle{
        	width: 34px;
        	height: 34px;
        }
        .follow-btn{
            margin-top: 10px;
        }
    </style>
@stop
@section('script')
    <script src="{{asset('js/jquery.lazyload.js')}}"></script>
    <script>
        $(document).ready(function () {
           
        });
        $(function() {
            $("img.lazy").lazyload({
                threshold : 280,
                effect : "fadeIn",
                event : "sporty",
            });
        });
        $(window).bind("load", function() {
            var timeout = setTimeout(function() {
                $("img.lazy").trigger("sporty")
            }, 2000);
        });
    </script>
@stop
@section('content') 

	@if(\Auth::user()->check())
        @if(Auth::user()->user()->id==$creator->id)
            <div class="alert alert-info alert-tool">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h3>เครื่องมือสำหรับครีเอเตอร์</h3>
                <p>คุณเป็นเจ้าของโปรไฟล์นี้ คุณสามารถแก้ไขโปรไฟล์ด้วยเครื่องมือเหล่านี้</p>
                <br>
                <a href="{{ action('AssociateController@getProfileSetting') }}" class="btn btn-default btn-bright">
                    <i class="fa fa-pencil"></i> แก้ไขโปรไฟล์
                </a>
            </div>
        @endif       
    @endif
    <div class="row">
        <div class="col-sm-10">            
            <h2>
            	<div class="profile-circle">
                    <span class="profile-image"
                          style="background-image:url('{{ asset($creator->avatar) }}')"></span>
                </div>
                <span><strong>{{ is_null($creator->username) ? $creator->full_name : $creator->username }}</strong></span> 
            </h2>
        </div>
        <div class="col-sm-2">
            <h2>


                @if(\Auth::user()->check())
                    @if(\Auth::user()->user()->id != $creator->id)
                        
                        @if(\Auth::user()->user()->isSubscribed($creator->id))
                            <button class="follow-btn btn btn-success "
                                    data-user-id="{{ $creator->id }}"
                                    data-subscriber-id="{{ \Auth::user()->user()->id }}">
                                <i class="fa fa-check-circle"></i>
                                Following
                            </button>
                        @else
                            <button class="follow-btn btn btn-default"
                                    data-user-id="{{ $creator->id }}"
                                    data-subscriber-id="{{ \Auth::user()->user()->id }}">
                                <i class="fa fa-plus-circle"></i>
                                Follow
                            </button>
                        @endif
                    @endif
                @else
                    <button class="follow-btn btn btn-default" data-toggle="modal" href="#modal-login"><i
                                class="fa fa-plus-circle"></i> Follow
                    </button>
                @endif

            </h2>
        </div>
    </div>
    <hr>
    <div class="row">
        @foreach($campaigns as $campaign)
            <div class="col-md-3 col-sm-3 col-xs-6">
                @include('layouts.include.product-box', array('campaign'=>$campaign))
            </div>
        @endforeach
    </div>

@stop
