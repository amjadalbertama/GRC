<table class="table table-striped table-sm border bg-white">
    <thead class="thead-main text-nowrap">
        <tr class="text-uppercase font-11">
            <th>ID</th>
            <th class="pl-3">Status</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody class="text-nowrap">
        @foreach ($list_objectegory as $no => $k)
        <tr>
            <td>
                {{ $k->id }}
            </td>
            <td class="pl-3">
                <span class="{{ $k->data_status->style }}">
                    <i class="fa fa-circle mr-1"></i>
                    {{ $k->data_status->status }}
                </span>
            </td>
            <td class="w-500px pr-5">
                {{ $k->title }}
            </td>
            <td class="w-500px pr-5 truncate-text">{{ $k->description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>