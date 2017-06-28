@extends('layouts.app')
@section('title','Show Table')
    @section('style')
        <link rel="stylesheet" href="{{asset('admin/plugins/datatables/dataTables.bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
        <style>
            .load-here{
                width:100%;
            }
            .load-here img{
                -webkit-transform: translateX(-50%);
                -moz-transform: translateX(-50%);
                -ms-transform: translateX(-50%);
                -o-transform: translateX(-50%);
                transform: translateX(-50%);
            }
            .hide{
                display:none;
            }
            .dis{
                display:block;
            }
        </style>
        @endsection
    @section('content')
        <button class="btn btn-primary" type="button" data-target="#addTable" data-toggle="modal">
            Add New
        </button>

        <div class="modal fade" id="addTable">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="NewsInsert" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @if(count($errors) > 0)
                                <div class="alert alert-danger alert-dismissable fade in animated bounceInLeft">
                                    <button class="close" data-dismiss="alert"><i class="fa fa-close"></i></button>
                                    @foreach($errors->all() as $er)
                                        <i class="fa fa-warning"></i><span>{{$er}}</span><br/>
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="title">
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">Description</label>
                                <textarea class="textarea form-control"  name="description"></textarea>
                            </div>
                            <div class="form-group {{ $errors->has('media') ? ' has-error' : '' }}">
                                <label for="media">Upload Image</label>
                                <input type="file" name="media" class="form-control" id="media">
                            </div>
                            <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status">Status</label>
                                <input type="radio" name="status" value="1">Show
                                <input type="radio" name="status" value="0">Hide
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal " id="updateTable">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="NewsUpdate" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @if(count($errors) > 0)
                                <div class="alert alert-danger alert-dismissable fade in animated bounceInLeft">
                                    <button class="close" data-dismiss="alert"><i class="fa fa-close"></i></button>
                                    @foreach($errors->all() as $er)
                                        <i class="fa fa-warning"></i><span>{{$er}}</span><br/>
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">Title</label>
                                <input type="text" name='title' class="form-control" id="edit_title">
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">Description</label>
                                <textarea class="textarea form-control" name='description' id="edit_description"></textarea>
                            </div>
                            <div class="form-group {{ $errors->has('media') ? ' has-error' : '' }}">
                                <label for="media">Upload Image</label>
                                <input type="file" name='media' class="form-control" id="edit_media">
                                <img src="" id="showImg" style="width:80px;"/>
                                <input type="hidden" name="oldImg" id="oldImg">
                            </div>
                            <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status">Status</label>
                                <select name='status' id="edit_status" class="form-control">
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                            <input type="hidden" name="id" id="hid-id">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#updateTable" >Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="news-contents">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Database Table</h3>
                        </div>
                        <div class="box-body">
                            <table id="example2" class="table table-responsive table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td>SN</td>
                                        <td>Title</td>
                                        <td>Description</td>
                                        <td>Media</td>
                                        <td>Status</td>
                                        <td>Options</td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="load-here">
                                <img class="" src="{{asset('admin/img/loading.gif')}}" alt="" style="width:200px;margin-left:50%;transform:translateX(-50%);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
        <script>

            @if(count($errors)>0)
                $('#addTable').modal('show');
            @endif

            var table = $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true
            });
//          Ajax loading in dataTables
            ajaxLoad();
//          Dynamically adding content using ajax
            $('#NewsInsert').submit(function(e){
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: "{{route('news.add')}}",
                    type: "POST",
                    data: formData,
                    success: function(response){
                        if(response === "flash_success"){
                            $('#addTable').modal('hide');
                            $('#NewsInsert').trigger('reset');
                            table.clear();
                            ajaxLoad();
                        }else if(response['message'] === "errors"){
                            var NewsInsert = $('#NewsInsert');
                            var errors = response['data'];
                            for (var key in errors) {
                                alert(errors[key]);
                                var ErrInsert = NewsInsert.find('[name="' + key + '"]');
                                ErrInsert.parent().addClass('has-error');
                                ErrInsert.popover({
                                    placement: "top",
                                    content: errors[key],
                                    template: '<div class="popover animated fadeIn popover-danger" role="tooltip"><div class="arrow" style=""></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                                    trigger: 'manual'
                                }).on('keypress', function () {
                                    $(this).parent().removeClass('has-error');
                                    $(this).popover('destroy');
                                }).popover('show');
                            }
                            $('#addTable').modal('show');
                        }
                    },
                    contentType: false,
                    processData: false

                });

                {{--$.post('{{route('news.add')}}',$('#NewsInsert').serialize(),function(response){--}}
            });

            function ajaxLoad(){
                var tbody = $('tbody');
                if(tbody.children().length === 0){
                    $('.load-here img').removeChild('hide');
                    return 0;
                }else{
                    $('.load-here img').addClass('hide');
                    $.get('{{route('news.all')}}',function(response){
                        var res = $.parseJSON(response['data']);
                        for(var i = 0; i < res.length ; i++){
                            var id = res[i]['id'];
                            var img = 'thumb_'+res[i]['media'];
                            var btn = "<a onclick='ajaxDelete("+id+")' class='btn btn-danger'></a><a onclick='ajaxShowUpdate("+id+")' class='btn btn-primary' data-toggle='modal' data-target='#NewsUpdate' data-backdrop='false'></a>"
                            var result = [
                                i,
                                res[i]['title'],
                                res[i]['description'],
                                "<img src='admin/upload_imgs/thumbnails/"+img+"' style='width:100px;' />",
                                res[i]['status'],
                                btn
                            ];
                            table.row.add(result).draw();
                        }
                     });
                }
            }
            function ajaxDelete(id){
                var a = confirm("are you sure that you want to delete the content?");
                if(a === true) {
                    $.ajax({
                        url: "{{route('news.delete')}}",
                        type: 'POST',
                        data: {
                            "id": id,
                            _token: "{{csrf_token()}}"
                        },
                        success: function(data) {
                            console.log(data);
                            table.clear();
                            ajaxLoad();
                        }
                    });
                }
            }
            function ajaxShowUpdate(id){
                $.ajax({
                    url: "{{route('news.update')}}",
                    type: "POST",
                    data: {"id":id,_token:"{{csrf_token()}}"},
                    success: function(response){
                        var res = $.parseJSON(response['data']);
                        var dir = "{{asset('admin/upload_imgs')}}";
                        $("#edit_title").val(res['title']);
                        $("#hid-id").val(res['id']);
                        $('iframe').contents().find('.wysihtml5-editor').html(res['description']);
                        $("#edit_status").val(res['status']);
                        $('#showImg').attr('src', dir+'/'+res['media']);
                        $('#oldImg').val(res['media']);
                        $("#updateTable").modal('show');
                    }
                });
            }
            $('#NewsUpdate').submit(function(e){
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: "{{route('saveUpdate')}}",
                    type: "post",
                    data: formData,
                    success: function(response){
                        console.log(response);
                        table.clear();
                        ajaxLoad();
                    },
                    contentType: false,
                    processData: false
                });
                $('#updateTable').modal('hide');
                $('.modal-backdrop').remove();
            });

        </script>
    @endsection