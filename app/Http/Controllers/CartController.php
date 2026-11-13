<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(Cart::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  debugging : lihat data sebelom diprosses, sama kayak console.log
        // dd($request->all());
        $request->validate([
            'purchase_option' => 'required'
        ]);

        if ($request->action == "add_to_cart"){
            // menentukan isi field
            $packageId = $request->purchase_option == "none" ? null : $request->purchase_option;

            Cart::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'book_id' => $request->book_id,
                ],
                [
                    'subscription_package_id' => $packageId,
                ]);
                return redirect()->route('carts')->with('success', 'Book added to cart successfully!');
        }else{

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
