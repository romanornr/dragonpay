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
                        <div class="card-title payment-title">Payment: </div>
                        <div class="payment-price">{{ $invoice->price }} {{ $invoice->currency }}</div>
                        <p class="text-muted ordernumber">Order UUID: {{ $invoice->uuid_text  }}</p>
                    </div>
                    <div class="payment-section">
                        <a class="payment-info-text">
                            Do not pay this invoice from Coinbase wallet or a bitcoin exchange account. Exchanges and especially Coinbase do not broadcast the bitcoin payment in time, thus resulting in failure. Use the following bitcoin wallets instead: Trezor, Ledger, samouraiwallet, Copay, Electrum, Greenadress.
                        </a>
                        <div class="media">
                            <div class="media-left payment-qr">
                                <img class="media-object" src="{{$QRcode}}">
                            </div>
                            <div class="">

                                <script>new Clipboard('.btn');
                                    clipboard.on('success', function(e) {
                                        console.info('Action:', e.action);
                                        event.trigger.textContent = 'Copied';
                                        console.info('Text:', e.text);
                                        console.info('Trigger:', e.trigger);

                                        e.clearSelection();
                                    });
                                </script>

                                <input value="{{ $crypto_due }}" readonly/> {{ strtoupper($cryptocurrency->symbol) }}
                                <button class="btn" data-clipboard-text="{{ $crypto_due }}">
                                    copy
                                </button>

                                <input value="{{ $invoice->payment_address }}" readonly/>
                                <button class="btn" data-clipboard-text="{{ $invoice->payment_address }}">
                                    copy
                                </button>


                            </div>

                            <!--
          <div class="payment-qr">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png">
          </div>
          <div class="payment-details">
              Send <span class="payment-details-styled">0.02615909</span> bitcoin to this address <span class="payment-details-styled">16rCmCmbuWDhPjWTrpQGaU3EPdZF7MTdUk</span>
          </div>
-->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
                            <script>
                                socket = io.connect("https://blockexplorer.com/");
                                socket.on('connect', function() {
                                    socket.nsp = "/";
                                    socket.emit('subscribe', 'inv');
                                    socket.on('tx', function(tx) {
                                        console.log(tx.vout);
                                        for(i = 0; i < tx.vout.length; i++){
                                            console.log(tx.vout[i]);
                                        }
                                    });
                                });
                            </script>


                            <script>
                                var paymentAddress = {!! json_encode($invoice->paymentAddress) !!}
                                var orderPrice = {!! json_encode($crypto_due) !!}
                                var ws = new WebSocket("wss://socket.blockcypher.com/v1/btc/main");
                                var count = 0;
                                ws.onmessage = function (event) {
                                    var tx = JSON.parse(event.data);
                                    var shortHash = tx.hash.substring(0, 6) + "...";
                                    var total = tx.total / 100000000;
                                    var addrs = tx.addresses.join(", ");
                                    $('#browser-websocket').before("<div>Unconfirmed transaction " + shortHash + " totalling " + total + "BTC involving addresses " + addrs + "</div>");
                                    for(i = 0; i < tx.addresses.length; i++)
                                        if(tx.addresses[i] == paymentAddress){
                                            console.log("payment detected");
                                            console.log(tx.addresses[i]);
                                            console.log(tx);
                                            ws.close();
                                        }
                                }
                                ws.onopen = function(event) {
                                    ws.send(JSON.stringify({event: "unconfirmed-tx"}));
                                }
                            </script>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>

</html>