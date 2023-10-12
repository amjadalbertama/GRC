<?php

namespace App\Library;

use App\Models\Pages;
use App\Models\PageLists;

class GeneratePagesListAndGroup extends Helper
{
    public function generate($request)
    {
        // $pages = Pages::selectRaw("GROUP_CONCAT(CONCAT(page, '::', permission, '::', position)) as pages, page_group")
        //     ->groupBy('page_group', 'position_group')
        //     ->where('is_active', 1)
        //     ->orderBy('position_group')
        //     ->get();

        $pages = Pages::orderByRaw('position_group, position')
            ->where('is_active', 1)
            ->get();

        // print_r(json_decode(json_encode($pages), true));

        foreach($pages as $page) {
            // $data = [
            //     'page' => $page->page,
            //     'permission' => $page->permission
            // ];

            
            $data_pages[$page->position_group]['page_group'] = $page->page_group;
            $data_pages[$page->position_group]['data'][] = [
                'page' => $page->page,
                'permission' => $page->permission
            ];
        }
        // exit;
        $page_lists = PageLists::find(1);
        if ($page_lists !== null) {
            $page_lists->page_lists = json_encode($data_pages);
            $page_lists->save();
        } else {
            $page_lists = new PageLists;
            $page_lists->page_lists = json_encode($data_pages);
            $page_lists->save();            
        }

        // print_r($data_pages);
        // save in db
        $request->session()->put('pages', $data_pages);
    }
}
