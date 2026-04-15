<?php

namespace App\Http\Controllers;

use App\Models\RiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['orderItems.riceItem', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create(): View
    {
        $menus = RiceItem::available()->orderBy('name')->get();

        return view('orders.create', compact('menus'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'menu_id' => 'required|exists:rice_items,id',
            'quantity' => 'required|numeric|min:0.01',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:25',
            'customer_address' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $menu = RiceItem::findOrFail($data['menu_id']);

        if (! $menu->isInStock() || $data['quantity'] > $menu->stock_quantity) {
            return back()
                ->withErrors(['quantity' => 'Requested quantity exceeds available stock.'])
                ->withInput();
        }

        $subtotal = $menu->price_per_kg * $data['quantity'];

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address'],
            'total_amount' => $subtotal,
            'status' => 'pending',
            'notes' => $data['notes'],
        ]);

        $order->orderItems()->create([
            'rice_item_id' => $menu->id,
            'quantity_kg' => $data['quantity'],
            'price_per_kg' => $menu->price_per_kg,
            'subtotal' => $subtotal,
        ]);

        $menu->reduceStock($data['quantity']);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order): View
    {
        $order->load(['orderItems.riceItem', 'payment']);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        $order->load(['orderItems.riceItem', 'payment']);

        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:25',
            'customer_address' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order->update($data);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
