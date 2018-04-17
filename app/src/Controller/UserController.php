<?php

namespace App\Controller;

use App\Library\Integra\getUserInformation;
use App\Library\Integra\getUserInformationResponse;
use App\Library\Integra\login;
use App\Library\Integra\logout;
use App\Library\Integra\WSLogin;
use App\Library\Integra\wsUserInfoResponse;
use App\Model\Certificado;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController
{
    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

}
