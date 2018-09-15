<?php


namespace App\Services;

use App\Contracts\Facebook;

/**
 * Class FacebookService
 * @package App\Services
 */
class FacebookService implements Facebook
{
    private $fb;
    private $accessToken;

    /**
     * FacebookService constructor.
     */
    public function __construct()
    {
        $this->fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_SECRET'),
            'default_graph_version' => 'v2.5'
        ]);

        $helper = $this->fb->getJavaScriptHelper();
        $this->accessToken = $helper->getAccessToken();

        \Log::info('Facebook access token: ' . $this->accessToken);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getProfileData()
    {
        $fields = ['id', 'email'];

        $fb = $this->fb;

        if (!isset($this->accessToken)) {
            throw new \Exception('No cookie set or no OAuth data could be obtained from cookie.');
        }

        $profileResponse = $fb->get(
            '/me?fields=' . implode(',', $fields),
            $this->accessToken
        );

        $profileData = $profileResponse->getDecodedBody();

        if (in_array('picture', $fields)) {
            $pictureResponse = $fb->get(
                '/me/picture?redirect=false',
                $this->accessToken
            );

            $profileData['url'] = $pictureResponse->getDecodedBody()['data']['url'];
        }

        if (!$profileData) {
            throw new \Exception('Failed login with Facebook');
        }

        return $profileData;
    }

    /**
     * @throws \Exception
     * @return  string
     */
    public function getEmail()
    {
        return $this->getProfileData()['email'];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getId()
    {
        return $this->getProfileData()['id'];
    }

    /**
     * Revoke all permissions on account disconnect
     */
    public function revokePermissions()
    {
        $this->fb->delete("/me/permissions", [], $this->accessToken);
    }
}
