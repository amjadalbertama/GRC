<div class="table-responsive">
    <table class="table table-striped table-sm border bg-white">
        <thead class="thead-main text-nowrap">
            <tr class="text-uppercase font-11">
                <th class="pl-3">Type</th>
                <th>Title</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody class="text-nowrap">
            @foreach ($revimpro as $no => $k)
            <tr>
                @if ($k->type == 1)
                <td class="pl-3 text-body"><i class="fa fa-circle mr-1"></i>Scheduled</td>
                @elseif($k->type == 2)
                <td class="pl-3 text-warning"><i class="fa fa-circle mr-1"></i>Incidental</td>
                @endif
                <td class="truncate-text"><a class="d-block truncate-text" href="{{ route('details_reviewImprove', $k->id) }}">{{ $k->title }}</a></td>
                @if ($k->status == 1)
                <td class="text-success"><i class="fa fa-circle mr-1"></i>Open</td>
                @elseif($k->status == 2)
                <td class="text-body"><i class="fa fa-circle mr-1"></i>Done</td>
                @endif
                <td>{{ \Carbon\Carbon::parse($k->date)->format('Y/m/d - H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>