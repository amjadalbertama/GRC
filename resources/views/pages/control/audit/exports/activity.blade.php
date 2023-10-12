<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Findings</th>
            <th>Target Date</th>
            <th>Followup</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($audit_activity as $k)
            <tr>
                <td>{{ $k['id'] }}</td>
                <td>{{ $k['status'] }}</td>
                <td>{{ $k['audit_finding']}}</td>
                <td>{{ $k['target_date'] }}</td>
                <td>{{ $k['foll_stat'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>