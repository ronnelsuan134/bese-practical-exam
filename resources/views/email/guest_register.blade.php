@component('mail::message')
# Hi {{ $data['data']['name']. ' '.$data['data']['lastname'] }},

The school <strong>Multisys</strong> has invited you to be one of their employee!<br>
<p>{{ $data['msg'] }}</p>

@component('mail::button', ['url' => $data['url']])
CLICK ME
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent