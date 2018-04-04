<?php

namespace App\Library\Integra;

class WSLogin extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array(
        'getPermissions' => 'App\\Library\\Integra\\getPermissions',
        'getPermissionsResponse' => 'App\\Library\\Integra\\getPermissionsResponse',
        'wsPermissionResponse' => 'App\\Library\\Integra\\wsPermissionResponse',
        'loginByCurso' => 'App\\Library\\Integra\\loginByCurso',
        'loginByCursoResponse' => 'App\\Library\\Integra\\loginByCursoResponse',
        'wsLoginResponse' => 'App\\Library\\Integra\\wsLoginResponse',
        'login' => 'App\\Library\\Integra\\login',
        'loginResponse' => 'App\\Library\\Integra\\loginResponse',
        'loginByMatricula' => 'App\\Library\\Integra\\loginByMatricula',
        'loginByMatriculaResponse' => 'App\\Library\\Integra\\loginByMatriculaResponse',
        'isValidProfile' => 'App\\Library\\Integra\\isValidProfile',
        'isValidProfileResponse' => 'App\\Library\\Integra\\isValidProfileResponse',
        'getTokenExpiration' => 'App\\Library\\Integra\\getTokenExpiration',
        'getTokenExpirationResponse' => 'App\\Library\\Integra\\getTokenExpirationResponse',
        'isValidToken' => 'App\\Library\\Integra\\isValidToken',
        'isValidTokenResponse' => 'App\\Library\\Integra\\isValidTokenResponse',
        'logout' => 'App\\Library\\Integra\\logout',
        'logoutResponse' => 'App\\Library\\Integra\\logoutResponse',
        'updateUserGroup' => 'App\\Library\\Integra\\updateUserGroup',
        'updateUserGroupResponse' => 'App\\Library\\Integra\\updateUserGroupResponse',
        'getUserInformation' => 'App\\Library\\Integra\\getUserInformation',
        'getUserInformationResponse' => 'App\\Library\\Integra\\getUserInformationResponse',
        'wsUserInfoResponse' => 'App\\Library\\Integra\\wsUserInfoResponse',
        'profileResponse' => 'App\\Library\\Integra\\profileResponse',
        'profile' => 'App\\Library\\Integra\\profile',
        'IntegraSoapServiceException' => 'App\\Library\\Integra\\IntegraSoapServiceException',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null)
    {
        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        $options = array_merge(array(
            'features' => 1,
        ), $options);
        if (!$wsdl) {
            $wsdl = 'http://integra.ufjf.br/integra/services/soap/login/wslogin?wsdl';
        }
        parent::__construct($wsdl, $options);
    }

    /**
     * @param getPermissions $parameters
     * @return getPermissionsResponse
     */
    public function getPermissions(getPermissions $parameters)
    {
        return $this->__soapCall('getPermissions', array($parameters));
    }

    /**
     * @param loginByCurso $parameters
     * @return loginByCursoResponse
     */
    public function loginByCurso(loginByCurso $parameters)
    {
        return $this->__soapCall('loginByCurso', array($parameters));
    }

    /**
     * @param login $parameters
     * @return loginResponse
     */
    public function login(login $parameters)
    {
        return $this->__soapCall('login', array($parameters));
    }

    /**
     * @param isValidProfile $parameters
     * @return isValidProfileResponse
     */
    public function isValidProfile(isValidProfile $parameters)
    {
        return $this->__soapCall('isValidProfile', array($parameters));
    }

    /**
     * @param loginByMatricula $parameters
     * @return loginByMatriculaResponse
     */
    public function loginByMatricula(loginByMatricula $parameters)
    {
        return $this->__soapCall('loginByMatricula', array($parameters));
    }

    /**
     * @param getTokenExpiration $parameters
     * @return getTokenExpirationResponse
     */
    public function getTokenExpiration(getTokenExpiration $parameters)
    {
        return $this->__soapCall('getTokenExpiration', array($parameters));
    }

    /**
     * @param isValidToken $parameters
     * @return isValidTokenResponse
     */
    public function isValidToken(isValidToken $parameters)
    {
        return $this->__soapCall('isValidToken', array($parameters));
    }

    /**
     * @param logout $parameters
     * @return logoutResponse
     */
    public function logout(logout $parameters)
    {
        return $this->__soapCall('logout', array($parameters));
    }

    /**
     * @param updateUserGroup $parameters
     * @return updateUserGroupResponse
     */
    public function updateUserGroup(updateUserGroup $parameters)
    {
        return $this->__soapCall('updateUserGroup', array($parameters));
    }

    /**
     * @param getUserInformation $parameters
     * @return getUserInformationResponse
     */
    public function getUserInformation(getUserInformation $parameters)
    {
        return $this->__soapCall('getUserInformation', array($parameters));
    }

}
