<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Compliance Obligations</th>
            <th>Status</th>
            <th>Category</th>
            <th>Organization</th>
            <th>Objective Id</th>
            <th>Risk Id</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comreg as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->compliance }}</td>
            <td>{{ $k->status_fulfilled }}</td>
            <td>{{ $k->category_name }}</td>
            <td>{{ $k->name_org }}</td>
            <td>{{ $k->objective_id }}</td>
            <td>{{ $k->risk_id }}</td>
            <td>{{ $k->name_rating }}</td>
        </tr>
        @endforeach
    </tbody>
</table>