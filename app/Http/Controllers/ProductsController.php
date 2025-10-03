<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * عرض المنتجات للمستخدم العادي
     */
    // $products = Product::orderBy('price', 'asc')->get();
    public function index(Request $request)
{
   $sort = $request->get('sort', 'price_desc');

    $query = Products::query();

    switch ($sort) {
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;
        case 'category_asc':
            $query->orderBy('category', 'asc');
            break;
        case 'category_desc':
            $query->orderBy('category', 'desc');
            break;
        default:
            $query->orderBy('price', 'desc');
    }

    $products = $query->paginate(3);

    return view('products.products', compact('products'));
}

    /**
     * عرض المنتجات في لوحة الأدمن
     */
    public function adminIndex()
    {
      $products = Products::all();
        if (auth()->user()->email !== 'menabasem66@gmail.com') {
            abort(403, 'Unauthorized');
        }
        return view('admin.products.dashboard', compact('products'));
    }

    /**
     * صفحة إضافة منتج جديد (أدمن)
     */
    public function create()
    {
            if (auth()->user()->email !== 'menabasem66@gmail.com') {
            abort(403, 'Unauthorized');
        }
        return view('admin.products.create');
    }

    /**
     * حفظ المنتج الجديد (أدمن)
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'details'     => 'nullable|string',
            'price'       => 'required|numeric',
            'brand'       => 'nullable|string',
            'category'    => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Products::create($validated);

        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * صفحة تعديل منتج (أدمن)
     */
    public function edit($id)
    {
        if (auth()->user()->email !== 'menabasem66@gmail.com') {
            abort(403, 'Unauthorized');
        }
        $product = Products::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * تحديث المنتج (أدمن)
     */
    public function update(Request $request, $id)
    {
       $product = Products::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'details'     => 'nullable|string',
            'price'       => 'required|numeric',
            'brand'       => 'nullable|string',
            'category'    => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.edit', $id)->with('success', 'تم تحديث المنتج بنجاح');
    }

    /**
     * حذف المنتج (أدمن)
     */

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'تم حذف المنتج بنجاح');
    }

    /**
     * صفحة تفاصيل منتج (للمستخدم العادي)
     */
    public function details($id)
    {
        $product = Products::findOrFail($id);
        return view('products.details', compact('product'));
    }

    /**
     * صفحة Contact Us
     */
    public function contactus()
    {
        return view('products.contactus');
    }
   /**
 * دالة لإضافة المنتج المختار إلى السلة (Session)
 */
public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    $productId = $request->input('product_id');
    $quantity  = $request->input('quantity', 1); // لو مش مبعوتة نخليها 1 افتراضي
    $product   = Products::find($productId);

    $cart = session()->get('cart', []);

    // لو المنتج موجود بالفعل نزود الكمية
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        // لو المنتج جديد نضيفه
        $cart[$productId] = [
            "name"     => $product->name,
            "quantity" => (int)$quantity,
            "price"    => $product->price,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->route('cart.show')->with('success', 'تم إضافة المنتج إلى السلة بنجاح!');
}

/**
 * دالة لعرض صفحة السلة بكل محتوياتها
 */
public function showCart()
{
    $cart = session()->get('cart', []);
    $cartTotal = 0;
    foreach ($cart as $item) {
        $cartTotal += $item['price'] * $item['quantity'];
    }

    return view('products.cart', compact('cart', 'cartTotal'));
}

/**
 * دالة لحذف منتج من السلة
 */
public function removeFromCart($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'تم حذف المنتج من السلة بنجاح.');
}

}
