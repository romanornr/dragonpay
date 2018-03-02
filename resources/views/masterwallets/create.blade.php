@extends('layouts.app')
@section('content')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Create a new Master Wallet</h2>
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

            @if(empty(Auth::user()->stores[0]))
                <p>Please create a store first so you can attach a master key to a store.</p>
                <a class="btn btn-success" href="{{ route('stores.create') }}" role="button">Create a masterwallet</a>
            @else
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{url('masterwallets')}}" method="post">
                        {{ csrf_field()}}
                        {{ method_field("POST")}}

                        <div class="form-group">
                            <label class="control-label" for="store_id">Store</label>*
                            <select id="inputState" name="store_id" class="form-control">
                                @foreach(Auth::user()->stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="cryptocurrency">Cryptocurrency</label>*
                            <select id="inputState" name="cryptocurrency_id" class="form-control">
                                @foreach($cryptocurrencies as $cryptocurrency)
                                    <option value="{{ $cryptocurrency->id }}">{{ $cryptocurrency->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="address_type">Address type</label>*
                            <select id="inputState" name="address_type" class="form-control">
                                <option value="segwit" selected>Segwit</option>
                                <option value="legacy">Legacy</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="master_public_key">Master public key</label>*
                            <input class="form-control" type="text" data-val="true" id="master_public_key" name="master_public_key"/>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Create" class="btn btn-success" />
                        </div>

                        <a href="/">Back</a>
                </div>
            </div>
        </div>
        @endif
    </section>

@endsection