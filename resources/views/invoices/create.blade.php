@extends('layouts.app')
@section('content')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="setion-heading">Create invoice</h2>
                    <hr class="primary">
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <div class="row">
            <div class="col-lg-12">
                <form action="{{url('invoices')}}" method="post">
                    {{ csrf_field()}}
                    {{ method_field("POST")}}

                    <div class="form-group">
                        <label class="control-label" for="price">price fiat</label>*
                        <input class="form-control" type="text" data-val="true" id="price" name="price" required="true" autocomplete="off"/>
                    </div>


                    <div class="form-group">
                        <label class="control-label" for="currency">currency</label>*
                        <select id="inputState" name="currency" class="form-control" required="true">
                            <option value="USD" selected>USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>

                    {{--<div class="form-group">--}}
                        {{--<label class="control-label" for="cryptocurrency_id">Cryptocurrency</label>*--}}
                        {{--<select id="inputState" name="cryptocurrency_id" class="form-control">--}}
                            {{--@foreach($cryptocurrencies as $cryptocurrency)--}}
                                {{--<option value="{{ $cryptocurrency->id }}">{{ $cryptocurrency->name  }}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <label class="control-label" for="order_id">order_id <br>(internal id from the merchant system. Direct match between the order_id and invoice_uuid)</label>*
                        <input class="form-control" type="text" data-val="true" id="order_id" name="order_id" autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="description">description</label>
                        <input class="form-control" type="text" data-val="true" id="description" name="description" autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="buyer_email">buyer email</label>
                        <input class="form-control" type="text" data-val="true" id="buyer_email" name="buyer_email" autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="notification_url">notification_url</label>
                        <input class="form-control" type="text" data-val="true" id="notification_url" name="notification_url" autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="store_id">Store</label>*
                        <select id="inputState" name="store_id" class="form-control" required="true">
                            @foreach(Auth::user()->stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name  }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Create" class="btn btn-success" />
                    </div>

                    <a href="/">Back</a>
            </div>
        </div>
        </div>
    </section>
    @endsection