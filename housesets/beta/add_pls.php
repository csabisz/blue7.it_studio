<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Planset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="add_new_plasest.php">
                    <div class="form-group">
                        <label for="pls_owner">Planset Owner</label>
                        <input type="text" class="form-control" id="pls_owner" placeholder="Owner">
                    </div>
                    <div class="form-group">
                        <label for="pls_name">Planset Name</label>
                        <input type="text" class="form-control" id="pls_name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Planset Dimensions</label>
                        <div class="row row-cols-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Length(m)">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Width(m)">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Height(m)">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pls_surface">Total Surface</label>
                        <input type="text" class="form-control" id="pls_surface" placeholder="Surface">
                    </div>
                    <div class="form-group">
                        <label for="pls_price">Planset Price</label>
                        <input type="text" class="form-control" id="pls_price" placeholder="Price">
                    </div>
                    <div class="form-group">
                        <label for="pls_presentation">Presentation ID</label>
                        <input type="text" class="form-control" id="pls_presentation" placeholder="Presentation">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>

        </div>
    </div>
</div>