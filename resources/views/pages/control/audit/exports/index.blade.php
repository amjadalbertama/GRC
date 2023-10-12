<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Type</th>
            <th>Organization</th>
            <th>Period</th>
            <th>Findings</th>
            <th>Source / ID</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($audit as $k)
            <tr>
                <td>{{ $k['id'] }}</td>
                <td>{{ $k['status'] }}</td>
                <td>{{ $k['type']}}</td>
                <td>{{ $k['name_org'] }}</td>
                <td>{{ $k['name_periods'] }}</td>
                <td>{{ $k['finding'] }}</td>
                @if($k['source'] != null && $k['id_source'] != null)
                <td>{{ $k['source'] }} / {{ $k['id_source'] }}</td>
                @else
                <td></td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>