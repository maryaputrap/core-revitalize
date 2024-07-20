@extends('layouts.main')

@section('title', 'Home')

@section('content')

    <a href="{{ route('pop.index') }}" class="btn btn-secondary mb-5">Back to List</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>POP Name</th>
            <td>
                @foreach ($pop as $popName)
                    {{ $popName->name }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>OLT Name</th>
            <td>
                @foreach ($olt as $hardware)
                    {{ $hardware->name }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>ODF Name</th>
            <td>
                @foreach ($odf as $hardware)
                    {{ $hardware->name }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Latitude</th>
            <td>
                @foreach ($pop as $p)
                    {{ $p->latitude }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Longitude</th>
            <td>
                @foreach ($pop as $p)
                    {{ $p->longitude }}<br>
                @endforeach
            </td>
        </tr>
    </table>


    <h5 class="text-center my-5">Connections OLT <> ODF</h5>
    <div class="d-flex justify-content-center">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th class="text-center">OLT Ports</th>
                    <th class="text-center">Connections</th>
                    <th class="text-center">ODF Ports</th>
                </tr>
            </thead>
            <tbody id="connections-tbody">
                @for ($i = 0; $i < max(count($oltPorts), count($odfPorts)); $i++)
                    <tr>
                        <td class="text-center align-middle" style="height: 40px;">
                            @if (isset($oltPorts[$i]))
                                <select id="olt-port-{{ $i }}" class="olt-port" data-index="{{ $i }}">
                                    @foreach ($oltPorts as $port)
                                        <option value="{{ $port->id }}"
                                            @if (isset($cores[$i]) && $port->id == $cores[$i]->port_from_id) selected @endif>{{ $port->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td class="text-center align-middle" style="height: 40px;">
                            @if (isset($cores[$i]))
                                <svg width="100%" height="40">
                                    <line x1="0" y1="20" x2="100%" y2="20"
                                        stroke="{{ $cores[$i]->color }}" stroke-width="2" />
                                </svg>
                            @endif
                        </td>
                        <td class="text-center align-middle" style="height: 40px;">
                            @if (isset($odfPorts[$i]))
                                <select id="odf-port-{{ $i }}" class="odf-port"
                                    data-index="{{ $i }}">
                                    @foreach ($odfPorts as $port)
                                        <option value="{{ $port->id }}"
                                            @if (isset($cores[$i]) && $port->id == $cores[$i]->port_to_id) selected @endif>{{ $port->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="text-center my-5">
        <button id="save-btn" class="btn btn-primary" style="display: none;">Save Changes</button>
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cores = @json($cores);

            const svg = document.getElementById('connections-svg');

            const drawLine = (x1, y1, x2, y2, color) => {
                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', x1);
                line.setAttribute('y1', y1);
                line.setAttribute('x2', x2);
                line.setAttribute('y2', y2);
                line.setAttribute('stroke', color);
                line.setAttribute('stroke-width', '2');
                svg.appendChild(line);
            };

            const updateConnections = () => {
                svg.innerHTML = ''; // Clear existing lines

                cores.forEach(core => {
                    const portFrom = document.querySelector(
                        `select.olt-port[data-index="${core.index}"] option[value="${core.port_from_id}"]`
                    ).parentElement;
                    const portTo = document.querySelector(
                        `select.odf-port[data-index="${core.index}"] option[value="${core.port_to_id}"]`
                    ).parentElement;

                    if (portFrom && portTo) {
                        const rectFrom = portFrom.getBoundingClientRect();
                        const rectTo = portTo.getBoundingClientRect();

                        const x1 = rectFrom.right;
                        const y1 = rectFrom.top + rectFrom.height / 2;
                        const x2 = rectTo.left;
                        const y2 = rectTo.top + rectTo.height / 2;

                        drawLine(x1, y1, x2, y2, 'red'); // Draw red line
                    }
                });
            };

            const showSaveButton = () => {
                document.getElementById('save-btn').style.display = 'block';
            };

            document.querySelectorAll('.olt-port, .odf-port').forEach(select => {
                select.addEventListener('change', showSaveButton);
            });

            updateConnections();
            window.addEventListener('resize', updateConnections);

            document.getElementById('save-btn').addEventListener('click', function() {
                const updatedCores = [];
                document.querySelectorAll('select.olt-port').forEach((select, index) => {
                    const oltPortId = select.value;
                    const odfPortId = document.querySelector(
                        `select.odf-port[data-index="${index}"]`).value;
                    updatedCores.push({
                        index,
                        port_from_id: oltPortId,
                        port_to_id: odfPortId
                    });
                });

                // Simpan perubahan ke server
                fetch('/save-connections', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            cores: updatedCores
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    }).catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
