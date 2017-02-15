<p>Dear {{ $first_name }},</p>
<p>
Click link below to verify your account.<br>
<a href="{{ url('customer/activation/' . $verified_token) }}">{{ url('customer/activation/' . $verified_token) }}</a><br>
</p>
<p>
Regard,<br>
Bit Company Trading<br>
<a href="www.bitcompanytrading.com">www.bitcompanytrading.com</a><br>
</p>