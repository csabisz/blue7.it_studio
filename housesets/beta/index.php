<?php
session_start();
include('../../functions.php');

$prod = new Production;


include('../../header2.php');
include('../../menu.php');

?>

    <style>
        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }

        body {
            font-size: .875rem;
        }

        .sidebar {
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

    </style>
    <div class="container-fluid">
        <div class="row">

            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky">

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Search By</span>
                    </h6>
                    <select id="select_search_by" class="custom-select mt-2">
                        <option value="pls_id">Planset ID</option>
                        <option value="owner_first_name">Planset Owner</option>
                        <option value="pls_name">Planset Name</option>
                        <option value="pls_surface">Planset Surface</option>
                        <option value="pls_price">Planset Price</option>
                    </select>
                    <input id="input_search_by" type="text" class="form-control mt-3" aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-default">

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Order By</span>
                    </h6>
                    <select id="order_by" class="custom-select mt-2">
                        <option value="pls_id">Planset ID</option>
                        <option value="owner_first_name">Planset Owner</option>
                        <option value="pls_name">Planset Name</option>
                        <option value="pls_surface">Planset Surface</option>
                        <option value="pls_price">Planset Price</option>
                    </select>

                    <button class="btn btn-warning mt-4" data-toggle="modal" data-target="#exampleModal">Add Planset</button>

                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div id="table"></div>
            </main>
        </div>

    </div>

<?php include 'add_pls.php'; ?>

    <script>

        $.ajax({
            url: '../../ajax/get_ordered_plansets.php',
            method: 'POST',
            data: {
                'type': 'pls_id',
            },
            type: 'html',
            success: function (data) {
                $('#table').html(data);
            }
        })

        $('#order_by').on('change', function () {
            console.log(this.value)

            $.ajax({
                url: '../../ajax/get_ordered_plansets.php',
                method: 'POST',
                data: {
                    'type': this.value,
                },
                type: 'html',
                success: function (data) {
                    $('#table').html(data);
                }
            })
        })

        function searchAjax() {
            let select = $('#select_search_by')[0]
            let input = $('#input_search_by')[0]

            $.ajax({
                url: '../../ajax/search_plansets.php',
                method: 'POST',
                data: {
                    'key': input.value,
                    'type': select.value,
                },
                type: 'html',
                success: function (data) {
                    $('#table').html(data);
                }
            })
        }

        $('#input_search_by').on('input', function () {
            searchAjax()
        })
        $('#select_search_by').on('change', function () {
            searchAjax()
        })


    </script>
<?php
include('../footer.php');
