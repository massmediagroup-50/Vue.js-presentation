<h6>{{ __('Addresses') }}</h6>

<ul class="list-unstyled">
@foreach($firm->addresses as $address)
    <li>
        @if ($loop->first)
            <strong>{{ formatAddress($address) }}</strong>
        @else
            {{ formatAddress($address) }}
        @endif
    </li>
@endforeach
</ul>
