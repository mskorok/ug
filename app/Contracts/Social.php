<?php
namespace App\Contracts;

/**
 * Interface Social
 * @package App\Contracts
 */
interface Social
{
    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return array
     * @throws \Exception
     */
    public function getProfileData();

    /**
     * @return string
     */
    //public function getProfileLink();

    /**
     * Revoke all permissions related to specified user
     * @return mixed
     */
    public function revokePermissions();
}
