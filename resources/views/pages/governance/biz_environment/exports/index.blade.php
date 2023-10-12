<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Factor</th>
            <th>Source</th>
            <th>Type</th>
            <th>Period</th>
            <th>Capability</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($biz_environment as $no => $k)
            <tr>
                <td>{{ $k->id }}</td>
                <td>{{ $k->status }}</td>
                <td>{{ $k->name_environment }}</td>
                <td>{{ $k->source }}</td>
                <td>{{ $k->type }}</td>
                <td>{{ $k->period }}</td>
                <td>{{ $k->business_activity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>