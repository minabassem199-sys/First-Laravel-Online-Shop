@extends('layouts.app')

@section('content')
<div class="container">
    <h2>طلباتي</h2>
    <table class="table">
        <thead>
            <tr>
                <th>رقم الطلب</th>
                <th>الإجمالي</th>
                <th>طريقة الدفع</th>
                <th>الحالة</th>
                <th>تاريخ الإنشاء</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->total }} جنيه</td>
                <td>{{ $order->payment_method }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
