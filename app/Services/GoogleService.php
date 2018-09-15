<?php

namespace App\Services;

use App\Contracts\Google;

/**
 * Class GoogleService
 * @package App\Services
 */
class GoogleService implements Google
{

    /**
     * @param null $token
     * @return \Google_Service_Oauth2_Userinfoplus
     * @throws \Exception
     */
    public function getProfileData($token = null)
    {
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));

        if (empty($token)) {
            throw new \Exception('Access token is required');
        }

        $payload = $client->verifyIdToken($token)->getAttributes()['payload'];

        return [
            'id' => $payload['sub'],
            'email' => $payload['email']
        ];
    }

    /**
     * @throws \Exception
     * @return  string
     */
    public function getEmail()
    {
        //return $this->getProfileData($token)['email'];
    }

    /**
     *
     */
    public function getId()
    {
        //return $this->getProfileData($token)['id'];
    }

    public function revokePermissions()
    {
        // TODO: Implement revokePermissions() method.
    }

}