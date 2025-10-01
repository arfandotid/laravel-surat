@extends('layouts.index')

@section('content')
    <a href="{{ route('surat.index') }}" class="btn btn-secondary mb-3">Batal</a>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('surat.preview') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_surat_id" value="{{ request()->jenis }}">
                <div class="mb-3">
                    <label for="no_surat">Nomor Surat</label>
                    <input type="text" placeholder="Nomor Surat" class="form-control" id="no_surat" name="no_surat"
                        required>
                    @error('no_surat')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tgl_surat">Tanggal Surat</label>
                    <input type="date" placeholder="Tanggal Surat" class="form-control" id="tgl_surat" name="tgl_surat"
                        required>
                    @error('tgl_surat')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
