<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class ProductController extends Controller
{
    public function index($userId)
    {
        $user = User::findOrFail($userId);
        $products = $user->products;
        return view('user.product.index', [
            'user' => $user,
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($userId)
    {
        $user = User::findOrFail($userId);
        $category = Category::all();
        return view('user.product.create', [
            'user' => $user,
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $imageName = time() . '.' . $request->file->extension();
        $request->file->storeAs('public/images/product', $imageName);
        $request['photo'] = $imageName;
        $user->products()->create($request->except('file'));
        return redirect()->route('user.product.index', $userId);

        // $request['learn_point'] = json_encode(explode(',', $request->learn_point));
        // ClassNusabot::create($request->except('file'));
        // return redirect()->route('user.class.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId, $productId)
    {
        $user = User::findOrFail($userId);
        $product = $user->products()->find($productId);
        // dd($product);
        return view('user.product.show')->with([
            'user' => $user,
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId, $productId)
    {
        $user = User::findOrFail($userId);
        $category = Category::all();
        $product = $user->products()->find($productId);
        // dd($product);
        return view('user.product.edit')->with([
            'user' => $user,
            'product' => $product,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId, $productId)
    {
        $user = User::findOrFail($userId);
        $product = $user->products()->find($productId);
        $imageName = '';
        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file->extension();
            $request->file->storeAs('public/images/product', $imageName);
            if ($product->photo) {
                Storage::delete('public/images/product/' . $product->photo);
            }
        } else {
            $imageName = $product->photo;
        }
        $request['photo'] = $imageName;
        $product->update($request->except('file'));
        // $product->update($request->except(['_method', '_token']));
        return redirect()->route('user.product.index', $userId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $productId)
    {
        $user = user::findOrFail($userId);
        $price = $user->products()->find($productId);
        $price->delete();
        return redirect()->route('user.product.index', $userId);
    }
}
