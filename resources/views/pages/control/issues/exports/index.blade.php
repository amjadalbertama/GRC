<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Status Follow up</th>
            <th>Title</th>
            <th>Organization</th>
            <th>Information Source</th>
            <th>Type</th>
            <th>Target Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($issueexp as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->status_name }}</td>
            <td>{{ $k->title }}</td>
            <td>{{ $k->name_org }}</td>
            <td>{{ $k->name_information_source }}</td>
            <td>{{ $k->type }}</td>
            <td>{{ $k->target_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>