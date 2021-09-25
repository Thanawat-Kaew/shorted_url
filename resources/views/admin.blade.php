@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form action="#" method="post" id="form-manage-url">
                            <?php echo csrf_field()?>
                            <input type="hidden" value="" name="id_url" id="id_url">
                            <table border="1" align="center" width="100%" class="table" id="table-shorted-url">
                                <thead>
                                    <tr>
                                        <th width="10%" class="text-center">No</th>
                                        <th width="35%" class="text-center">Short Url</th>
                                        <th width="35%" class="text-center">Full Url</th>
                                        <th width="10%" class="text-center">Edit</th>
                                        <th width="10%" class="text-center">Delete</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                @foreach($url_all as $key => $value)
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td>http://salty-cliffs-10650.herokuapp.com/url/{{ $value->short_url }}</td>
                                        <td>{{ substr($value->full_url,0,30).'...'}}</td>
                                        <td class="text-center">
                                            <input type="button" value="Edit" class="btn btn-warning edit_url" data-id_url="{{$value->id}}">
                                        </td>
                                        <td class="text-center">
                                            <input type="button" value="Delete" class="btn btn-danger delete_url" data-id_url="{{$value->id}}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody> 
                            </table>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-shorted-url').DataTable({
            pageLength : 25,
        });

        $("#table-shorted-url").on('click', '.delete_url', function(){
            let id = $(this).data('id_url');
            $("#id_url").val(id);
            if(confirm("แน่ใจจะลบข้อมูลใช่ไหม")){
                $("#form-manage-url").attr('action', "{{route('admin.delete_url')}}");
                $("#form-manage-url").submit();
            }
        });

        $("#table-shorted-url").on('click', '.edit_url', function(){
            let id = $(this).data('id_url');
            $("#id_url").val(id);
            $("#form-manage-url").attr('action', "{{route('admin.edit_url')}}");
            $("#form-manage-url").submit();
        });
    });
</script>
@endsection


