@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">{{ __('My profile') }}</div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('public.profile', $firm->slug) }}" target="_blank">{{ __('Public profile') }}</a>
                            </div>
                        </div>
                    </div>

                    <div id="app">
                        <firm-profile/>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
