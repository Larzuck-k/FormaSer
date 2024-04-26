setTimeout(() => {
    
    const datatables = document.querySelectorAll('.datatable');
    
    datatables.forEach(datatable => {
        new simpleDatatables.DataTable(datatable, {
          buttons: [
            'copy', 'excel', 'pdf'
        ],
          perPageSelect: [30, 40, 50, ["All", -1]],
         
          columns: [{
              select: 2,
              sortSequence: ["desc", "asc"]
            },
            {
              select: 3,
              sortSequence: ["desc"]
            },
            {
              select: 4,
              cellClass: "green",
              headerClass: "red"
            },
          ]
        });
      })
    }, "1000");