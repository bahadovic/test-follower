<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\CoinTransaction;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(User $user, $numberOfFollowers)
    {
        $totalCost = 4 * $numberOfFollowers;

        if ($user->coins < $totalCost) {
            return ['status' => false, 'message' => 'Not enough coins'];
        }

        DB::transaction(function () use ($user, $numberOfFollowers, $totalCost) {

            $user->decrement('coins', $totalCost);

            CoinTransaction::create([
                'user_id' => $user->id,
                'amount' => $totalCost * -1,
                'transaction_type' => 'spend',
            ]);

            Order::create([
                'user_id' => $user->id,
                'number_of_followers' => $numberOfFollowers,
                'followers_left' => $numberOfFollowers,
                'completed' => false,
            ]);
        });

        return ['status' => true];
    }

    public function listPendingOrders(User $user,$perPage = 15, $page = 1)
    {
        return Order::whereNot('user_id', $user->id)->where('completed', false)
            ->whereNotIn('id', function ($query) use ($user) {
                $query->select('order_id')
                    ->from('order_user')
                    ->where('user_id', $user->id);
            })
            ->paginate($perPage ?? 10,'page', $page);
    }

    public function followOrder(User $user, $orderId)
    {
        return DB::transaction(function () use ($user, $orderId) {
            $order = Order::find($orderId);

            if (!$order || $order->completed || $order->user_id == $user->id) {
                return ['status' => false, 'message' => 'Invalid order'];
            }

            if ($order->interactedUsers()->where('user_id',$user->id)->exist()){
                return ['status' => false, 'message' => 'Already interacted'];
            }

            $order->decrement('followers_left');

            if ($order->followers_left <= 0) {
                $order->completed = true;
                $order->save();
            }

            $user->increment('coins',  2);

            CoinTransaction::create([
                'user_id' => $user->id,
                'amount' => 2,
                'transaction_type' => 'earn',
            ]);

            $user->interactedOrders()->attach($orderId);

            return ['status' => true];
        });
    }
}
