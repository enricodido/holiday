@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-lg-flex">
                <div>
                    <h5 class="mb-0">@lang('role.roles')</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="material-datatables">
                <table id="table_list" class="js-grid table table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onClick="toggle(this, 'selected[]')">
                            </div>
                        </th>
                        <th>@lang('role.role')</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            $('#table_list').on('click','tr td:not(.disableEdit):not(.dataTables_empty)',function (e) {
                var url="{{ route('roles.show',['__id__']) }}";
                url = url.replace('__id__',$(this).closest('tr').data('id'));
                window.location.href = url;
            });

            var table = $("#table_list").DataTable({
                ajax: {
                    url:'{{ route('roles.datatable') }}',
                },
                columns: [
                    {
                        searchable:     false,
                        orderable:      false,
                        data:           null,
                        name:           "checkbox",
                        defaultContent: "",
                        class:          "disableEdit",
                    },
                    {data:"name", name:"name"},
                ],
                sDom: '<"dataTables__top"lfBr>t<"dataTables__bottom"ip><"clear">',
                initComplete: function(a, b) {
                    $(this).closest(".dataTables_wrapper").find(".dataTables__top")
                        .prepend('<div class="dataTables_buttons actions">' +
                            '<a href="javascript:void(0)" class="actions__item" title="@lang("datatable.print")" data-table-action="print" ><i class="material-icons">print</i></a>'+
                            '<a href="javascript:void(0)" class="actions__item" title="@lang("datatable.export")" data-table-action="excel" ><i class="material-icons">cloud_download</i></a>'+
                            '<a href="javascript:void(0)" class="actions__item" title="@lang("datatable.filter")" data-table-action="modal" data-target="#filterModal"><i class="material-icons">filter_list</i></a>'+
                            '</div>');

                    $(this).closest(".dataTables_wrapper").find(".dataTables__top")
                        .prepend('<div class="dataTables_buttons actions">' +
                            '<a href="javascript:void(0)" class="actions__item text-danger js-delete" title="@lang('datatable.del')" data-list="table_list" data-url="{{ route('roles.delete') }}"><i class="material-icons">delete</i></a>' +
                            '<a href="{{route('roles.create')}}" class="actions__item text-primary"><i class="material-icons">add_box</i></a>' +
                            '</div>');
                    jsgrid();
                },
                "drawCallback":function(){
                    jsgrid();
                    $('#selAll').prop('checked',false);
                },
                columnDefs: [
                    {
                        render: function(data, type, row){
                            return '<div class="form-check">' +
                                '<input class="form-check-input" type="checkbox" id="sel-'+data.id+'" name="selected[]" value="'+data.id+'">' +
                                '</div>';
                        },
                        targets:   0
                    }
                ],
            });
        });
    </script>

@endpush
