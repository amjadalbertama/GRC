<table class="table table-striped table-sm border bg-white">
    <thead class="thead-main text-nowrap">
        <tr class="text-uppercase font-11">
            <th>ID</th>
            <th class="pl-3">Status</th>
            <th>Title</th>
            <th>Objective ID</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody class="text-nowrap">
        @foreach($strategies as $st)
        <tr>
            <td>{{$st->id}}</td>
            <td class="pl-3"><span class="{{ $st->status->style }}"><i class="fa fa-circle mr-1"></i>{{ $st->status->status }}</span></td>
            <td class="w-500px pr-5"><a class="d-block text-truncate_500">{{ $st->title }}</a></td>
            <td>{{ $st->id_objective }}</td>
            <td><span class="truncate-text">{{ $st->objective_category->title }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>