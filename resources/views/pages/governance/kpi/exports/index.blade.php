<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>KPI Title</th>
            <th>Policy ID</th>
            <th>Policy</th>
            <th>Organization</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kpi as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->title }}</td>
            <td>{{ $k->id_policies }}</td>
            <td>{{ $k->policy }}</td>
            <td>{{ $k->name_org }}</td>
            <td>{{ $k->monitoring_status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>