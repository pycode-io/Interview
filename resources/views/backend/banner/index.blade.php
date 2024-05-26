@extends('backend.layouts.master')
@push('title')
    <title>Banner Page</title>
@endpush
@push('styles')
    <style>
        /* div.dataTables_wrapper div.dataTables_paginate {
                    display: none;
                } */
        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
        }
    </style>
@endpush
@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Dashboard > Banners List</h6>
            <a href="{{ route('banner.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Banner</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($banners) > 0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Photo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S.N.</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Photo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>{{ $banner->title }}</td>
                                    <td>{{ $banner->slug }}</td>
                                    <td class="text-center">
                                        @if ($banner->photo)
                                            <img src="{{ asset('storage/Banner/' . $banner->photo) }}"
                                                class="img-fluid zoom" style="max-width:80px" alt="{{ $banner->photo }}">
                                        @else
                                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}"
                                                class="img-fluid zoom" style="max-width:100%" alt="avatar.png">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($banner->status == 'active')
                                            <span class="badge badge-success">{{ $banner->status }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $banner->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('banner.edit', $banner->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('banner.destroy', [$banner->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $banner->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <span style="float:right">{{ $banners->links() }}</span> --}}
                @else
                    <h6 class="text-center">No banners found!!! Please create banner</h6>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#banner-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [3, 4, 5]
            }]
        });

        // Sweet alert
        function deleteData(id) {}
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
@endpush
