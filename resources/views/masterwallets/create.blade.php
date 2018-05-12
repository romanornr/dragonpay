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
                <p>Please create a shop first so you can attach a master key to a shop.</p>
                <a class="btn btn-success" href="{{ route('shops') }}" role="button">Create a new shop</a>
            @else
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{url('masterwallets')}}" method="post">
                        {{ csrf_field()}}
                        {{ method_field("POST")}}

                        <div class="form-group">
                            <label class="control-label" for="store_id">Shop</label>*
                            <select id="inputState" name="store_id" class="form-control">
                                @foreach(Auth::user()->stores as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->name  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="cryptocurrency">Cryptocurrency</label>*
                            <select id="inputStateCryptocurrency" name="cryptocurrency_id" class="form-control">
                                @foreach($cryptocurrencies as $cryptocurrency)
                                    <option value="{{ $cryptocurrency->id }}">{{ $cryptocurrency->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="address_type">Address type</label>*
                            <select id="inputStateType" name="address_type" class="form-control">
                                <option value="segwit" selected>Segwit</option>
                                <option value="legacy">Legacy</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="master_public_key">Master public key</label>*
                            <input class="form-control" type="text" data-val="true" id="master_public_key" name="master_public_key" placeholder="example: xpub6BjNvqkdh5KB4XqdfKX6dznEV9vwiYbmBxZdFzB1CqVBK3svk3Xw8x5pMznhFoAQSrBGgaoX5cdw6BCBgLqSyqTAWMeWAW8PYiuvzp9Jy8r"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="min_confirmations">The invoice is confirmed when the payment transaction</label>*
                            <select id="inputState" name="min_confirmations" class="form-control">
                                <option value="0" selected>is unconfirmed</option>
                                <option value="1">1 confirmation</option>
                                <option value="3">3 confirmations</option>
                                <option value="6">6 confirmations</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="submit" id="submit" value="Create" class="btn btn-success" />
                        </div>
                </div>
                <button class="btn btn-danger" onclick="checkMasterPublicKey()">Check master public child keys first!</button>
            </div>
                <div id="keys"></div><br>
        </div>

        <script>
            document.getElementById("submit").disabled = true;


            function checkMasterPublicKey() {
                var cryptocurrency = document.getElementById("inputStateCryptocurrency").selectedOptions[0].innerText;
                var addressType = document.getElementById("inputStateType").selectedOptions[0].innerText.toLowerCase();
                var masterPublicKey = document.getElementById("master_public_key").value;

                var request = new XMLHttpRequest();

                    var url = '/api/masterwallet/' + cryptocurrency + '/' + addressType + '/' + masterPublicKey + '/'+'1';

                    request.addEventListener('load', onLoad);
                    request.open('GET', url);
                    request.send();

                    function onLoad() {
                        var response = this.responseText
                        var obj = JSON.parse(response)
                        console.log(obj)

                        var x;
                        for(x in obj){
                            var p = document.createElement("P"+x);
                            var txt = document.createTextNode(obj[x].keypath + ': ' + obj[x].address);
                            p.appendChild(document.createElement("br"));
                            p.appendChild(txt);
                          //  document.body.appendChild(p);
                            document.getElementById("keys").appendChild(p);
                            // document.getElementById("p11").innerHTML = obj[x].address
                        }
                        document.getElementById("submit").disabled = false;
                    }
            }
        </script>
        @endif
    </section>

@endsection
