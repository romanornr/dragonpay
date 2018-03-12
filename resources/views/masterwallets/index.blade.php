@extends('layouts.app')
@section('content')
    @include('modals.delete')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <section>
        <div class="container">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Masterwallets</h2>
                    <hr class="primary">
                    <p>create & manage masterwallets</p>
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

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
                    <th scope="col">delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->masterwallets as $masterwallet)
                <tr>
                    <td> {{ $masterwallet->stores->name }}</td>
                    <td>{{ $masterwallet->cryptocurrency->name }}</td>
                    <td> {{ substr($masterwallet->master_public_key, 0, 14) }}...{{ substr($masterwallet->master_public_key, -14) }}</td>
                    <td> {{ $masterwallet->address_type }}</td>
                    <td> {{ $masterwallet->created_at }}</td>
                    <td>
                        <form action="{{url('masterwallets', [$masterwallet->id])}}" method="POST">
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

