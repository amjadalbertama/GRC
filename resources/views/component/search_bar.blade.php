<form class="mb-30" id="form_search_data" method="POST">
    @csrf
    <div class="input-group">
        <input class="form-control form-control-sm border-right-0 border" type="search" placeholder="Search..." id="search_data" name="search_data">
        <span class="input-group-append">
            <button class="input-group-text bg-white border-left-0 border"><i class="fa fa-search text-grey"></i></button>
        </span>
    </div>
</form>