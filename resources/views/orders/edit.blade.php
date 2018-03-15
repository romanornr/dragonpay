<!doctype html>
<html lang="en">

<head>
    <title>Payment</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card payment-card">
                <div class="card-block">

                    <div class="payment-logo">
                    </div>
                    <div class="payment-info">
                        <div class="card-title payment-title">Choose cryptocurrency: </div>
                        <div class="payment-price">{{ $invoice->price }} {{ $invoice->currency }}</div>
                        <p class="text-muted ordernumber">Order UUID: {{ $invoice->uuid_text  }}</p>
                    </div>
                    <div class="payment-section">
                        <a class="payment-info-text">
                            To complete your payment, please choose one of the following cryptocurrency options.</a><br></br>

    @foreach($masterwallets as $masterwallet)
    <form action="{{ action('OrderController@update') }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field()}}


        <input type="hidden" class="form-control" name="cryptocurrency_id" value="{{ $masterwallet->cryptocurrency_id }}">
        <input type="hidden" class="form-control" name="uuid" value="{{ $invoice->uuid_text }}">

        <div class="form-group">
            <input type="submit" value="{{ $masterwallet->cryptocurrency->name }}" class="btn btn-outline-dark" />
        </div>
    </form>
    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>

