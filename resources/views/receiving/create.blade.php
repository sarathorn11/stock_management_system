@extends('layouts.app')

@section('content')
<div>
  <h1 class="text-xl font-bold text-gray-800">Receive Order from PO-...</h1>
  <form id="receive-form" action="{{ route('receiving.createReciving', [$type, $order->id]) }}" method="POST" class="mt-8">
    @csrf
    <input type="hidden" name="id" value="">
    <input type="hidden" name="from_order" value="">
    <input type="hidden" name="form_id" value="">
    <input type="hidden" name="po_id" value="">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="text-blue-500 font-medium">P.O. Code</label>
        <input type="text" class="w-full border rounded-md p-2" value="{{$order->po_code ?? $order->purchaseOrder->po_code }}" disabled>
      </div>

      <div>
        <label for="supplier_id" class="text-blue-500 font-medium">Supplier</label>
        <select id="supplier_id" name="supplier_id" class="w-full border rounded-md p-2" disabled>
          <option disabled></option>
          <option selected value="{{$order->supplier_id}}">{{$order->supplier->name}}</option>
        </select>
      </div>
      @if($type == 'bo')
      <div>
        <label class="text-blue-500 font-medium">B.O. Code</label>
        <input type="text" class="w-full border rounded-md p-2" value="{{$order->bo_code }}" disabled>
      </div>
      @endif
    </div>

    <hr class="my-4">

    <table class="w-full border-collapse border border-gray-300">
      <colgroup>
        <col class="w-[5%]">
        <col class="w-[10%]">
        <col class="w-[10%]">
        <col class="w-[25%]">
        <col class="w-[25%]">
        <col class="w-[25%]">
      </colgroup>
      <thead>
        <tr class="bg-gray-300">
          <th class="py-2 px-3 text-center border border-gray-400"></th>
          <th class="py-2 px-3 text-center border border-gray-400">Qty</th>
          <th class="py-2 px-3 text-center border border-gray-400">Unit</th>
          <th class="py-2 px-3 text-center border border-gray-400">Item</th>
          <th class="py-2 px-3 text-center border border-gray-400">Cost</th>
          <th class="py-2 px-3 text-center border border-gray-400">Total</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @foreach ($order->items as $item)
        @php $total += $item->total; @endphp
        <tr>
          <td class="py-2 px-3 text-center border border-gray-400">
            <button class="border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white" type="button" disabled>
              <i class="fa fa-times"></i>
            </button>
          </td>
          <td class="py-2 px-3 text-center border border-gray-400">
            <input type="number" name="qty[]" class="w-12 border rounded-md p-1 text-center" value="{{$item->quantity}}" max="{{$item->quantity}}" min="0" onchange="updateRowTotal(this)">
            <input type="hidden" name="item_id[]" value="{{$item->item_id}}">
            <input type="hidden" name="unit[]" value="">
            <input type="hidden" name="oqty[]" value="{{$item->quantity}}">
            <input type="hidden" name="price[]" value="{{$item->price}}">
            <input type="hidden" name="total[]" value="{{$item->total}}">
          </td>
          <td class="py-2 px-3 text-center border border-gray-400">{{$item->unit}}</td>
          <td class="py-2 px-3 border border-gray-400">{{$item->item->name}} <br> {{$item->item->description}}</td>
          <td class="py-2 px-3 text-right border border-gray-400">{{$item->price}}</td>
          <td class="py-2 px-3 text-right border border-gray-400 total-cell">{{$item->total}}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Sub Total</th>
          <th class="text-right py-2 px-3 sub-total border border-gray-400">{{ number_format($total, 2) }}</th>
        </tr>
        <tr>
          <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
            Discount <input class="w-12 border rounded-md p-1 text-center" type="number" name="discount_perc" min="0" max="100" value="{{$order->discount_perc}}">%
            <input type="hidden" name="discount" value="{{$order->discount_perc}}">
          </th>
          <th class="text-right py-2 px-3 discount border border-gray-400">{{ number_format(($total * $order->discount_perc) / 100, 2) }}</th>
        </tr>
        <tr>
          <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
            Tax <input class="w-12 border rounded-md p-1 text-center" type="number" name="tax_perc" min="0" max="100" value="{{$order->tax_perc}}">%
            <input type="hidden" name="tax" value="{{$order->tax_perc}}">
          </th>
          <th class="text-right py-2 px-3 tax border border-gray-400">{{ number_format(($total * $order->tax_perc) / 100, 2) }}</th>
        </tr>
        <tr>
          <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Total</th>
          <th class="text-right py-2 px-3 grand-total border border-gray-400">{{number_format($total) - (number_format(($total * $order->discount_perc) / 100, 2) + number_format(($total * $order->tax_perc) / 100, 2))}}</th>
        </tr>
      </tfoot>
    </table>

    <div class="my-4">
      <label for="remarks" class="text-blue-500 font-medium">Remarks</label>
      <textarea id="remarks" name="remarks" rows="3" class="w-full border rounded-md p-2"></textarea>
    </div>
  </form>
  <div class="bg-gray-100 p-4 text-center">
    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit" form="receive-form">Save</button>
    <a href="#" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    window.updateRowTotal = function(input) {
      console.log("updateRowTotal");
      const row = input.closest('tr');
      const qty = parseFloat(input.value);
      const price = parseFloat(row.querySelector('input[name="price[]"]').value);
      const total = qty * price;
      console.log({
        qty,
        price,
        total
      })

      row.querySelector('input[name="total[]"]').value = total.toFixed(2);
      row.querySelector('.total-cell').textContent = total.toFixed(2);

      updateTotals();
    }

    function updateTotals() {
      let subtotal = 0;
      document.querySelectorAll('input[name="total[]"]').forEach(input => {
        subtotal += parseFloat(input.value);
      });

      const discountPerc = parseFloat(document.querySelector('input[name="discount_perc"]').value) || 0;
      const discount = (subtotal * discountPerc) / 100;

      const taxPerc = parseFloat(document.querySelector('input[name="tax_perc"]').value) || 0;
      const tax = (subtotal * taxPerc) / 100;

      const grandTotal = subtotal - discount - tax;

      document.querySelector('.sub-total').textContent = subtotal.toFixed(2);
      document.querySelector('.discount').textContent = discount.toFixed(2);
      document.querySelector('.tax').textContent = tax.toFixed(2);
      document.querySelector('.grand-total').textContent = grandTotal.toFixed(2);

      // Update hidden inputs for discount and tax
      document.querySelector('input[name="discount"]').value = discount;
      document.querySelector('input[name="tax"]').value = tax;
    }

    document.querySelector('input[name="discount_perc"]').addEventListener('input', updateTotals);
    document.querySelector('input[name="tax_perc"]').addEventListener('input', updateTotals);
  });
</script>
@endsection
