<table>
    <thead>
        <tr>
            <th>Status</th>
            <th>Title</th>
            <th>Area Count</th>
            <th>Organization</th>
            <th>Business Activity</th>
            <th>Period</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($impact_criteria as $k)
            <tr>
                <td>{{ $k->status }}</td>
                <td>{{ $k->smart_objectives }}</td>
                <td>{{ $k->area_count}}</td>
                <td>{{ $k->name_org }}</td>
                <td>{{ $k->cap_name }}</td>
                <td>{{ $k->name_periods }}</td>
            </tr>
        @endforeach
    </tbody>
</table>