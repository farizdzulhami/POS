<form action="{{url('order') }}" id="order-form" method="POST">
  @csrf
  <div class="mb-2">
    <label for="customer_id" class="form-label">Customer</label>
    <select name="customer_id" id="customer_id" class="form-select form-select-sm">
      @foreach ($customers as $c)
      <option value="{{ $c->id }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <table class="table table-sm align-midle" id='tbl-cart'>
    <thead>
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" class="text-end"><strong>Total:</strong></td>
        <td id="total-cell">0</td>
      </tr>
    </tfoot>
  </table>

  <input type="hidden" name="order_payload" id="order_payload" value="">
  <button type="submit" id="submit-order" class="btn btn-success">Submit Order</button>
</form>