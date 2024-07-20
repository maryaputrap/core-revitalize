@extends('layouts.main')

@section('title', 'Home')

@section('content')
    @include('dashboard.containers.fdt.create')
    <table id="example" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>FDT Name</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th width="150px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fdts as $index => $fdt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $fdt->name }}</td>
                    <td>{{ $fdt->latitude }}</td>
                    <td>{{ $fdt->longitude }}</td>
                    <td class="text-center">
                        <a href="{{ route('fdt.show', ['fdt' => $fdt->id]) }}" class="btn btn-success">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="btn btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="btn btn-danger">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No clusters available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });

        $('#createClusterForm').on('submit', function(event) {
            event.preventDefault();

            let formData = {
                name: $('#name').val(),
                latitude: $('#latitude').val(),
                longitude: $('#longitude').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route('fdt.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    window.location.href = `/fdts/${response.id}`;
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });
    </script>
@endsection
