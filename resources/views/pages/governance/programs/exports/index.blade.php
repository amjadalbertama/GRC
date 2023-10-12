<table class="table table-striped table-sm border bg-white">
    <thead class="thead-main text-nowrap">
        <tr class="text-uppercase font-11">
            <th>ID</th>
            <th class="pl-3">Status</th>
            <th>Program Title</th>
            <th>Type</th>
            <th>Strategy ID</th>
        </tr>
    </thead>
    <tbody class="text-nowrap">
        @foreach($programs as $pr)
        <tr>
            <td>{{ $pr->id }}</td>
            <td class="pl-3"><span class="{{ $pr->style }}"><i class="fa fa-circle mr-1"></i>{{ $pr->status }}</span></td>
            <td class="w-500px pr-5">
                <a class="d-block truncate-text_500">{{$pr->program_title }}</a>
            </td>
            <td>{{ $pr->type }}</td>
            <td>{{ $pr->id_strategies }}</td>
        </tr>
        @endforeach
    </tbody>
</table>