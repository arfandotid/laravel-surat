@extends('layouts.index')

@section('content')
    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary mb-3">Tambah
        Surat</button>
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <td>No</td>
                    <td>Nomor Surat</td>
                    <td>Tgl Surat</td>
                    <td>Nama Surat</td>
                    <td>Aksi</td>
                </tr>

                @if ($surat->isEmpty())
                    <tr>
                        <td class="text-center" colspan="5">
                            Tidak ada data
                        </td>
                    </tr>
                @endif
                @foreach ($surat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_surat }}</td>
                        <td>{{ $item->tgl_surat }}</td>
                        <td>{{ $item->jenis->nama_surat }}</td>
                        <td>
                            <a target="_blank" class="btn btn-secondary"
                                href="{{ route('surat.show', $item->id) }}">Preview</a>
                            <a class="btn btn-warning" href="{{ route('surat.edit', $item->id) }}">Edit</a>
                            <form action="{{ route('surat.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Surat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('surat.create') }}">
                    <div class="modal-body">
                        <select name="jenis" id="jenis" class="form-select">
                            <option value="">Pilih Surat</option>
                            @foreach ($jenis_surat as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama_surat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
