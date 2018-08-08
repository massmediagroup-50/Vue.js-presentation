@extends('layouts.app')
@section('content')

    <div class="container">
        <a href="{{ url('/') }}" class="btn">{{ __('Home') }}</a>
        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h1>{{ $firm->name }}</h1>
                            </div>
                        </div>

                        @if ($firm->description)
                            <hr>
                            <h6>{{ __('Description') }}</h6>
                            <p>{{ $firm->description }}</p>
                            <hr>
                        @endif

                        @if ($firm->contacts && $firm->contacts->count())
                            @include('pages.partials.contacts')
                        @endif

                        @if ($firm->addresses && $firm->addresses->count())
                            @include('pages.partials.addresses')
                        @endif

                        @if($firm->employees && $firm->employees->count())
                            @include('pages.partials.employees')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
