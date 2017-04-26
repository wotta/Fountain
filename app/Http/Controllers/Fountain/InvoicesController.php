<?php

namespace App\Http\Controllers\Fountain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Cashier\Invoice;

class InvoicesController extends Controller
{
    /**
     * Return the list of invoices for the user
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('fountain.billing.invoices.index');
    }

    /**
     * Download the invoice
     *
     * @param Request $request
     * @param $invoiceId
     */
    public function download(Request $request, $invoiceId)
    {
        return $request->user()->downloadInvoice($invoiceId, [
            'vendor' => config('fountain.company'),
            'product' => 'Invoice'
        ]);
    }
}
