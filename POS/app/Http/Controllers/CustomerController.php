<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::all();
        return view('customer.index', compact('data'));
    }

    public function create()
    {
        return view('customer.form');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status'] = '1'; // default aktif
            Customer::create($data);

            DB::commit();
            return redirect()->route('customer.index')->with('success', 'Data Berhasil Disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
    }

    public function edit(Customer $customer)
    {
        return view('customer.form_edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->update($request->all());
            DB::commit();
            return redirect()->route('customer.index')->with('success', 'Data Berhasil Diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('customer.index')->with('success', 'Data Berhasil Dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('customer.index')->with('error', $e->getMessage());
        }
    }
}