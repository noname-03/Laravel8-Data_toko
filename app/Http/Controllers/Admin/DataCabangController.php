<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DataCabangController extends Controller
{
    public function index()
    {
        $cabang = User::where('role', 'user')->get();
        // dd($cabang);
        // foreach ($cabang as $item) {
        //     echo $item->name;
        //     echo '<br>';
        // }
        return view('admin.cabang.index', compact('cabang'));
    }
}
