@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-xl font-bold text-gray-800">Create Purchase Order</h1>
    <form id="receive-form" action="" class="mt-8">
      <input type="hidden" name="id" value="">
      <input type="hidden" name="from_order" value="">
      <input type="hidden" name="form_id" value="">
      <input type="hidden" name="po_id" value="">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="text-blue-500 font-medium">P.O. Code</label>
          <input type="text" class="w-full border rounded-md p-2" value="" readonly>
        </div>

        <div>
          <label for="supplier_id" class="text-blue-500 font-medium">Supplier</label>
          <select id="supplier_id" name="supplier_id" class="w-full border rounded-md p-2">
            <option disabled></option>
            <option selected value="">Supplier 01</option>
          </select>
        </div>
      </div>

      <hr class="my-4">

      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
          <div class="col-span-1">
          <div class="form-group">
              <label for="item_id" class="text-blue-500 font-medium">Item</label>
              <select id="item_id" class="w-full border rounded-md p-2">
              <option disabled selected></option>
              </select>
          </div>
          </div>

          <div class="col-span-1">
          <div class="form-group">
              <label for="unit" class="text-blue-500 font-medium">Unit</label>
              <input type="text" class="w-full border rounded-md p-2" id="unit">
          </div>
          </div>

          <div class="col-span-1">
          <div class="form-group">
              <label for="qty" class="text-blue-500 font-medium">Qty</label>
              <input type="number" step="any" class="w-full border rounded-md p-2" id="qty">
          </div>
          </div>

          <div class="col-span-1 text-center">
          <div class="form-group">
              <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700" id="add_to_list">
              Add to List
              </button>
          </div>
          </div>
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
          <tr>
            <td class="py-2 px-3 text-center border border-gray-400">
              <button class="border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white" type="button">
                <i class="fa fa-times"></i>
              </button>
            </td>
            <td class="py-2 px-3 text-center border border-gray-400">
              <input type="number" name="qty[]" class="w-12 border rounded-md p-1 text-center" value="10" max="10" min="0">
              <input type="hidden" name="item_id[]" value="">
              <input type="hidden" name="unit[]" value="">
              <input type="hidden" name="oqty[]" value="">
              <input type="hidden" name="price[]" value="">
              <input type="hidden" name="total[]" value="">
            </td>
            <td class="py-2 px-3 text-center border border-gray-400">pcs</td>
            <td class="py-2 px-3 border border-gray-400">name <br> description</td>
            <td class="py-2 px-3 text-right border border-gray-400">100</td>
            <td class="py-2 px-3 text-right border border-gray-400">1000</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Sub Total</th>
            <th class="text-right py-2 px-3 sub-total border border-gray-400">0</th>
          </tr>
          <tr>
            <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
              Discount <input class="w-12 border rounded-md p-1 text-center" type="number" name="discount_perc" min="0" max="100" value="0">%
              <input type="hidden" name="discount" value="0">
            </th>
            <th class="text-right py-2 px-3 discount border border-gray-400">0</th>
          </tr>
          <tr>
            <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
              Tax <input class="w-12 border rounded-md p-1 text-center" type="number" name="tax_perc" min="0" max="100" value="0">%
              <input type="hidden" name="tax" value="0">
            </th>
            <th class="text-right py-2 px-3 tax border border-gray-400">0</th>
          </tr>
          <tr>
            <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Total</th>
            <th class="text-right py-2 px-3 grand-total border border-gray-400">1000</th>
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
@endsection
