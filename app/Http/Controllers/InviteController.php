<?php

namespace App\Http\Controllers;

use App\Models\InviteModel;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class InviteController
 * @package App\Http\Controllers
 */
class InviteController
{
    /** @var InviteModel $inviteModel */
    private $inviteModel;

    /**
     * InviteController constructor.
     * @param Request $request
     * @param InviteModel $inviteModel
     */
    public function __construct(
        Request $request,
        InviteModel $inviteModel
    ){
        $this->inviteModel = $inviteModel;
    }

    /**
     * @return Factory|View
     */
    public function getAction()
    {
        return view('invites.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAction(Request $request)
    {
        return response()
            ->json($this->inviteModel->invite($request));
    }
}

