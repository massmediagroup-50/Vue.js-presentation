@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if($firms)
                        <ul>
                            @foreach($firms as $firm)
                                <li class="list-unstyled">
                                    <a href="{{ route('public.profile', $firm->slug) }}">{{ $firm->name }}</a>
                                </li>
                            @endforeach

                        </ul>

                    {{ $firms->links() }}

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
