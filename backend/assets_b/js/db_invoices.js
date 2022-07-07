(function () {

    var db_invoices = {
        loadData: function (filter) {
            return $.grep(this.clients, function (client) {
                return (!filter.DebitAccount || client.DebitAccount.indexOf(filter.DebitAccount) > -1)
                        && (!filter.Department || client.Department === filter.Department)
                        && (!filter.FundBranch || client.FundBranch.indexOf(filter.FundBranch) > -1)
                        && (!filter.ProductProject || client.ProductProject.indexOf(filter.ProductProject) > -1)
                        && (!filter.Amount || client.Amount === filter.Amount);
            });
        },
        insertItem: function (insertingClient) {
            console.log(insertingClient);
           
            this.clients.push(insertingClient);
        },
        updateItem: function (updatingClient) {
            //debugger;
            updatingClient.remarks = 0;
            var total_v = 0;
            for (var key in updatingClient) {
                if (key!='vehicle_id' && key!='vin' ) {
                    if(!parseFloat(updatingClient[key])){
                        updatingClient[key] = 0;
                        // total_v = total_v + parseFloat(updatingClient[key]);
                    }
                   
                }
            }
            total_v =  parseFloat(updatingClient.towing) + parseFloat(updatingClient.storage) + parseFloat(updatingClient.title) + parseFloat(updatingClient.additional) ;
            total_v   = total_v * parseFloat(updatingClient.exchange_rate)
            total_v = total_v + parseFloat(updatingClient.ocean_charges) + parseFloat(updatingClient.others) + parseFloat(updatingClient.local) + parseFloat(updatingClient.vat);
            updatingClient.remarks = Math.round(total_v);
            console.log(updatingClient);

      
       var  total_incoive  = 0;
       for (var i = 0; i < db_invoices.clients.length; i++) {
            if(parseFloat(db_invoices.clients[i].remarks)){
                total_incoive += parseFloat(db_invoices.clients[i].remarks);
            }
         }
         total_incoive = Math.round(total_incoive);
         if($('#invoice-discount').val() > 0){
            var discount_percent = $('#invoice-discount').val();
            $('#invoice-before_discount').val(total_incoive);            
            var discount_amount = total_incoive * discount_percent/100;
            var total_after_discount = Math.round(total_incoive - discount_amount);
            $('#invoice-total_amount').val(total_after_discount);   
         }else{
            $('#invoice-total_amount').val(total_incoive);   
            $('#invoice-before_discount').val(total_incoive);
         }
            


   },
        deleteItem: function (deletingClient) {
            var clientIndex = $.inArray(deletingClient, this.clients);
            this.clients.splice(clientIndex, 1);
        }

    };
    db_invoices.accounts;

    window.db_invoices = db_invoices;

    db_invoices.clients = [
    ];

}());