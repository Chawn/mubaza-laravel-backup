@extends('user.layouts.full-width')
@section('css')
<style>

#menu-follow {
	height: 80px;
}
#menu-follow{
	display: block;
}
#mobile-menu-follow {
	display: none;
}
@media (max-width: 480px){
	#user-header #about #u-favorite{
		display: none;
	}
	#menu-follow{
		display: none;
	}
	#mobile-menu-follow {
		display: block;
		text-align: center;
	}
}
</style>
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function()
	{
		$(".box-follow").each(function(k){
			if (k%2==0) {
				$(this).addClass("bg-f1");
			};
		});
	});
</script>
@stop
@section('content')
<div class="row-fluid">
    @forelse($followers as $follower)
    <div class="col-md-4 col-sm-6 col-xs-12">
		<div class="box-follow media" onclick="location.href='{{ action('UserController@getIndex', $follower->follower->getID()) }}';"><!--link to user-profile-->
			<div class="media-left">
				<div class="box-img-circle">
					<img src="{{ $follower->follower->avatar }}">
				</div>
			</div>
			<div class="media-body">
				<a class="user-name" href="{{ action('UserController@getIndex', $follower->follower->getID()) }}">{{ $follower->follower->option->show_full_name ? $follower->follower->full_name : $follower->follower->username }}</a><!--link to user-profile-->
				<p class="user-detail">{{ $follower->follower->detail }}</p>
				<a href="#"><i class="fa fa-star star"></i>{{ count($follower->follower->followers) }}</a><!--link to user-follow-->
			</div>
		</div>
	</div>
        @empty
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert text-center" role="alert">ยังไม่มีผู้ติดตามในขณะนี้</div>
        </div>
    @endforelse
</div>
<div class="row-fluid">
		<div class="col-md-12">
			<nav class="pull-right">
                {!! str_replace('/?', '?', $followers->render()) !!}
			</nav>
		</div>
	</div>
@stop