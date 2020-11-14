<div id="modal-login" class="modal modal-mobile-full fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">เข้าสู่ระบบ</h4>
            </div>
            <div class="modal-body">
                <div id="login-wrapper">
                    <div class="social-auth-links text-center">
                        <div class="row">
                            <div class="col-sm-12">
                                <p>
                                    <a href="{{ action('UserController@getSocialLogin', 'facebook') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}{{ Request::has('key') ? '&key' . Request::input('key') : '' }}"
                                       class="btn btn-block btn-social btn-facebook btn-lg" id="facebook">
                                        <i class="fa fa-facebook"></i>
                                        เข้าสู่ระบบด้วย Facebook
                                    </a>
                                </p>
                            </div>
                            <div class="col-sm-12">
                                <p>
                                    <a href="{{ action('UserController@getSocialLogin', 'google') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}{{ Request::has('key') ? '&key' . Request::input('key') : '' }}"
                                       class="btn btn-block btn-social btn-google btn-lg" id="google">
                                        <i class="fa fa-google-plus fa-2x"></i>
                                        เข้าสู่ระบบด้วย Google
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-center">- หรือ - </h4>
                    <div id="login-row">
                        <form role="form" method="POST" action="{{ action('UserController@postLogin') }}"
                              id="form-login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group has-feedback">
                                <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                                       required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="รหัสผ่าน" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" id="btn-login" class="btn btn-success btn-block btn-lg">
                                        เข้าสู่ระบบ
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>
                                <a href="{{ url('user/forgot-password') }}" title="ลืมรหัสผ่าน" class="link-reset">
                                    ลืมรหัสผ่าน?
                                </a>
                            </p>
                            <p>
                                <a href="{{action('UserController@getSignup')}}" id="newsignup"
                                   class="link-reset">
                                    สมัครสมาชิกด้วยอีเมล
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
          </div>

    </div>
</div>