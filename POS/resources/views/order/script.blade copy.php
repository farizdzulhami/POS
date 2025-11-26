<script>
  $(function(){
    const orderedList = []
    let total = 0
    $('.btn-add').on('click', function(){
      const name = $(this).closest('.card-body').find('.card-title').text()
      const price = parseInt($(this).closest('.card-body').find('h3').text().replace(/[^0-9]/g, ""))
      const id = $(this).closest('.card-body').find('.id_product').val()

      if(orderedList.every(list => list.id != parseInt(id))){
        let dataN = {'id' : parseInt(id), 'name' : name, 'qty' : 1, 'price' : parseInt(price)}
        orderedList.push(dataN)
        console.log(orderedList)
        let order = `
        <tr>
          <td>${name}</td>
          <td>1</td>
          <td>Rp ${price.toLocaleString('id-ID')}</td>
          </tr>
        `
        $('#tbl-cart tbody').append(order)
      }else {
        const index = orderedList.findIndex(list => list.id == parseInt(id))
        console.log(orderedList[index])
        orderedList[index].qty += 1
        const basePrice = parseInt(price)
        orderedList[index].price = orderedList[index].qty * basePrice
        console.log(orderedList)
        $('#tbl-cart tbody tr').eq(index).html(`
          <td>${orderedList[index].name}</td>
          <td>${orderedList[index].qty}</td>
          <td>Rp ${orderedList[index].price.toLocaleString('id-ID')}</td>
        `)
      }

    })
  })
</script>