$(document).ready(function(){
 
    // show html form when 'create product' button was clicked
    $(document).on('click', '.create-product-button', function(){
        // load list of categories
        var categories_options_html=`<select name='category_id' class='form-control' id='categories_options_html'> 
            <option value='mc'>main clien</option> 
            <option value='c'>client</option> 
        </select>`; 
        // we have our html form here where product information will be entered
        // we used the 'required' html5 property to prevent empty fields
        var create_product_html=`
        
        <!-- 'read products' button to show list of products -->
        <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
            <span class='glyphicon glyphicon-list'></span> Read Products
        </div>
        <!-- 'create product' html form -->
        <form id='create-color-form' action='#' method='post' border='0'>
            <table class='table table-hover table-responsive table-bordered'>
         
                <tr>
                    <td width="25%">id(client or mc)</td>
                    <td width="65%"><input type='text' name='cid' class='form-control' required /></td>
                </tr>
         
                <tr>
                    <td width="25%">text color</td>
                    <td width="65%"><input type='text'   name='textColor' class='form-control' required /></td>
                </tr>
                <tr>
                    <td width="25%">hover color</td>
                    <td width="65%"><input type='text'   name='hoverText' class='form-control' required /></td>
                </tr> 
                <tr>
                    <td width="25%">linkColor  </td>
                    <td width="65%"><input type='text'   name='linkColor' class='form-control' required /></td>
                </tr> 
                <tr>
                    <td width="25%">picture Shadow Color  </td>
                    <td width="65%"><input type='text'   name='pictureShadowColor' class='form-control' required /></td>
                </tr>
                <tr>
                    <td width="25%">background</td>
                    <td width="65%"><input type='text'   name='background' class='form-control' required /></td>
                </tr>
                <tr>
                    <td width="25%">Category</td>
                    <td width="65%">` + categories_options_html + `</td>
                </tr>
        
                <!-- button to submit form -->
                <tr>
                    <td width="25%"></td>
                    <td width="65%">
                        <button type='submit' class='btn btn-primary'>
                            <span class='glyphicon glyphicon-plus'></span> Create color 
                        </button>
                    </td>
                </tr>
        
            </table>
        </form>`;
        // inject html to 'page-content' of our app
        $("#page-content").html(create_product_html);
         
    });
 
    // will run if create product form was submitted
    $(document).on('submit', '#create-color-form', function(){
        // get form data
        var form_data=JSON.stringify($(this).serializeObject());
        // submit form data to api
        var urlprocess;
        if($("#categories_options_html").find(":selected").val()==='mc'){
            console.log('mcc') ;
            urlprocess =  "https://ronsberg.blue7.it/version21/api/create.php";
        }
        if($("#categories_options_html").find(":selected").val()==='c'){
            console.log('c') ;
            urlprocess =  "https://ronsberg.blue7.it/version21/api/create.php";
        }
        $.ajax({ 
            url: urlprocess,
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // product was created, go back to products list
                showProducts();
            },
            error: function(xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });
        
        return false;
    });
});