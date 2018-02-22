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

            <div class="row">
                <div class="col-lg-12">
                    <form action="/settings/create" method="post">

                        <div class="form-group">
                            <label class="control-label" for="Name">Cryptocurrency</label>*
                            <select id="inputState" class="form-control">
                                @foreach($cryptocurrencies as $cryptocurrency)
                                    <option>{{ $cryptocurrency->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Name">The invoice is confirmed when the payment transaction</label>*
                            <select id="inputState" class="form-control">
                                <option selected>is unconfirmed</option>
                                <option>1 confirmation</option>
                                <option>3 confirmations</option>
                                <option>6 confirmations</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Name">Address type</label>*
                            <select id="inputState" class="form-control">
                                <option selected>Segwit</option>
                                <option>Legacy</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Name">Master public key</label>*
                            <input class="form-control" type="text" data-val="true" id="derivation_scheme" name="derivation_scheme"/>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Create" class="btn btn-success" />
                        </div>

                        <a href="/stores">Back to List</a>
                </div>
            </div>
        </div>
    </section>

@endsection
