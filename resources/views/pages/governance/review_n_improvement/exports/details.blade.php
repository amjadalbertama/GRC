<p class="mb-2">Management Review: </p>
<table class="table table-striped table-sm border bg-white">
    <thead class="thead-main text-nowrap">
        <tr class="text-uppercase font-11">
            <th class="pl-3">Title</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        </thead>
            <tbody class="text-nowrap">
            @foreach($detrevdet as $no => $k)
            <tr>
                <td class="pl-3"><a href="./monitoring-details.html" title="View Monev">{{$k->title}}</a></td>
                <td class="w-500px pr-5"><span class="d-block text-truncate w-500px" >{{$k->description}}</span></td>
                @if($k->status == 1)
                <td><span class="text-body"><i class="fa fa-circle mr-1"></i>Achieved</span></td>
                @else
                <td><span class="text-danger"><i class="fa fa-circle mr-1"></i>Not Achieved</span></td>
                @endif
            </tr>
            @endforeach
    </tbody>
</table>

<p class="mb-2">Notes &amp; Recommendations:</p>
<table class="table table-striped table-sm border bg-white">
    <thead class="thead-main text-nowrap">
        <tr class="text-uppercase font-11">
            <th class="pl-3">From</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detrevnot as $no => $n)
        <tr>
            <td class="pl-3 text-left text-nowrap">{{$n->from}}</td>
            <td class="pr-5">{{$n->description}}</td>
        </tr>
        @endforeach
    </tbody>
</table>                           