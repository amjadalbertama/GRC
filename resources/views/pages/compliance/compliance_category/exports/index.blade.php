<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Category Title</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comcat as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->status }}</td>
            <td>{{ $k->name }}</td>
            <td>{{ $k->type }}</td>
            <td>{{ $k->description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>