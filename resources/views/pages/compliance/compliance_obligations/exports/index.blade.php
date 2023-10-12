<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Compliance Obligation</th>
            <th>Compliance Source</th>
            <th>Rating</th>
            <th>Organization</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comobg as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->name_obligations }}</td>
            <td>{{ $k->compliance_source }}</td>
            <td>{{ $k->name_rating }}</td>
            <td>{{ $k->name_org }}</td>
        </tr>
        @endforeach
    </tbody>
</table>