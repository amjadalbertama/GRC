<table>
    <thead>
        <tr>
            <th rowspan="2" class="pl-3">Frequency</th>
            <th rowspan="2">Likelihood</th>
            <th rowspan="2">Probability</th>
            <th colspan="2">Likelihood Level</th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($detlike as $no => $k)
        <tr>
            <td>{{ $k->fnum_frequency }} events {{ $k->range_frequency }} {{ $k->type_frequency }}</td>
            <td>{{ $k->likelihood}}</td>
            <td>{{ $k->range_start }}% &ge; x &ge; {{ $k->range_end }}%</td>
            <td style="background-color: {{$k->code_warna}} ; ">{{ $k->name_level}}</td>
            <td style="background-color: {{$k->code_warna}} ; ">{{ $k->score_level}}</td>
        </tr>
        @endforeach
    </tbody>
</table>