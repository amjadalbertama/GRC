<table>
    <thead>
        <tr>
            <th>Status</th>
            <th>ID</th>
            <th>Period</th>
            <th>Period Id</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($likeli as $no => $k)
        <tr>
            <td>{{ $k->status_likehood }}</td>
            <td>{{ $k->id }}</td>
            <td>{{ $k->name_periods }}</td>
            <td>{{ $k->period_id }}</td>
            <td>{{ $k->type }}</td>
        </tr>
        @endforeach
    </tbody>
</table>