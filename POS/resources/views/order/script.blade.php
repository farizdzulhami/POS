<script>
  $(function(){
    const orderedList = []
    const $submitBtn = $('#submit-order')

    // Format angka jadi Rupiah
    const fmtRp = (n) => {
      try {
        return 'Rp' + Number(n).toLocaleString('id-ID')
      } catch(e) {
        return n
      }
    }

    // Update tampilan keranjang dan total
    function refreshCartState(){
      const totalSum = orderedList.reduce((s, it) => s + Number(it.price), 0)
      $('#total-cell').text(fmtRp(totalSum))
      $('#order_payload').val(JSON.stringify({items: orderedList, total: totalSum}))
      $submitBtn.prop('disabled', orderedList.length === 0)
    }

    $submitBtn.prop('disabled', true)

    // ➕ Tambah produk
    $('.btn-add').on('click', function(e){
      e.preventDefault()
      const $card = $(this).closest('.card-body')
      const name = $card.find('.card-title').text().trim()
      const price = Number($card.find('.id_product').data('price'))
      const id = Number($card.find('.id_product').val())

      if (orderedList.every(list => list.id != id)) {
        const dataN = { id, name, qty: 1, unitPrice: price, price }
        orderedList.push(dataN)
        const row = `
          <tr data-id="${id}">
            <td>${name}</td>
            <td>
              <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary btn-minus">-</button>
                <span class="mx-2 qty">1</span>
                <button type="button" class="btn btn-outline-secondary btn-plus">+</button>
              </div>
            </td>
            <td class="price">${fmtRp(price)}</td>
            <td>
              <button type="button" class="btn btn-danger btn-sm btn-del">Hapus</button>
            </td>
          </tr>`
        $('#tbl-cart tbody').append(row)
      } else {
        const index = orderedList.findIndex(list => list.id == id)
        orderedList[index].qty += 1
        orderedList[index].price = orderedList[index].qty * orderedList[index].unitPrice

        const $row = $(`#tbl-cart tbody tr[data-id="${id}"]`)
        if ($row.length) {
          $row.find('.qty').text(orderedList[index].qty)
          $row.find('.price').text(fmtRp(orderedList[index].price))
        }
      }
      refreshCartState()
    })

    // ➕ Tambah qty
    $(document).on('click', '.btn-plus', function(){
      const $row = $(this).closest('tr')
      const id = Number($row.data('id'))
      const index = orderedList.findIndex(it => it.id === id)
      if (index !== -1) {
        orderedList[index].qty++
        orderedList[index].price = orderedList[index].qty * orderedList[index].unitPrice
        $row.find('.qty').text(orderedList[index].qty)
        $row.find('.price').text(fmtRp(orderedList[index].price))
      }
      refreshCartState()
    })

    // ➖ Kurangi qty
    $(document).on('click', '.btn-minus', function(){
      const $row = $(this).closest('tr')
      const id = Number($row.data('id'))
      const index = orderedList.findIndex(it => it.id === id)
      if (index !== -1 && orderedList[index].qty > 1) {
        orderedList[index].qty--
        orderedList[index].price = orderedList[index].qty * orderedList[index].unitPrice
        $row.find('.qty').text(orderedList[index].qty)
        $row.find('.price').text(fmtRp(orderedList[index].price))
      } else if (index !== -1 && orderedList[index].qty === 1) {
        // Jika sudah 1 dan dikurangin lagi => hapus produk
        orderedList.splice(index, 1)
        $row.remove()
      }
      refreshCartState()
    })

    // ❌ Hapus produk langsung
    $(document).on('click', '.btn-del', function(){
      const $row = $(this).closest('tr')
      const id = Number($row.data('id'))
      const index = orderedList.findIndex(it => it.id === id)
      if (index !== -1) orderedList.splice(index, 1)
      $row.remove()
      refreshCartState()
    })

    // 🚫 Cegah submit jika keranjang kosong
    $('#order-form').on('submit', function(e){
      if (orderedList.length === 0) {
        e.preventDefault()
        alert('Keranjang kosong. Tambahkan produk terlebih dahulu.')
        return false
      }
    })
  })
</script>