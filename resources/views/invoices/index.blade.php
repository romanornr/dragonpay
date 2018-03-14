@extends('layouts.app')
@section('content')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Invoices</h2>
                    <hr class="primary">
                    <p>Create and manage invoices.</p>
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{--@foreach($users as $key => $user)--}}
                {{--<p>{{ $user->invoices[$key]->created_at  }}</p>--}}

                {{--@endforeach--}}

            <a class="btn btn-success" role="button" href="{{ route('invoices.create') }}"><span class="glyphicon glyphicon-plus"></span> Create invoice</a>
            <br></br>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Created</th>
                    <th scope="col">Store</th>
                    <th scope="col">order id</th>
                    <th scope="col">invoice id</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $user->invoices[$key]->created_at }}</td>
                        <td>{{ $user->stores[$key]->name }}</td>
                        <td>{{ $user->invoices[$key]->order_id }}</td>
                        <td>{{ $user->invoices[$key]->uuid_text }}</td>
                        <td> {{ $user->invoices[$key]->price }} {{ $user->invoices[$key]->currency }}</td>
                        <td> {{ $user->invoices[$key]->status }}</td>
                        <td> Show/Edit/ <a href="{{ url("invoice/uuid={$user->invoices[$key]->uuid_text}")}}">Checkout</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </section>
    @endsection