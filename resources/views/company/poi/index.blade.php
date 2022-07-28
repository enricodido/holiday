@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Poi</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="table_list" class="js-grid table table-striped table-no-bordered table-hover"
                                   cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="" onClick="toggle(this, 'selected[]')">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </th>
                                    <th>@lang('fleet.name')</th>
                                    <th>@lang('geofence.visible')</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            $('#table_list').on('click','tr td:not(.disableEdit):not(.dataTables_empty)',function (e) {
                var url="{{ route('company.poi.show',['__id__']) }}";
                url = url.replace('__id__',$(this).closest('tr').data('id'));
                window.location.href = url;
            });

            var table = $("#table_list").DataTable({
                ajax: {
                    url:'{{ route('company.poi.datatable') }}',
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
                    {data:"visible", name:"visible"},
                ],
                sDom: '<"dataTables__top"lfBr>t<"dataTables__bottom"ip><"clear">',
                initComplete: function(a, b) {
                    $(this).closest(".dataTables_wrapper").find(".dataTables__top")
                        .prepend('<div class="dataTables_buttons actions">' +
                            '<a href="" class="actions__item" title="Stampa" data-table-action="print" ><i class="material-icons">print</i></a>'+
                            '<a href="" class="actions__item" title="Esporta" data-table-action="excel" ><i class="material-icons">cloud_download</i></a>'+
                            '</div>');

                            $(this).closest(".dataTables_wrapper").find(".dataTables__top")
                        .prepend('<div class="dataTables_buttons actions">' +
                            '<a href="" class="actions__item text-danger js-delete" data-list="table_list" data-url="{{ route('company.poi.delete') }}"><i class="material-icons">delete</i></a>' +
                            '<a href="{{route('company.poi.create')}}" class="actions__item" style="color: #00bcd4;"><i class="material-icons">add_box</i></a>' +
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
                            return '<div class="form-check">\n' +
                                '<label class="form-check-label">\n' +
                                '<input class="form-check-input" type="checkbox" id="sel-'+data.id+'" name="selected[]" value="'+data.id+'">' +
                                '<span class="form-check-sign">' +
                                '<span class="check"></span>\n' +
                                '</span>' +
                                '</label>' +
                                '</div>';
                        },
                        targets:   0
                    },
                    {
                        render: function(data, type, row){
                            if(data == 1){
                                return '<span class="badge badge-success">@lang("form.yes")</span>';
                            }
                            else{
                                return '<span class="badge badge-danger">@lang("form.no")</span>';
                            }
                        },
                        targets: 2
                    }
                ],
            });
        });
    </script>

@endpush
