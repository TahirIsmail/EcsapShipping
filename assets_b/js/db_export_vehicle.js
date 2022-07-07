(function () {

    var db_export_vehicle = {
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
            
            
        },
        updateItem: function (updatingClient) {
        },
        deleteItem: function (deletingClient) {
            var clientIndex = $.inArray(deletingClient, this.clients);
            var vin = deletingClient.Vin;
            this.clients.splice(clientIndex, 1);
            debugger;
            $.ajax({
                type: "POST",
                data:  {id:vin},
               // data: "id="+id+"status+"+status,
                url: "/vehicle/remove-from-cart",
                success: function (data) {
                   if(data){
                    $(".cart-count").html(data);
                   }else{
                     alert('Something went wrong! Please contact the administrator');
                   } 
                },
                error: function (exception) {
                    alert(exception);
                }
            });
        },


    };
    function checkDuplicate (vin){
        debugger;
        var already_in_table = false;
        for (var i = 0; i < window.db_export_vehicle.clients.length; i++) {
            if(db_export_vehicle.clients[i].vin == vin){
                    already_in_table = true;
                }
        }
        return already_in_table;
}
    db_export_vehicle.accounts;

    window.db_export_vehicle = db_export_vehicle;

    db_export_vehicle.clients = [
    ];

}());