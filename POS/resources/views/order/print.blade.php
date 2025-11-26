@extends('templates.layout')

@section('content')
  <div class="container mt-4">
    <div class="card">
      <div class="card-body">
        <h4>Invoice: {{ $order->invoice }}</h4>
        <p><strong>Pelanggan:</strong> {{ $order->customer->name ?? $order->customer_id }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at }}</p>

        <table class="table table-sm">
          <thead>
            <tr>
              <th>Product</th>
              <th>Qty</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach($details as $d)
              <tr>
                <td>{{ $products[$d->product_id]->name ?? $d->product_id }}</td>
                <td>{{ $d->qty }}</td>
                <td>Rp {{ number_format($d->price, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="text-end"><strong>Total:</strong></td>
              <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>

        <div class="mt-3">
          <a href="{{ url('order') }}" class="btn btn-secondary btn-sm">Kembali</a>
          <button id="print-now" class="btn btn-primary btn-sm">Print</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
<script>
  function printCardOnly() {
    const card = document.querySelector('.card').cloneNode(true);
    const btns = card.querySelectorAll('button, a.btn');
    btns.forEach(b => b.remove());

    const styles = Array.from(document.styleSheets)
      .map(sheet => {
        try {
          return Array.from(sheet.cssRules).map(rule => rule.cssText).join('');
        } catch(e) {
          return '';
        }
      })
      .join('');

    const printWindow = window.open('', '_blank', 'width=900,height=700');
    printWindow.document.write(`
      <html>
        <head>
          <title>Invoice {{ $order->invoice }}</title>
          <style>${styles}</style>
        </head>
        <body>${card.outerHTML}</body>
      </html>
    `);
    printWindow.document.close();

    printWindow.addEventListener('load', function() {
      printWindow.focus();
      printWindow.print();
      setTimeout(() => printWindow.close(), 400);
    });
  }

  window.addEventListener('load', function() {
    // Removed automatic print on load
  });

  document.getElementById('print-now').addEventListener('click', printCardOnly);
</script>
@endpush