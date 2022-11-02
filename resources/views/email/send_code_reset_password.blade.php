@component('mail::message')
<img style="width:150px;margin:auto" src="{{asset('/storage/images/titleWord.png') }}" alt="">
<h1>重新設定密碼</h1>
<p>您好，我們收到了您要重新設定密碼的消息～</p>
<p>您的驗證碼為：</p>

@component('mail::panel')
{{ $code }}
@endcomponent

<p>請在裝置上輸入驗證碼進行設定密碼</p>
<p>祝一切順心！<br>玩食部落團隊敬上</p>
@endcomponent
