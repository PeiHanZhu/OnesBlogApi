@component('mail::message')
<h1>歡迎加入玩食部落！</h1>
<p>您好，您的驗證碼為：</p>

@component('mail::panel')
{{ $code }}
@endcomponent

<p>請在裝置上輸入驗證碼進行註冊</p>
<p>祝一切順心！<br>玩食部落團隊敬上</p>
@endcomponent
