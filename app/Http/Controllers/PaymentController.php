<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with('order')->orderBy('created_at', 'desc')->get();

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request): View
    {
        $orders = Order::with('payment')
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('created_at', 'desc')
            ->get();

        $selectedOrder = null;

        if ($request->filled('order_id')) {
            $selectedOrder = $orders->firstWhere('id', $request->order_id);
        }

        return view('payments.create', compact('orders', 'selectedOrder'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,gcash,bank_transfer,other',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order = Order::findOrFail($data['order_id']);

        if ($order->isPaid()) {
            return back()->withErrors(['order_id' => 'This order is already fully paid.'])->withInput();
        }

        $amountPaid = $data['amount_paid'];
        $change = max(0, $amountPaid - $order->total_amount);

        $status = 'unpaid';

        if ($amountPaid >= $order->total_amount && $order->total_amount > 0) {
            $status = 'paid';
        } elseif ($amountPaid > 0) {
            $status = 'partial';
        }

        $payment = Payment::create([
            'payment_number' => Payment::generatePaymentNumber(),
            'order_id' => $order->id,
            'amount_paid' => $amountPaid,
            'change_amount' => $change,
            'payment_method' => $data['payment_method'],
            'status' => $status,
            'reference_number' => $data['reference_number'],
            'notes' => $data['notes'],
            'paid_at' => $amountPaid > 0 ? now() : null,
        ]);

        if ($status === 'paid') {
            $order->update(['status' => 'completed']);
        } elseif ($status === 'partial') {
            $order->update(['status' => 'confirmed']);
        }

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment): View
    {
        $payment->load('order');

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment): View
    {
        $orders = Order::orderBy('order_number')->get();

        return view('payments.edit', compact('payment', 'orders'));
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,gcash,bank_transfer,other',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order = Order::findOrFail($data['order_id']);

        $amountPaid = $data['amount_paid'];
        $change = max(0, $amountPaid - $order->total_amount);

        $status = 'unpaid';

        if ($amountPaid >= $order->total_amount && $order->total_amount > 0) {
            $status = 'paid';
        } elseif ($amountPaid > 0) {
            $status = 'partial';
        }

        $payment->update([
            'order_id' => $order->id,
            'amount_paid' => $amountPaid,
            'change_amount' => $change,
            'payment_method' => $data['payment_method'],
            'status' => $status,
            'reference_number' => $data['reference_number'],
            'notes' => $data['notes'],
            'paid_at' => $amountPaid > 0 ? now() : null,
        ]);

        if ($status === 'paid') {
            $order->update(['status' => 'completed']);
        } elseif ($status === 'partial') {
            $order->update(['status' => 'confirmed']);
        }

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
