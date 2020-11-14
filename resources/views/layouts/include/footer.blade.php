

<div id="footer-main">
    <div class="container" >
        <p class="copyright">
            สงวนลิขสิทธิ์ทุกประการ &copy; 2015 &middot; {{ config('profile.sitename') }}
        </p>
        <p>
            <a href="{{ url('help/terms') }}">
                เกี่ยวกับเรา
            </a>
            &middot;
            <a href="{{ url('help/terms') }}">
                {{ \Lang::get("messages.terms") }}
            </a>
        </p>
        <p class="customer-service clear">
            <b>ฝ่ายบริการลูกค้า</b>
            <span> จันทร์ - ศุกร์ เวลา 8.30-17.30 น. </span>
            <b>โทร.</b>
            <span class="call-to-contact">{{ config('profile.phone-primary') }}</span>
        </p>  
    </div><!-- end container FOOTER -->
    

</div><!-- end FOOTER -->