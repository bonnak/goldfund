<p>Dear {{ $first_name }},</p>
<p>
Click link below to verify your account.<br>
<a href="{{ url('customer/activation/' . $verified_token) }}">{{ url('customer/activation/' . $verified_token) }}</a><br>
</p>
<p>
Regard,<br>
Gold Trading Fund
</p>