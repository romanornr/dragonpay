@extends('layouts.app')
@section('content')

    <section>
        <div class="container">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Stores</h2>
                    <hr class="primary">
                    <p>Create and manage store settings.</p>
                </div>
            </div>


            <a class="btn btn-success" role="button" href="{{ route('stores.create') }}"><span class="glyphicon glyphicon-plus"></span> Create a new store</a>
            <br></br>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">name</th>
                    <th scope="col">website</th>
                    <th scope="col">balances</th>
                    <th scope="col">actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->stores as $store)
                <tr>
                    <th scope="row">{{ $store->name }}</th>
                    <td>{{ $store->website }}</td>
                    <td></td>
                    <td>Show / Edit / Remove</td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </section>

@endsection