@extends('backend.layouts.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>

            <div class="box-body">
                <div class=" form-inline">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="dataTables_length" id="example1_length">
                                <label>Show 
                                    <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div id="example1_filter" class="dataTables_filter">
                                <div class="pull-right">
                                    <label>
                                        <form action="">
                                            ค้นหา: <input type="text" class="form-control" name="q" placeholder="">
                                           
                                        </form>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th width="10%">รหัส</th>
                        <th width="70%">ชื่อหมวดหมู่</th>
                        <th width="20%">เครื่องมือ</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id  }}</td>
                        <td>{{ $category->detail }}</td>
                        <td>
                            <div class="tool-group-xs" role="group">
                                {{--<a data-toggle="collapse" aria-expanded="false" aria-controls="edit-category-collapse"--}}
                                    {{--href="#edit-category-collapse">                    --}}
                                    {{--<i data-toggle="tooltip" data-placement="top" title="แก้ไข" class="fa fa-pencil-square-o"></i>--}}
                                {{--</a>--}}
                                <a href="{{ action('BackendController@getEditCategory', $category->id) }}">
                                    <i data-toggle="tooltip" data-placement="top" title="แก้ไข" class="fa fa-pencil-square-o"></i>
                                </a>
                                
                                <a onclick="return confirm('คุณต้องการที่จะลบใช่ไหม?')" 
                                    href="{{ action('BackendController@getDeleteCategory', $category->id) }}">
                                    <i data-toggle="tooltip" data-placement="top" title="ลบ" class="fa fa-minus-circle"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                        @empty
                        <tr>
                            <td colspan="3">ไม่มีรายการหมวดหมู่</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="div-pagination">
                    <div class="navbar-right">
                        {!! str_replace('/?', '?', $categories->render()) !!}
                    </div>
                </div><!-- end div-pagination -->
            </div>
        </div>
    </div>
</div><!-- end campaign -->

@stop