
setTimeout(() => {
    
    const datatables = document.querySelectorAll('.datatable');
    
    datatables.forEach(datatable => {
      new DataTable(datatable, {
   
responsive: true,
    
        layout: {
    
    
          topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });
      })
    }, "1000");




