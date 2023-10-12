<table class="table table-striped table-sm border bg-white">
    <thead class="thead-main text-nowrap">
        <tr class="text-uppercase font-11">
            <th>id</th>
            <th class="pl-3">Status</th>
            <th>Title / BIZ ENVIRONMENT</th>
            <th>Description</th>
            <th>Type</th>
            <th>Period</th>
        </tr>
    </thead>
    <tbody class="text-nowrap">
        @foreach ($policies as $no => $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td class="pl-3">
                <span class="{{ $k->status->style }}"><i class="fa fa-circle mr-1"></i>
                    {{ $k->status->status }}
                </span>
            </td>
            <td class="w-250px">
                {{ $k->title }}
            </td>
            <td class="w-250px pr-5"><span class="d-block truncate-text">{{ $k->description }}</span></td>
            <td>{{ $k->types->policies }}</td>
            <td>{{ $k->periods->name_periods }}</td>
        </tr>
        @endforeach
    </tbody>
</table>