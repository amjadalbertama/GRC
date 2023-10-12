<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Title</th>
            <th>Program ID</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($controls as $k)
            <tr>
                <td>{{ $k['id'] }}</td>
                <td>{{ $k['status'] }}</td>
                <td>{{ $k['title']}}</td>
                <td>{{ $k['id_program'] }}</td>
                <td>{{ $k['program_type'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>