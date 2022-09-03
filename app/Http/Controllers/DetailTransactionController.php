<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DetailTransactionController extends Controller
{
    public function index($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $detailTransactions = $transaction->detailTransactions;
        return view('detailTransaction.index', [
            'transaction' => $transaction,
            'detailTransactions' => $detailTransactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $product = Product::where('user_id', $transaction->from_user_id)->get();
        return view('detailTransaction.create', [
            'transaction' => $transaction,
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $request['status'] = 'Permintaan';
        $transaction->detailTransactions()->create($request->except('_token'));
        return redirect()->route('detailtransaction.index', $transactionId);
    }

    public function send($transactionId, $detailTransactionsId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $detailTransactions = DetailTransaction::findOrFail($detailTransactionsId);
        $detail['transaction_id'] = $transaction->id;
        $detail['product_id'] = $detailTransactions->product_id;
        $detail['qty'] = $detailTransactions->qty;
        $detail['status'] = 'Dikirim';
        $transaction->detailTransactions()->create($detail);
        return redirect()->route('detailtransaction.show', [$transactionId, $detailTransactionsId]);
    }

    public function accept($transactionId, $detailTransactionsId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $detailTransactions = DetailTransaction::findOrFail($detailTransactionsId);
        $detail['transaction_id'] = $transaction->id;
        $detail['product_id'] = $detailTransactions->product_id;
        $detail['qty'] = $detailTransactions->qty;
        $detail['status'] = 'Diterima';
        $transaction->detailTransactions()->create($detail);
        return redirect()->route('detailtransaction.show', [$transactionId, $detailTransactionsId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($transactionId, $detailTransactionsId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $detailTransactions = $transaction->detailTransactions()->find($detailTransactionsId);
        $cekStatus = $transaction->detailTransactions()->get();
        return view('detailTransaction.show')->with([
            'transaction' => $transaction,
            'cekStatus' => $cekStatus,
            'detailTransactions' => $detailTransactions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($transactionId, $productId)
    // {
    //     $user = User::findOrFail($transactionId);
    //     $category = Category::all();
    //     $product = $user->products()->find($productId);
    //     // dd($product);
    //     return view('admin.product.edit')->with([
    //         'user' => $user,
    //         'product' => $product,
    //         'category' => $category
    //     ]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $transactionId, $productId)
    // {
    //     $user = User::findOrFail($transactionId);
    //     $product = $user->products()->find($productId);
    //     $imageName = '';
    //     if ($request->hasFile('file')) {
    //         $imageName = time() . '.' . $request->file->extension();
    //         $request->file->storeAs('public/images/product', $imageName);
    //         if ($product->photo) {
    //             Storage::delete('public/images/product/' . $product->photo);
    //         }
    //     } else {
    //         $imageName = $product->photo;
    //     }
    //     $request['photo'] = $imageName;
    //     $product->update($request->except('file'));
    //     // $product->update($request->except(['_method', '_token']));
    //     return redirect()->route('admin.product.index', $transactionId);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($transactionId, $productId)
    // {
    //     $user = user::findOrFail($transactionId);
    //     $price = $user->products()->find($productId);
    //     $price->delete();
    //     return redirect()->route('admin.product.index', $transactionId);
    // }
}
