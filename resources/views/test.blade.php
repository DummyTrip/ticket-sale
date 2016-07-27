admin {{ $isAdmin }} <br>
manager {{ $isManager }} <br>
organizer {{ $isOrganizer }} <br>
<br>

{{ $role }}


<br>

abe {{ array_key_exists('make-admin', $da) ? 'da' : 'ne' }}

<br>
<br>

@foreach($da as $r => $o)
    {{ $r.' '.$o }}<br>
@endforeach

