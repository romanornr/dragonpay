@extends('layouts.app')
@section('content')

    <section>
        <div class="container">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Shops</h2>
                    <hr class="primary">
                    <p>Create and manage store settings.</p>
                </div>
            </div>


            <a class="btn btn-success" role="button" href="{{ route('shops.create') }}"><span class="glyphicon glyphicon-plus"></span> Create a new shop</a>
            <br></br>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">website</th>
                    <th scope="col">balances</th>
                    <th scope="col">actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->stores as $store)
                <tr>
                    <th scope="col">{{ $store->id }}</th>
                    <th scope="row">{{ $store->name }}</th>
                    <td>{{ $store->website }}</td>
                    <td></td>
                    <td>
                        <form onsubmit="return confirm('Do you really want to delete this store?'); "action="{{url('shops', [$store->id])}}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger" value="Delete"/>
                        </form>

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </section>

@endsection