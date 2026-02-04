$(document).ready(function(){
  
    showProducts(); 
    $(document).on('click', '.read-products-button', function(){
        showProducts();
    });
 
});
  
    function showProducts(){ 
        $.getJSON("https://ronsberg.blue7.it/version21/api/readC.php", function(data){ 
        var read_clients_html=`
        <!-- when clicked, it will load the create product form -->
        <div id='create-product' class='btn btn-primary pull-right m-b-15px create-product-button'>
            <span class='glyphicon glyphicon-plus'></span> Create Client Colors
        </div>
        <!-- start table -->
        <table class='table table-bordered table-hover'>
        
            <!-- creating our table heading -->
            <tr>
                <th class='w-25-pct'>Client Id</th>
                <th class='w-10-pct'>Type</th>
                <th class='w-10-pct'>Text</th>
                <th class='w-15-pct'>hover text</th>
                <th class='w-15-pct'>link text </th>
                <th class='w-15-pct'>picture shadow </th>
                <th class='w-15-pct'>background</th>
                <th class='w-15-pct text-align-center'>Action</th>
            </tr>`;
             
            $.each(data.records, function(key, val) {
             
                var client;
                if(val.clientId){ 
                    client = `
                    <td>` +    val.clientId  + `</td>
                    <td>` + " normal" + `</td>                    
                    `
                }
                if(val.mc_id){
                    client = `
                    <td>` +    val.mc_id + `</td>
                    <td>` + "main " + `</td>                    
                    `
                }
                read_clients_html+=`
                    <tr>  
                        
                        ` +   client  + `
                        <td><input disabled type="color" name="favcolor" value="` + val.textColor + `"></td>
                        <td><input disabled type="color" name="favcolor" value="` + val.hoverText + `"></td> 
                        <td><input disabled type="color" name="favcolor" value="` + val.linkColor + `"></td>  
                        <td><input disabled type="color" name="favcolor" value="` + val.pictureShadowColor + `"></td>   
                        <td><input disabled type="color" name="favcolor" value="` + val.background + `"></td>    
            
                        <!-- 'action' buttons -->
                        <td>
                            <!-- read product button -->
                            <button class='btn btn-primary m-r-10px read-one-product-button' data-id='` + val.clientId + `'>
                                <span class='glyphicon glyphicon-eye-open'></span> Read
                            </button>
            
                            <!-- edit button -->
                            <button class='btn btn-info m-r-10px update-product-button' data-id='` + val.clientId + `'>
                                <span class='glyphicon glyphicon-edit'></span> Edit
                            </button>
            
                            <!-- delete button -->
                            <button class='btn btn-danger delete-product-button' data-id='` + val.clientId + `'>
                                <span class='glyphicon glyphicon-remove'></span> Delete
                            </button>
                        </td>
            
                    </tr>`;
            });
         
        read_clients_html+=`</table>`; 
        $("#page-content").html(read_clients_html); 
        });
    }