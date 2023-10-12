<div class="table table-responsive">
    <table class="table table-striped table-sm border bg-white">
        <thead class="thead-main text-nowrap">
            <tr class="text-uppercase font-11">
                <th class="pl-3">Status</th>
                <th>ID</th>
                <th>Smart Objectives</th>
                <th>Category</th>
                <th>ORGANIZATION</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-nowrap">
            @foreach ($objective as $no => $k)
            <tr>
                <td class="pl-3">
                    <span class="{{$k->status_mapping->style}}">
                        <i class="fa fa-circle mr-1"></i>
                        {{$k->status_mapping->status}}
                    </span>
                </td>
                <td>{{ $k->id }}</td>
                <td class="w-500px pr-5">

                    @if($access['approval'] == true && $k->status != 5 || $access['reviewer'] == true && $k->status != 5)
                    <a class="d-block truncate-text_500" href="javascript:void(0);" data-toggle="modal" data-target="#approveModal-{{$k->id}}" title="Check">{{ $k->smart_objectives }}</a>
                    @else
                    <a class="d-block truncate-text_500" href="javascript:void(0);" data-toggle="modal" data-target="#detailModal-{{$k->id}}" title="Check">{{ $k->smart_objectives }}</a>
                    @endif

                </td>
                <td class="truncate-text">
                    {{ $k->category->title }}
                </td>
                <td>
                    @foreach ($organization as $no => $org)
                    <?php
                    if ($org->id == $k->id_organization) {
                        echo $org->name_org;
                    }
                    ?>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>