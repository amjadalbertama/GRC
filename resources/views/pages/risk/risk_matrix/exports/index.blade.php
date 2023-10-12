<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Period</th>
            <th>Period ID</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($risk_matrix as $k)
            <tr>
                <td>{{ $k->id }}</td>
                <td>{{ $k->status }}</td>
                <td>{{ $k->name_periods}}</td>
                <td>{{ $k->period_id }}</td>
                <td>{{ $k->period_type }}</td>
            </tr>
        @endforeach
    </tbody>
</table>