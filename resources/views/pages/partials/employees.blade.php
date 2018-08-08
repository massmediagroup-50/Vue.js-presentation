<h6>{{ __('Employees') }}</h6>

<ul class="list-unstyled">
@foreach($firm->employees as $employee)
    <li>
        {{ $employee->name }}
    </li>
@endforeach
</ul>