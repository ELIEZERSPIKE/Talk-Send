<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function register(array $data);
    public function login(array $data);
    public function checkOtpCode(array $data);
    public function   Groupregister(array $data);
     public function Invite(array $data);
     public function file(array $data);

    //  public function show_files($goupId);

}
