<h6>{{ __('Contacts') }}</h6>

<ul class="list-unstyled">
@foreach($firm->contacts as $contact)
    <li>
        {{ $contact->type }}:
        {{ $contact->value }}
    </li>
@endforeach
</ul>