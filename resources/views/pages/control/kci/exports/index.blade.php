<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Kci Title</th>
            <th>Program Id</th>
            <th>Program</th>
            <th>Organization</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kciexp as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->kci_name }}</td>
            <td>{{ $k->id_program }}</td>
            <td>{{ $k->program_title }}</td>
            <td>{{ $k->name_org }}</td>
            <td>{{ $k->monitoring_status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>