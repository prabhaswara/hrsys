<div id="listInvoice" class="tablegrid_stylefull"></div>

 <script>
	function detailInvoice(recid){
             $(window).gn_loadmain('{site_url}/hrsys/invoice/det_invoice/'+recid);
            return false;
        }
$(function () {
	
	
	
    gridName='listInvoice';
    $('#listInvoice').w2grid({
        name    : gridName,
        autoLoad: false,
        limit:50,
        url     : '{site_url}/hrsys/invoice/json_listInvoice/',
        header  : 'List Invoice',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true
        },
        columns: [
            {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                render: function (record) {
                    return "<span class='fa-zoom-in imgbt' onClick='detailInvoice(\""+record.recid+"\")' ></span>"
                }
            },
            { field: 'acc_manager_sp_fullname', caption: 'Account Manager', size: '100%', searchable: true,sortable: true  },
            { field: 'inv_sp_invoice_num', caption: 'Invoice Number', size: '150', searchable: true,sortable: true  },
            { field: 'cli_sp_name', caption: 'Client', size: '150', searchable: true,sortable: true  },
            { field: 'inv_sp_total_bill', caption: 'Bill', size: '100', searchable: true,sortable: true,render:"number"  },
			{ field: 'inv_sp_date', caption: 'Invoice Date', size: '100', searchable: false,sortable: true , render: 'date' },
			{ field: 'inv_sp_due_date', caption: 'Due Date', size: '100', searchable: false,sortable: true, render: 'date'  },
			{ field: 'inv_sp_pay_day', caption: 'Paid Day', size: '100', searchable: false,sortable: true, render: 'date'  },
		
          
        ],
        onDblClick: function (event) {
            $(this).gn_loadmain('{site_url}/hrsys/client/detclient/'+event.recid+'/myclient');
        }
    });

    
});


</script>