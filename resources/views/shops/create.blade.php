@extends('layouts.app')
@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Create a new shop</h2>
                <hr class="primary">
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



        <div class="row">
            <div class="col-lg-12">
                <form action="{{url('shops')}}" method="post">
                    {{ csrf_field()}}
                    {{ method_field("POST")}}
                    <div class="form-group">
                        <label class="control-label" for="Name">Shop name</label>*
                        <input class="form-control" type="text" data-val="true" id="name" name="name" required="true" autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="Name">website</label>*
                        <input class="form-control" type="text" data-val="true" id="website" name="website" required="true" autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="Name">Invoice expiration time after x minutes</label>*
                        <input class="form-control" type="number" data-val="true" id="expiration" name="expiration_time" value="120" min="30" max="255"/>
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