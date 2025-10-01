@extends('layouts.index')

@section('content')
    <a href="{{ route('jenis_surat.create') }}" class="btn btn-primary mb-3">Tambah Jenis Surat</a>
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <td>No</td>
                    <td>Nama Surat</td>
                    <td>Aksi</td>
                </tr>

                @if ($jenis_surat->isEmpty())
                    <tr>
                        <td class="text-center" colspan="3">
                            Tidak ada data
                        </td>
                    </tr>
                @endif
                @foreach ($jenis_surat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_surat }}</td>
                        <td>
                            <a target="_blank" class="btn btn-secondary"
                                href="{{ route('jenis_surat.show', $item->id) }}">Preview</a>
                            <a class="btn btn-warning" href="{{ route('jenis_surat.edit', $item->id) }}">Edit</a>
                            <form action="{{ route('jenis_surat.destroy', $item->id) }}" method="POST"
                                style="display:inline;">
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
@endsection
