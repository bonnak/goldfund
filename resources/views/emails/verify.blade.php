<span>Dear {{ $full_name}},</span>
<p>
You are successfully registered with {{ config('app.name')}}.<br>
We welcome you to our Family, we hope you will have very good experience working with our company.<br> 
Please find below your login details:<br>
</p>
<p>
Member ID : {{ $id }}<br>
User Name : {{ $username }}<br>
Login Password : {{ $password }}<br>
Transaction Password : {{ $trans_password }}<br>
Sponsor Name: {{ $sponsor_name }}<br> 
</p>
<p>
Click link below to verify your account.<br>
<a href="{{ url('customer/activation/' . $verified_token) }}">{{ url('customer/activation/' . $verified_token) }}</a><br>
</p>
<p>
Regards<br>
{{ config('app.name')}}<br>
<a href="www.bitcompanytrading.com">www.bitcompanytrading.com</a><br>
</p>
<img src="{{ url('/images/logo.png') }}">