<div width="100%" style="background:#f5f7f7;padding:20px 0 20px 0;">
    <table border="0" cellspacing="0" cellpadding="0" width="790px" 
        style="min-width:790px;margin:0 auto;">
        <tbody>
            @include('backend.layouts.include.email-head')
            <tr>
                <td width="100%" height="300px" 
        style="background:#fff;padding:30px 35px;vertical-align: top;">
                    @yield('content')
                </td>
            </tr>
            <tr style="margin:15px 0 0 0">
                <td>
                    @include('backend.layouts.include.email-footer')
                </td>                
            </tr>
        </tbody>
    </table>
</div>