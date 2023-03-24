<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tablebook;
use Illuminate\Support\Facades\Auth;


class TableController extends Controller
{
    public function table()
    {
        $getdata = Tablebook::where('restaurant',Auth::user()->id)->paginate(10);

        return view('admin.table.index',compact('getdata'));
    }
}
