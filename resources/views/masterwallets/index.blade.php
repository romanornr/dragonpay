@extends('layouts.app')
@section('content')

    <section>
        <div class="container">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Masterwallets</h2>
                    <hr class="primary">
                    <p>create & manage masterwallets</p>
                </div>
            </div>

        <a class="btn btn-success" role="button" href="{{ route('masterwallets.create') }}"><span class="glyphicon glyphicon-plus"></span> Create a new store</a>
            <br></br>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">store</th>
                    <th scope="col">cryptocurrency</th>
                    <th scope="col">master public key</th>
                    <th scope="col">address type</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->masterwallets as $masterwallet)
                <tr>
                    <th> {{ $masterwallet->store_id }}</th>
                    <th>{{ $masterwallet->crytocurrency }}</th>
                    <th> {{ substr($masterwallet->master_public_key, 0, 14) }}...{{ substr($masterwallet->master_public_key, -14) }}</th>
                    <th> {{ $masterwallet->address_type }}</th>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @endsection

