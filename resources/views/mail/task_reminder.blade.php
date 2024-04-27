<x-mail::message>
# Dear {{$user['name']}}

You have a upcoming task Tomorrow.Task id is {{$data['title']}}



Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
