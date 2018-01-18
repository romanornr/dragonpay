@extends('layouts.app')
@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Create a new store</h2>
                <hr class="primary">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="/stores/create" method="post">
                    
                    <div class="form-group">
                        <label class="control-label" for="Name">Name</label>*
                        <input class="form-control" type="text" data-val="true" id="name" name="name"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="Name">website</label>*
                        <input class="form-control" type="text" data-val="true" id="website" name="website"/>
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
                        <label class="control-label" for="Name">Derrivation scheme</label>*
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