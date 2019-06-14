<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(Request $request){
    	$suppliers = Supplier::latest()->paginate(20);
    	return view('suppliers.index', compact('suppliers'));
    }

    public function create(){
    	return view('suppliers.create');
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'name' => 'required|string|min:5|max:100',
    		'bank_name' => 'required|string|min:5',
    		'account_number' => 'required|string|min:10',
    		'account_name' => 'required|string|min:5'
    	]);

    	$supplier = Supplier::create($request->all());
        return redirect(url('suppliers'))->with(['status' => 'success', 'message' => 'Supplier record has been created successfully']);
    }

    public function edit(Request $request, $id){
        $supplier = Supplier::findOrFail($id);
        $banks = DB::table('banks')->get();
        return view('suppliers.edit', compact('supplier', 'banks'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required|string|min:5|max:100',
            'bank_name' => 'required|string|min:5',
            'account_number' => 'required|string|min:10',
            'account_name' => 'required|string|min:5'
        ]);
        $data = request()->except(['_token', '_method']);
        Supplier::where('id', $id)->update($data);
        return back()->with(['status' => 'success', 'message' => "Supplier details updated successfully"]);
    }

    public function showForPayment(Request $request, $id){
        $supplier = Supplier::findOrFail($id);
        $history = $supplier->paymentHistory()->paginate(20);
        return view('suppliers.pay', compact('supplier', 'history'));
    }
}
