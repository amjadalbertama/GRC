<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Capabilities</th>
            <th>Organization</th>
            <th>Head Role</th>
            <th>Activity Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($capabilities as $k)
            <tr>
                <td>{{ $k->status }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->name}}</td>
                <td>{{ $k->name_org }}</td>
                <td>{{ $k->description }}</td>
            </tr>
        @endforeach
    </tbody>
</table>