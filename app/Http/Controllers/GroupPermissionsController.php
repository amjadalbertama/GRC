<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Utility;


class GroupPermissionsController extends Controller
{
    //
    public function __construct()
    {
        $this->page = 'Group permission';
    }

    public function test(\App\Library\GroupPermissions $userdata)
    {
        // return ('Testing');

        // var_dump($userdata->hasPermission('view policies'));
        return view('test.data');
    }

    public function test_utility()
    {
        Utility::echo();
        // string('page')
        // integer('page_id')
        // integer('doc_id')
        // string('action')
        // integer('actor')
        // integer('created_by')
        // string('notes')
        Utility::log(['page' => 'test page']);
        Utility::notif([
            'name' => 'Awaludin',
            'email' => 'awaludin@aturtoko.id',
            'subject' => 'Permintaan Review',
            'message' => 'Anda mendapat permintaan review ' . 'https://google.com' 
        ], true, '081299843038');

        Utility::whatsapp([
            'sent_to' => '081299843038', // put valid number
            'message' => 'this is WA message'
        ]);
    }
}
