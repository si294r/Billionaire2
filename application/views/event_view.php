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

        <title>Event</title>

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

            <h3>Event Data</h3>
            <br />
            <button class="btn btn-success" onclick="add_event()"><i class="glyphicon glyphicon-plus"></i> Add Event</button>
            <br />
            <br />
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Device</th>
                        <th>Version</th>
                        <th>Status</th>
                        <th style="width:150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                    <tr>
                        <th>Event Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Device</th>
                        <th>Version</th>
                        <th>Status</th>
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

                function add_event()
                {
                    save_method = 'add';
                    $('#form')[0].reset(); // reset form on modals
                    $('#modal_form').modal('show'); // show bootstrap modal
                    $('.modal-title').text('Add Event'); // Set Title to Bootstrap modal title
                }

                function edit_event(id)
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

                            $('[name="_id"]').val(data._id);
                            $('[name="event_name"]').val(data.event_name);
                            $('[name="server_time"]').val(data.server_time);
                            $('[name="start_date"]').val(data.start_date);
                            $('[name="end_date"]').val(data.end_date);
                            $('[name="device"]').val(data.device);
                            $('[name="version"]').val(data.version);
                            $('[name="status"]').val(data.status);
                            $('[name="server_time"]').val(data.server_time);
                            $('[name="update_time"]').val(data.update_time);

                            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                            $('.modal-title').text('Edit Event'); // Set title to Bootstrap modal title

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

                function delete_event(id)
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
                        <h3 class="modal-title">Event Form</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="_id"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Event Name</label>
                                    <div class="col-md-9">
                                        <input name="event_name" placeholder="Event Name" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Start Date</label>
                                    <div class="col-md-9">
                                        <input name="start_date" placeholder="<?php echo gmdate('Y-m-d h:i:s') ?>" class="form-control" type="datetime">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">End Date</label>
                                    <div class="col-md-9">
                                        <input name="end_date" placeholder="<?php echo gmdate('Y-m-d h:i:s') ?>" class="form-control" type="datetime">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Device</label>
                                    <div class="col-md-9">
                                        <select name="device" class="form-control">
                                            <option value="Android">Android</option>
                                            <option value="IOS">IOS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Version</label>
                                    <div class="col-md-9">
                                        <textarea name="version" placeholder="Version"class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Status</label>
                                    <div class="col-md-9">
                                        <select name="status" class="form-control">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" <?php if($this->event->is_development() != 'Event_dev') echo "style=\"display:none\"" ?>>
                                    <label class="control-label col-md-3">Server Time</label>
                                    <div class="col-md-9">
                                        <input name="server_time" placeholder="<?php echo gmdate('Y-m-d h:i:s') ?>" class="form-control" type="datetime">
                                    </div>
                                </div>
                                <div class="form-group" <?php if($this->event->is_development() != 'Event_dev') echo "style=\"display:none\"" ?>>
                                    <label class="control-label col-md-3">Update Time</label>
                                    <div class="col-md-9">
                                        <input name="update_time" disabled="true" placeholder="" class="form-control" type="datetime">
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