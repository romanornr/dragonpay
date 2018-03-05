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

        <a class="btn btn-success" role="button" href="{{ route('masterwallets.create') }}"><span class="glyphicon glyphicon-plus"></span> Create a new masterwallet</a>
            <br></br>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">store</th>
                    <th scope="col">cryptocurrency</th>
                    <th scope="col">master public key</th>
                    <th scope="col">address type</th>
                    <th scope="col">created at</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->masterwallets as $masterwallet)
                <tr>
                    <td> {{ $masterwallet->stores->name }}</td>
                    <td>{{ $masterwallet->crytocurrency }}</td>
                    <td> {{ substr($masterwallet->master_public_key, 0, 14) }}...{{ substr($masterwallet->master_public_key, -14) }}</td>
                    <td> {{ $masterwallet->address_type }}</td>
                    <td> {{ $masterwallet->created_at }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @endsection

