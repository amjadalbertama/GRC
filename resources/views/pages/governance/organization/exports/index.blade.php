<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Name</th>
            <th>Upper Organization</th>
            <th>Head Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($organization as $k)
            <tr>
                <td>{{ $k->status }}</td>
                <td>{{ $k->id }}</td>
                <td>{{ $k->name_org}}</td>
                <td>{{ $k->upper_name }}</td>
                <td>{{ $k->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>