<body style="background:#f5f7f7;padding:20px 0 20px 0;font-size:14px;">
    <table border="0" cellspacing="0" cellpadding="0" width="790px" 
        style="min-width:790px;margin:0 auto; box-shadow: 0px 0px 5px rgba(133, 141, 155, 0.65);border-radius:4px;">
        <tbody>
            <tr>
                <td width="100%" height="300px" 
        style="background:#fff;padding:20px 0px;vertical-align: top;">
                    @yield('content')
                </td>
            </tr>
            <tr style="margin:15px 0 0 0">
                <td>
                   @include('mail.layouts.include.mail-footer') 
                </td>                
            </tr>
        </tbody>
    </table>
</body>