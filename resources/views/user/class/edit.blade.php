@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Admin</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Data Kelas</h6>
                <p></p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.class_education.update', $class_education->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Kode Kelas</label>
                            <input type="text" class="form-control" id="inputEmail4"
                                placeholder="Kode Kelas example : SI-AL-2023" name="code"
                                value="{{ $class_education->code }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Nama Kelas</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Nama kelas example : Algoritma" value="{{ $class_education->name }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </form>
            </div>
        </div>

    </div>
@endsection
