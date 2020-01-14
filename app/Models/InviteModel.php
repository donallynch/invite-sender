<?php

namespace App\Models;

use App\Services\DistanceCalculator;
use App\Services\EmailSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class InviteModel
 * @package App\Models
 */
class InviteModel
{
    /** @var DistanceCalculator $distanceCalculator */
    private $distanceCalculator;

    /** @var EmailSender $emailSender */
    private $emailSender;

    /** @var double $maxDistance */
    private $maxDistance;

    /**
     * InviteModel constructor.
     * @param DistanceCalculator $distanceCalculator
     * @param EmailSender $emailSender
     */
    public function __construct(
        DistanceCalculator $distanceCalculator,
        EmailSender $emailSender
    ){
        $this->distanceCalculator = $distanceCalculator;
        $this->emailSender = $emailSender;

        /* Get config */
        $this->maxDistance = config('app.MAXIMUM_DISTANCE');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function invite(Request $request)
    {
        /* Validate */
        $validator = Validator::make($request->post(), [
            'markers' => 'required|array'
        ]);

        if ($validator->fails()) {
            return json_encode(['status' => 400, 'errors' => $validator->errors()]);
        }

        /* Retrieve markers from request object */
        $markers = $request->post('markers', []);
        $users = [];
        $totalCount = 0;
        $skipCount = 0;

        /* Foreach Markers */
        foreach ($markers as $i => $item) {

            /* Determine if User is within range */
            $distanceKm = $this->distanceCalculator->get([
                'lat' => $item['lat'],
                'lng' => $item['lng']
            ]);

            /* If Within Range */
            if ($distanceKm < $this->maxDistance) {
                /**
                 * Mock process of retrieving User row from database
                 *  because even though this is supposed to reflect what would go into production
                 *  I do not want any emails to be sent for privacy reasons.
                 *
                 *  In reality, I would make a call to the database to retrieve the associated User (where user.id = $item['user_id'])
                 *  and the resulting entity would contain the associated email address.
                 */
                $user = $item;
                $user['email'] = 'donal.lynch_msc@yahoo.ie';
                $user['distance'] = "{$distanceKm}";
                $users[] = $user;

                /* Send email to User */
                $this->emailSender->send($user);
            } else {
                $skipCount++;
            }

            $totalCount++;
        }

        /**
         * Return a rendered template identifying which Users were sent the email
         */
        return [
            'status' => 200,
            'html' => view('invites.list', [
                'invites' => $users,
                'totalCount' => $totalCount,
                'skipCount' => $skipCount,
                'maxDistance' => $this->maxDistance
            ])->render()];
    }
}

