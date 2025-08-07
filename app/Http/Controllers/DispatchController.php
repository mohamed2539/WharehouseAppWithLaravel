<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DispatchTransaction;
use App\Models\Product;

class DispatchController extends Controller
{
    public function index(Request $request)
    {
        $dispatches = DispatchTransaction::with('product')
                        ->latest()
                        ->paginate(20);

        return view('dispatch.index', compact('dispatches'));
    }
}

?>