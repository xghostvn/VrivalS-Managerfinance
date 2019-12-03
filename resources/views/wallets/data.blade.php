
<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">Type</th>
        <th scope="col">Total</th>
        <th scope="col">Description</th>
        <th scope="col">Time</th>
    </tr>
    </thead>
    <tbody>
@foreach($transactions as $transaction)
    <tr>
        <th scope="col">{{$transaction->type}}</th>
        <th scope="col">{{\App\Http\Controllers\helperController::formatMoney($transaction->amount)}}</th>
        <th scope="col">{{$transaction->description}}</th>
        <th scope="col">{{$transaction->created_at}}</th>
    </tr>
    @endforeach
    </tbody>
    </table>

{{$transactions->links()}}
