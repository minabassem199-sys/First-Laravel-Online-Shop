<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // إنشاء طلب جديد
    public function store(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:1',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'payment_method' => 'cash_on_delivery',
            'total' => $request->total,
        ]);
        return redirect()->route('orders.my')->with('success', 'تم إنشاء الطلب بنجاح!');
        // return redirect()->back()->with('success', 'تم إنشاء الطلب بنجاح!');
    }

    // عرض طلبات المستخدم الحالي
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.my_orders', compact('orders'));
    }
}
