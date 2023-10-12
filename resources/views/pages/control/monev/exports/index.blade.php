<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Smart Objective</th>
            <th>Status</th>
            <th>Category</th>
            <th>Organization</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($monevexp as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->smart_obj}}</td>
            <td>{{ $k->status }}</td>
            <td>{{ $k->category }}</td>
            <td>{{ $k->organization }}</td>
        </tr>
        @endforeach
    </tbody>
</table>