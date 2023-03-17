<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(20);

        return response()->json(['success' => true, 'orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $data = $request->validated();

        auth()->user()->orders()->create($data);

        return response()->json(['success' => true, 'message' => 'Order has been created successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrderRequest $request, $id)
    {
        $data = $request->validated();
        $order = Order::query()->find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order mismatch']);
        }
        $order->update($data);

        return response()->json(['success' => true, 'message' => 'Order has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @return void
     */
    public function getOrder($id)
    {
        $order = Order::query()->find($id);

        return response()->json(['success' => true, 'order' => $order]);
    }
}
