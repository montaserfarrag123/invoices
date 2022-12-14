@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">



						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">

								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    @if (session()->has('Add'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('Add') }}
            </div>
        @endif

        @if (session()->has('edit'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('edit') }}
            </div>
        @endif
        @if (session()->has('delete'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('delete') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
                    <div class="col-xl-12">
                        <div class="card mg-b-20">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-lenght='50'>
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">اسم المنتج</th>
                                                <th class="border-bottom-0">اسم القسم</th>
                                                <th class="border-bottom-0">ملاحظات</th>
                                                <th class="border-bottom-0">العمليات</th>

                                            </tr>
                                        </thead>
                                        @php
                                            $i = 1;
                                        @endphp
                                        <tbody>
                                            @foreach ($products as $product )
                                            <tr>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->product_name}}</td>
                                                <td>{{$product->section->section_name}} </td>
                                                <td>{{$product->description}}</td>
                                                {{-- <td>

                                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                       data-id="{{$product->id}}" data-product_name="{{$product->product_name}}"
                                                       data-description="{{$product->description}}" data-section_name="{{ $product->section_name}}" data-toggle="modal" href="#exampleModal2"
                                                       title="تعديل"><i class="las la-pen"></i></a>

                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                       data-id="#" data-section_name="#" data-toggle="modal"
                                                       href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>

                                            </td> --}}
                                            <td>
                                                <button class="btn btn-outline-success btn-sm"
                                                    data-product_name="{{ $product->product_name }}" data-pro_id="{{ $product->id }}"
                                                    data-section_name="{{ $product->section->section_name }}"
                                                    data-description="{{ $product->description }}" data-toggle="modal"
                                                    data-target="#exampleModal2">تعديل</button>

                                                <button class="btn btn-outline-danger btn-sm " data-pro_id="{{$product->id}}"
                                                    data-product_name="{{ $product->product_name }}" data-toggle="modal"
                                                    data-target="#modaldemo9">حذف</button>
                                            </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!--end table-->
                     <!-- Basic modal to store-->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ url('/products') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="product_add">اسم منتج</label>
                                <input type="text" class="form-control" id="section_name" name="product_name">
                            </div>

                            <div class="form-group">
                                <label for="nodes">الاقسام</label>
                                <select name="section_id" id="" class="form-control">
                                    <option value="حدد القسم">حدد القسم</option>
                                    @foreach ($sections as $section )
                                        <option value="{{$section->id}}">{{$section->section_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nodes">ملاحظات</label>
                                <textarea name="description" id="nodes" cols="30" rows="3" class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-success" type="submit">تأكيد</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- End Basic modal to store -->

        <!-- Basic modal to update-->
        <div class="modal" id="exampleModal2">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ 'products/update' }}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <input type="text" name="pro_id" id="pro_id" value="">
                            <div class="form-group">
                                <label for="section_add">تعديل منتج</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>
                            <div class="form-group">
                                <label for="select_add"> القسم</label>
                                {{-- <input type="text" id="section_name" name="section_name" class="form-control"> --}}
                                {{-- <select name="section_name" id="section_name" class="form-control">
                                    <option ></option>
                                </select> --}}
                                <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                    @foreach ($sections as $section)
                                        <option>{{ $section->section_name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="nodes">ملاحظات</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-success" type="submit">تأكيد</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- End Basic modal to update -->

        <!-- Basic modal to delete-->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف قسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{'products/destroy'}}" method="post">
                        @csrf
                        @method('DELETE')

                        <div class="modal-body">
                            <input type="hidden" name="pro_id" id="pro_id" value="">
                            <h3>هل انت متاكد من انك تريد حذف القسم</h3>

                            <input class="form-control" name="product_name" id="product_name" type="text" >
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-danger" type="submit">تأكيد</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                        </div>
                    </form>
                    {{-- <form action="products/destroy" method="post">

                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="pro_id" id="pro_id" value="">
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div><!-- End Basic modal to delete -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>

    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('pro_id')
            var product_name = button.data('product_name')
            var description = button.data('description')
            var section_name = button.data('section_name')
            var modal = $(this)
            modal.find('.modal-body #pro_id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #section_name').val(section_name);
        })
    </script>

<script>
    // $('#modaldemo9').on('show.bs.modal', function(event) {
    //     var button = $(event.relatedTarget)
    //     var id = button.data('pro_id')
    //     var product_name = button.data('product_name')
    //     var modal = $(this)
    //     modal.find('.modal-body #pro_id').val(id);
    //     modal.find('.modal-body #product_name').val(product_name);
    // })
    $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var product_name = button.data('product_name')
            var modal = $(this)

            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #product_name').val(product_name);
        })
</script>

@endsection
