@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Wallet') }}</div>

                    <div class="card-body">
                        @if ($create)
                            <form method="POST" action="{{ route('wallet.create') }}">
                                @csrf
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Create new Wallet') }}
                                        </button>
                            </form>
                        @else
                            <div style="margin-bottom: 20px">
                                Total Money : {{$money}}
                            </div>
                            <div id="page-content-wrapper">

                                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">

                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav">
                                            <li class="nav-item ">
                                                <a class="nav-link" href="{{route('transfer.request')}}">Transfer <span class="sr-only">(current)</span></a>
                                            </li>
                                            @if (Auth::user()->role)
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{route('transfer.more_revenue')}}">Revenue</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{route('transfer.more_expenses')}}">Expenses</a>
                                                </li>
                                            @endif

                                            <li class="nav-item">
                                                <form action="{{route('wallet.delete')}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-light">Delete wallet</button>
                                                </form>

                                            </li>

                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        <div style="margin-top: 20px">

                            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

                                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{route('wallet.request')}}">All <span class="sr-only">(current)</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" id="Revenue" >Revenue</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="#" id="Expenses" tabindex="-1" >Expenses</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="Export" href="{{route('wallet.export')}}" >Export</a>
                                        </li>
                                        <li class="nav-item">
                                            <form method="POST" action="#">
                                                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                                @csrf
                                                    <li class="nav-item">
                                                <div class="form-group row">
                                                    <label for="from" class="col-md-4 col-form-label text-md-right" style="color: white">{{ __('From') }}</label>

                                                    <div class="col-md-8">
                                                        <input id="from" type="date" class="form-control @error('from') is-invalid @enderror" name="from" required >
                                                        @error('from')
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                    </li>

                                                    <li class="nav-item">
                                                        <div class="form-group row">
                                                            <label for="To" class="col-md-4 col-form-label text-md-right" style="color: white">{{ __('To') }}</label>

                                                            <div class="col-md-8">
                                                                <input id="To"  type="date" class="form-control @error('To') is-invalid @enderror" name="To" required >
                                                                @error('To')
                                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nav-item">
                                                    <div class="form-group row mb-0">
                                                    <div class="col-md-8 offset-md-4">
                                                        <button type="submit" class="btn btn-primary" id="Execute-date">
                                                            {{ __('Execute') }}
                                                        </button>
                                                    </div>
                                                    </div>
                                                    </li>
                                                </ul>
                                            </form>
                                        </li>
                                    </ul>

                                </div>
                            </nav>
                <div id="abc">

                </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(window).bind("load", function () {
            $.get('data', function (data,status) {
                $('#abc').html(data);
            });
        });
        $("#Revenue").on("click", function () {

            $.get('data/Revenue', function (data,status) {
                $('#abc').html(data);
            });
        });
        $("#Expenses").on("click", function () {
            $.get('data/Expenses', function (data,status) {
                $('#abc').html(data);
            });

        });

        $("#Execute-date").on("click", function (e) {
            e.preventDefault();
            var from = new Date($('#from').val());
            var to = new Date($('#To').val());
            $.get('data/date', {
                to:getDate(to),
                from:getDate(from)
                },
                function (data,status) {
                $('#abc').html(data);
            });

        });

        function getDate(date) {
           var day = date.getDate();
           var month = date.getMonth() + 1;
           var year = date.getFullYear();
           return year+"-"+month+"-"+day;
        }




    });


</script>
