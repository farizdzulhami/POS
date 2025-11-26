@extends('templates.layout')

@section('title', 'Daily Report Page')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">📅 Laporan Penjualan: {{ $date }}</h4>

      <div class="row text-center mb-3">
        <div class="col-md-3">
          <div class="p-3 bg-light rounded shadow-sm">
            <h6>Total Transaksi</h6>
            <h5 class="fw-bold">{{ $totalOrders }}</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="p-3 bg-light rounded shadow-sm">
            <h6>Produk Terjual</h6>
            <h5 class="fw-bold">{{ $totalItems }}</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="p-3 bg-light rounded shadow-sm">
            <h6>Pendapatan</h6>
            <h5 class="fw-bold text-success">Rp {{ number_format($totalSales, 0, ',', '.') }}</h5>
          </div>
        </div>
      </div>

      <table class="table table-sm table-bordered align-midle text-center">
        <thead class="table-light">
          <tr>
            <th>NO</th>
            <th>Invoice</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Waktu</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($orders as $i => $order)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $order->invoice }}</td>
              <td>{{ $order->customer->name ?? '-' }}</td>
              <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
              <td>{{ $order->created_at->format('H:i:s') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">Tidak ada transaksi hari ini</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-3 text-end">
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
          <title>Laporan+
           Penjualan {{ $date }}</title>
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

  document.getElementById('print-now').addEventListener('click', printCardOnly);
</script>
@endpush