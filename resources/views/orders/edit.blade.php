<!doctype html>
<html lang="en">

<head>
    <title>Payment</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link href="{{ asset('css/invoice.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
</head>

<body>
<nav class="navbar navbar-light bg-light">
    <a class="payment-text">Waiting for payment <div class="payment-time"></div></a>
    <a href="#" class="btn btn-secondary btn-cancel" role="button">Cancel</a>

</nav>
<br>
<div class="container">
    @foreach($masterwallets as $masterwallet)
    <form action="{{ action('OrderController@update') }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field()}}


        <input type="hidden" class="form-control" name="cryptocurrency_id" value="{{ $masterwallet->cryptocurrency_id }}">
        <input type="hidden" class="form-control" name="uuid" value="{{ $invoice->uuid_text }}">

        <div class="form-group">
            <input type="submit" value="{{ $masterwallet->cryptocurrency->name }}" class="btn btn-success" />
        </div>
    </form>
    @endforeach

</div>

