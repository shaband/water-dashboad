<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $invoices = Invoice::query()->with(
            [
                'agent',
                'user',
                'delivery',
            ])->ofStatus($request->status)->paginate();
        return InvoiceResource::collection($invoices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \App\Http\Resources\Invoice\InvoiceResource
     */
    public function show(Request $request, Invoice $invoice)
    {
        return new InvoiceResource(
            $invoice->load('invoiceProducts',
                'agent',
                'user',
                'address',
                'userAddress',
                'delivery',
                'promocode',
            ));
    }

    /**
     * @param \App\Http\Requests\Admin\Invoice\InvoiceUpdateRequest $request
     * @param \App\Models\Invoice $invoice
     * @return \App\Http\Resources\Invoice\InvoiceResource
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return new InvoiceResource($invoice);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Invoice $invoice)
    {
        $invoice->delete();

        return response()->noContent();
    }
}
