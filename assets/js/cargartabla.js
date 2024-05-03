
setTimeout(() => {
    
    const datatables = document.querySelectorAll('.datatable');
    
    datatables.forEach(datatable => {
      new DataTable(datatable, {
   
responsive: true,
    
        layout: {
    
          topEnd:{ buttons: ['copy', 'excel', 'pdf', 'print']},
          topStart: {
            buttons: ['pageLength'],
            }
        }
    });
      })
    }, "1000");




