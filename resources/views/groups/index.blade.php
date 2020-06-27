@extends('layouts.backend')

@section('title', 'List of Groups')

@section('content_header', 'List of Groups')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-header">
                    @include('groups.partial.addButton')
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <table id="list-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="showall">

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="groupForm" name="groupForm" class="form-horizontal">
                        <input type="hidden" name="group_id" id="group_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="" placeholder="Enter Permission Name"
                                       class="form-control" id="name" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mobile Number</label>
                            <div class="col-sm-10">
                                <input id="mobile_num" name="mobile_num" placeholder="Enter Display"
                                       class="form-control" required="required">
                            </div>
                        </div>
                        <button type="submit" class="btn right  btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createGroupModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingOfNewGroup"></h4>
                </div>
                <div class="modal-body">
                    <form id="addNewGroupForm" name="addNewGroupForm" class="form-horizontal">
                        <div class="form-group">
                            <label for="group_name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="group_name" value="" placeholder="Enter Permission Name"
                                       class="form-control" id="group_name" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mobile Number</label>
                            <div class="col-sm-10">
                                <input id="group_mobile_num" name="group_mobile_num" required="required"
                                       placeholder="Enter Display"
                                       class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn right  btn-primary" id="submitData" value="create">Save changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('/assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('/assets/js/jquery.dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript">
        // Show All Data
        jQuery(function ($) {
            $.ajax({
                url: "http://127.0.0.1:8000/api/groups/",
                success: function (result) {
                    let input_field = '';
                    let targetElement = $('.' + 'showall');
                    for (data in result) {
                        input_field += '<tr>';
                        input_field += '<td>';
                        input_field += result[data]['name'];
                        input_field += '</td>';
                        input_field += '<td>';
                        input_field += result[data]['mobile_num'];
                        input_field += '</td>';
                        input_field += '<td>';
                        input_field += '<a href="javascript:void(0)" data-toggle="tooltip"';
                        input_field += 'data-id="';
                        input_field += result[data]['id'];
                        input_field += '"';
                        input_field += 'data-original-title="Edit" class="edit btn btn-primary btn-xs mb-2 editProduct">Edit</a>';
                        input_field += '<a href="javascript:void(0)" data-toggle="tooltip"';
                        input_field += 'data-id="';
                        input_field += result[data]['id'];
                        input_field += '"';
                        input_field += 'data-original-title="Delete" class="btn btn-danger  btn-xs mb-2 deleteProduct">Delete</a>';
                        input_field += '</td>';
                        input_field += '</tr>';
                    }
                    targetElement.html(input_field);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Show Create Modal
            $('#createNewGroup').click(function () {
                $('#saveBtn').val("create-group");
                $('#addNewGroupForm').trigger("reset");
                $('#modelHeadingOfNewGroup').html("Create New Group");
                $('#createGroupModal').modal('show');
            });

            // Add Data Using RestAPI
            $('#submitData').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');

                let data = $('#addNewGroupForm').serialize();
                let name = $('input[name=group_name]').val();
                let mobile_num = $('input[name=group_mobile_num]').val();
                if (name && mobile_num) {
                    $.ajax({
                        data: $('#addNewGroupForm').serialize(),

                        url: "http://127.0.0.1:8000/api/group-create/" + name + "/" + mobile_num,
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#addNewGroupForm').trigger("reset");
                            $('#createGroupModal').modal('hide');
                            window.location = '/groups';
                        },
                        error: function (data) {
                            console.log(data);
                            $('#submitData').html('Save Changes');
                        }
                    });
                }
            });

            // Delete Specific Data from Database using RestAPI
            $('body').on('click', '.deleteProduct', function () {
                var delete_id = $(this).data("id");
                if (delete_id) {
                    $.ajax({
                        type: "DELETE",
                        url: "http://127.0.0.1:8000/api/group-delete/" + delete_id,
                        success: function (data) {
                            window.location = '/groups';
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });

            // Show Modal and Send data to Modal
            $('body').on('click', '.editProduct', function () {
                var group_id = $(this).data('id');
                let url = "http://127.0.0.1:8000/api/groups/" + group_id;
                $.get(url, function (data) {
                    $('#modelHeading').html("Edit Group");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');

                    $('#group_id').val(data.id);
                    $('#name').val(data.name);
                    $('#mobile_num').val(data.mobile_num);
                })
            });

            // Update Specific Data Using RestAPI
            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');

                let data = $('#groupForm').serialize();
                let group_id = $('input[name=group_id]').val();
                let name = $('input[name=name]').val();
                let mobile_num = $('input[name=mobile_num]').val();
                if (name && mobile_num && group_id) {
                    $.ajax({
                        data: $('#groupForm').serialize(),
                        url: "http://127.0.0.1:8000/api/group-update/" + group_id + "/" + name + "/" + mobile_num,
                        type: "PUT",
                        dataType: 'json',
                        success: function (data) {
                            $('#groupForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            window.location = '/groups';
                        },
                        error: function (data) {
                            console.log(data);
                            $('#saveBtn').html('Save Changes');
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        jQuery(function ($) {

            let table = $('#list-table').DataTable({
                "responsive": true,
                "pageLength": 50
            });
            // Sort by datatable desc
            table.order([0, 'asc'])
                .draw();
        })
    </script>
@endsection
