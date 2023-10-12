<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Name</th>
            <th>Capability</th>
            <th>Type</th>
            <th>Activity Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($periods as $k)
            <tr>
                <td>{{ $k->status }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->name_periods}}</td>
                <td>{{ $k->name_capabilities }}</td>
                <td>{{ $k->type }}</td>
                <td>{{ $k->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>