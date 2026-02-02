$(document).ready(function(){$("#datatable").DataTable(),$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["colvis"]}).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")});
//"copy","excel","pdf",

var product_datatable = $('#product_datatable').DataTable({
    "dom": '<"toolbar">fltip',
            serverSide: true,
            bProcessing: true,
            order: [[0, "desc"]],
    ajax: {
        url: base_url + 'admin/products/productList',
        type: 'POST',
        dataSrc: "data",
    },
    columnDefs: [{orderable: false, targets: [0,7]}],
    columns: [    
        { title: "ID" },
        { title: "Product" },
        { title: "Category" },     
        { title: "Quantity" },
        { title: "UOM" },
        { title: "Price" },
        { title: "Date" },
        { title: "Action" }
    ]
  });


var category_datatable = $('#category_datatable').DataTable({
    "dom": '<"toolbar">fltip',
            serverSide: true,
            bProcessing: true,
            order: [[0, "desc"]],
    ajax: {
        url: base_url + 'admin/category/categoryList',
        type: 'POST',
        dataSrc: "data",
    },
    columnDefs: [{orderable: false, targets: [0,3]}],
    columns: [    
        { title: "ID" },
        { title: "Category" },     
        { title: "Path" },
        { title: "Action" }
    ]
  });

var stock_report = $('#stock_report').DataTable({
    "dom": '<"toolbar">fltip',
            serverSide: true,
            bProcessing: true,
            order: [[0, "desc"]],
    ajax: {
        url: base_url + 'admin/products/getStock',
        type: 'POST',
        dataSrc: "data",
    },
    columnDefs: [{orderable: false, targets: [0]}],
    columns: [    
        { title: "ID" },
        { title: "Date" },
        { title: "Product" },
        { title: "Category" },  
        { title: "UOM" },  
        { title: "Open Qty" },  
        { title: "Amount" },  
        { title: "Purchaes Qty" },  
        { title: "Amount" },  
        { title: "Sale Qty" },  
        { title: "Amount" },
        { title: "Closing Qty" },  
        { title: "Amount" },  

    ]
  });