@extends('user.layouts.full-width')
@section('css')
<style>

#menu-follow {
    height: 80px;
}
#menu-follow{
    padding-top: 15px;
    font-size: 12px;
}
#mobile-menu-follow {
display: none;
}
.media{
    padding: 10px;
    border: 1px solid #DCE0E0;
    border-radius: 4px;
}
.btn-follower:hover{
    cursor: default;
    text-decoration: none;
}
@media (max-width: 480px){
    #user-header #about #u-buy{
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
    <div class="row">
        @forelse($followers as $follower)
            <div class="col-md-3 col-sm-4 col-xs-6 space-lg-3">
                <div class="box-follow text-center"><!--link to user-profile-->
                        <div class="box-img-circle">
                            <a class="user-name" href="{{ action('UserController@getCreatorShow',$follower->getID()) }}">
                                <span class="profile-circle profile-circle-xl" >
                                    <span class="profile-image"
                                          style="background-image:url('{{ asset($follower->avatar) }}')"></span>
                                </span>
                            </a>
                            
                        </div>
                        <p>
                            <a class="user-name" href="{{ action('UserController@getCreatorShow',$follower->getID()) }}">
                                <strong>
                                    {{ $follower->option->show_full_name ? $follower->full_name : $follower->username }}
                                </strong>
                            </a>
                            <br>
                            <small>
                                    ผู้ติดตาม {{ count($follower->followers) }}
                            </small>
                        </p>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert text-center" role="alert">คุณยังไม่ได้ติดตามใครเลย</div>
            </div>
        @endforelse
    </div>
    <div class="row">
        <div class="col-md-12">
            <nav class="pull-right">
                {!! str_replace('/?', '?', $followers->render()) !!}
            </nav>
        </div>
    </div>
@stop