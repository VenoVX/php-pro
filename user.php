<?php
/**
 * Created by PhpStorm.
 * User: sauer
 * Date: 19.10.16
 * Time: 09:46
 */

namespace user;


class user
{
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $password;
    protected $street;
    protected $houseNumber;
    function __construct($firstName, $lastName, $email, $password, $street, $houseNumber)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
    }

    /**
     * @var string firstName;
     */
    protected $firstName;
    /**
     * @var string lastName;
     */
    protected $lastName;


}