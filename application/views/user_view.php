<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/favicon-32x32.png') ?>">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>User</title>

        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/navbar.css') ?>" rel="stylesheet">

    </head>
    <body>

        <div class="container">

            <!-- Static navbar -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">                        
                        <a class="navbar-brand" href="#">Billionaire</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <?php $class = strtolower($this->router->fetch_class()); ?>
                            <li class="<?php echo $class == 'home' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('home') ?>">Home</a>
                            </li>
                            <li class="<?php echo $class == 'event' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('event') ?>">Event</a>
                            </li>
                            <li class="<?php echo $class == 'event_dev' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('event_dev') ?>">Event Dev</a>
                            </li>
                            <li class="<?php echo $class == 'user' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('user') ?>">User</a>
                            </li>
                            <li class="<?php echo $class == 'user_dev' ? 'active' : '' ?>">
                                <a href="<?php echo base_url('user_dev') ?>">User Dev</a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo base_url('signin/out') ?>">Signout</a></li>
                        </ul>                        
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>

            <h3>User Data</h3>
            <br />
            <button class="btn btn-success" onclick="add_user()"><i class="glyphicon glyphicon-plus"></i> Add User</button>
            <br />
            <br />
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Facebook ID</th>
                        <th>Display Name</th>
                        <th>Networth</th>
                        <th>Networth_2</th>
                        <th>Networth_pow</th>
                        <th>App Version</th>
                        <th>Device Type</th>
                        <th>Country</th>
                        <th style="width:150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                    <tr>
                        <th>Facebook ID</th>
                        <th>Display Name</th>
                        <th>Networth</th>
                        <th>Networth_2</th>
                        <th>Networth_pow</th>
                        <th>App Version</th>
                        <th>Device Type</th>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <script src="<?php echo base_url('assets/jquery/jquery-2.2.2.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js') ?>"></script>

        <script type="text/javascript">

                var save_method; //for save method string
                var table;
                $(document).ready(function () {
                    table = $('#table').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.

                        // Load data for the table's content from an Ajax source
                        "ajax": {
                            "url": "<?php echo site_url($class.'/ajax_list') ?>",
                            "type": "POST"
                        },
                        //Set column definition initialisation properties.
                        "columnDefs": [
                            {
                                "targets": [-1], //last column
                                "orderable": false, //set not orderable
                            },
                        ],
                    });
                });

                function add_user()
                {
                    save_method = 'add';
                    $('#form')[0].reset(); // reset form on modals
                    $('#modal_form').modal('show'); // show bootstrap modal
                    $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
                }

                function edit_user(id)
                {
                    save_method = 'update';
                    $('#form')[0].reset(); // reset form on modals

                    //Ajax Load data from ajax
                    $.ajax({
                        url: "<?php echo site_url($class.'/ajax_edit/') ?>/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function (data)
                        {

                            $('[name="facebook_id_0"]').val(data.facebook_id);
                            $('[name="facebook_id"]').val(data.facebook_id);
                            $('[name="display_name"]').val(data.display_name);
                            $('[name="networth"]').val(data.networth);
                            $('[name="networth_2"]').val(data.networth_2);
                            $('[name="networth_pow"]').val(data.networth_pow);
                            $('[name="appVersion"]').val(data.appVersion);
                            $('[name="device_type"]').val(data.device_type);
                            $('[name="country"]').val(data.country);
//                            $('[name="create_time"]').val(data.create_time);
//                            $('[name="update_time"]').val(data.update_time);

                            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title

                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error get data from ajax');
                        }
                    });
                }

                function reload_table()
                {
                    table.ajax.reload(null, false); //reload datatable ajax
                }

                function save()
                {
                    var url;
                    if (save_method == 'add')
                    {
                        url = "<?php echo site_url($class.'/ajax_add') ?>";
                    } else
                    {
                        url = "<?php echo site_url($class.'/ajax_update') ?>";
                    }

                    // ajax adding data to database
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $('#form').serialize(),
                        dataType: "JSON",
                        success: function (data)
                        {
                            //if success close modal and reload ajax table
                            $('#modal_form').modal('hide');
                            reload_table();
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error adding / update data');
                        }
                    });
                }

                function delete_user(id)
                {
                    if (confirm('Are you sure delete this data?'))
                    {
                        // ajax delete data to database
                        $.ajax({
                            url: "<?php echo site_url($class.'/ajax_delete') ?>/" + id,
                            type: "POST",
                            dataType: "JSON",
                            success: function (data)
                            {
                                //if success reload ajax table
                                $('#modal_form').modal('hide');
                                reload_table();
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                alert('Error delete data');
                            }
                        });

                    }
                }

        </script>

        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">User Form</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="facebook_id_0"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Facebook ID</label>
                                    <div class="col-md-9">
                                        <input name="facebook_id" placeholder="Facebook ID" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Display Name</label>
                                    <div class="col-md-9">
                                        <input name="display_name" placeholder="Display Name" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Networth</label>
                                    <div class="col-md-9">
                                        <input name="networth" placeholder="Networth" class="form-control" type="number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Networth 2</label>
                                    <div class="col-md-9">
                                        <input name="networth_2" placeholder="Networth 2" class="form-control" type="number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Networth Pow</label>
                                    <div class="col-md-9">
                                        <input name="networth_pow" placeholder="Networth Pow" class="form-control" type="number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">App Version</label>
                                    <div class="col-md-9">
                                        <input name="appVersion" placeholder="App Version" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Device Type</label>
                                    <div class="col-md-9">
                                        <input name="device_type" placeholder="Device Type" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Country</label>
                                    <div class="col-md-9">
                                        <input name="country" placeholder="Country" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->
    </body>
</html>