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

            <form action="/search" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="q" autocomplete="off"
                           placeholder="Search invoice on UUID"> <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning">
                            <span class="glyphicon glyphicon-search">Search</span>
                        </button>
                    </span>
                </div>
            </form><br>

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
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->created_at }}</td>
                        <td>{{ $invoice->store->name }}</td>
                        <td>{{ $invoice->order_id }}</td>
                        <td>{{ $invoice->uuid_text }}</td>
                        <td> {{ $invoice->price }} {{ $invoice->currency }}</td>
                        <td> {{ $invoice->status }}</td>
                        <td> Show/<a href="{{ url("invoice/uuid={$invoice->uuid_text}/edit")}}">Checkout</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $invoices->links() }}

        </div>
    </section>
    @endsection