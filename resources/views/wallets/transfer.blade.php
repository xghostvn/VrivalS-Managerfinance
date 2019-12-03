@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Transfer') }}</div>

                    <div class="card-body">

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

                        <form method="POST" action="{{ route('transfer.update') }}">
                            @csrf



                            <div class="form-group row">
                                <label for="money" class="col-md-4 col-form-label text-md-right">{{ __('Money') }}</label>

                                <div class="col-md-6">
                                    <input id="money" type="text" class="form-control @error('money') is-invalid @enderror" name="money" required >

                                    @error('money')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="users" class="col-md-4 col-form-label text-md-right">{{ __('User') }}</label>

                                <div class="col-md-6">
                                    <select class="browser-default custom-select" name="users" id="users">


                                            @foreach($wallets as $wallet)
                                                @if($wallet->user->id != Auth::id())
                                                <option value="{{$wallet->user->id}}">{{$wallet->user->name}}</option>
                                                    @endif

                                            @endforeach


                                    </select>

                                    @error('users')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Transfer') }}
                                    </button>
                                </div>
                            </div>
                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
