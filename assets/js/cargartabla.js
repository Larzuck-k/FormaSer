
setTimeout(() => {
    
    const datatables = document.querySelectorAll('.datatable');
    
    datatables.forEach(datatable => {
      new DataTable(datatable, {
   
responsive: true,
    
        layout: {
    
          topEnd:{ buttons: ['copy', 'csv', 'excel', 'pdf', 'print','pageLength']},
          bottomEnd: {
            buttons: ['pageLength'],
            }
        }
    });
      })
    }, "1000");




