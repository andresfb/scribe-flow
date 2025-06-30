<?php

namespace App\Http\Controllers\api\v1\PieceStatuses;

use App\Actions\PieceStatuses\PieceStatusesListAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;

class PieceStatusListController extends Controller
{
    use ApiResponses;

    public function __invoke(PieceStatusesListAction $action)
    {
        return $this->ok(
            'List Piece Statuses',
            $action->handle()
        );
    }
}
