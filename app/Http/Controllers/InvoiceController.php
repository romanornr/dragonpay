<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        return Invoices::create($request->all());
    }
}
