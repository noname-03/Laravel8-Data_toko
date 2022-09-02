@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Admin</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
                <p></p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.class_education.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Kode Kelas</label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="Kode Kelas example : SI-AL-2023" name="code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Nama Kelas</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nama kelas example : Algoritma">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </form>
            </div>
        </div>

    </div>
@endsection
