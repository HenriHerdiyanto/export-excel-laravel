@extends('layouts.admin')
@section('content')
    <div class="row py-4">
        <div class="col-md-12 py-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Add Row</h4>
                        <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                            <i class="fa fa-plus"></i>
                            Add Row
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Modal -->
                    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header no-bd">
                                    <h5 class="modal-title">
                                        <span class="fw-mediumbold">
                                            New</span>
                                        <span class="fw-light">
                                            Row
                                        </span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('admin.product.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Name of Products</label>
                                                    <input id="name" type="text" name="name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Description</label>
                                                    <input id="description" type="text" name="description"
                                                        class="form-control" placeholder="fill name">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Price</label>
                                                    <input id="price" type="text" name="price" class="form-control"
                                                        placeholder="fill name">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Add Image</label>
                                                    <input id="image" type="file" name="image" class="form-control"
                                                        placeholder="fill name">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Categories</label>
                                                    <select name="categori_id" class="form-control">
                                                        <option selected>--- PILIH --</option>
                                                        @foreach ($categori as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group form-group-default">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="" selected>--- PILIH --</option>
                                                        <option value="1">Tersedia</option>
                                                        <option value="0">Tidak Tersedia</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer no-bd">
                                        <button type="submit" id="alert_demo_3_4" class="btn btn-primary">Add</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name Of Products</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>File</th>
                                    <th>Categories</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th style="width: 10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-truncate"
                                            style="max-width: 100px; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $item->description }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>
                                            <iframe src="{{ asset('image/' . $item->image) }}" frameborder="0"></iframe>
                                        </td>
                                        <td>{{ $item->category->nama }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        {{-- <td>{{ $item->status }}</td> --}}
                                        <td>
                                            @if ($item->status == 1)
                                                <span>Tersedia</span>
                                            @else
                                                <span>Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <button type="button" data-toggle="modal"
                                                    data-target="#editModal{{ $item->id }}"
                                                    class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.product.destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('post')
                                                    <button id="alert_demo_3_2" type="submit" data-toggle="tooltip"
                                                        title="" class="btn btn-link btn-danger"
                                                        data-original-title="Delete">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                                <button id="export-btn" class="btn btn-link btn-success btn-lg"
                                                    data-original-title="Export Data"><i
                                                        class="fa fa-file-excel"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.product.update', $item->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="username">Name Of Products</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $item->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <input type="text" name="description" class="form-control"
                                                                value="{{ $item->description }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price">price</label>
                                                            <input type="text" name="price" class="form-control"
                                                                value="{{ $item->price }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="image">File</label><br>
                                                            <iframe src="{{ asset('image/' . $item->image) }}"
                                                                style="width: 100%;"></iframe>
                                                            <input type="file" name="image" class="form-control"
                                                                value="{{ $item->image }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="categori_id">Categori</label>
                                                            <select name="categori_id" class="form-control">
                                                                <option selected value="{{ $item->categori_id }}">
                                                                    {{ $item->category->nama }}</option>
                                                                @foreach ($categori as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select name="type" class="form-control" required>
                                                                <option selected>{{ $item->type }}</option>
                                                                <option value="1"
                                                                    {{ $item->type == 1 ? 'selected' : '' }}>Tersedia
                                                                </option>
                                                                <option value="0"
                                                                    {{ $item->type == 0 ? 'selected' : '' }}>Tidak Tersedia
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" id="alert_demo_3_3"
                                                            class="btn btn-success">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Edit Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('export-btn').addEventListener('click', function() {
            // Lakukan permintaan AJAX untuk mendapatkan data dari server Laravel
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var responseData = JSON.parse(xhr.responseText);

                    // Inisialisasi data untuk disertakan dalam file Excel
                    var data = [
                        ['Name', 'Description', 'Price', 'Image', 'Category', 'Created At', 'Status']
                    ];

                    // Iterasi melalui setiap produk dan tambahkan data ke array
                    responseData.forEach(function(product) {
                        var rowData = [
                            product.name,
                            product.description,
                            product.price,
                            product.image,
                            product.category ? product.category.nama :
                            '', // Memastikan nama kategori tersedia
                            product.created_at,
                            product.status
                        ];
                        data.push(rowData);
                    });

                    // Konversi data menjadi sheet
                    var ws = XLSX.utils.aoa_to_sheet(data);

                    // Buat workbook
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                    // Simpan workbook ke file Excel
                    XLSX.writeFile(wb, 'products.xlsx');
                }
            };

            xhr.open('GET', '{{ route('admin.product.exportData') }}', true);
            xhr.send();
        });
    </script>
@endsection
