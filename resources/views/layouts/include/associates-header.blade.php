<div id="asc-nav">
	<div class="container">
		<div class="logo">
			<a href="{{ action('AssociateController@getIndex') }}" title="">
                <img id="mubaza-logo" class="img-logo" src="{{ asset('images/logo-short.jpg') }}">
                <img class="img-logo" src="{{ asset('images/associate_w.png') }}" alt="">
            </a>
		</div>
		<button type="button" class="btn btn-white border navbar-toggle collapsed" data-toggle="modal" data-target="#modal-asc-login" aria-expanded="false">
				<i class="fa fa-bars"></i>
			</button>
		<div class="nav-menu">
			
			<form id="asssociate-login-collapse" class="form-inline collapse navbar-collapse">
				<div class="form-group">
				<label class="sr-only" for="username">Username</label>
					<input type="text" class="form-control" id="username" placeholder="Username">
				</div>
				<div class="form-group">
					<label class="sr-only" for="password">Password</label>
					<input type="password" class="form-control" id="password" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-blue">เข้าสู่ระบบ</button>
			</form>
		</div>
	</div>
</div>

<div id="modal-asc-login" class="modal modal-square fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>เข้าสูระบบ Associates</h3>                
            </div>
            <div class="modal-body">
                <div class="box box-border">
                    <form action="">
                        <div class="form-group">
                            <label for="input-name">User name</label>
                              <input type="text" class="form-control" id="input-name">
                        </div>
                        <div class="form-group">
                            <label for="password">รหัสผ่าน</label>
                              <input type="password" class="form-control" id="password">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            	<button class="btn btn-blue">เข้าสู่ระบบ</button>
            </div>
        </div>
    </div>
</div>