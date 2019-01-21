<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use MycompanyMainBundle\Entity\Image;


class TokenAuthenticator
{

	public $token;
    public $repository;


    public function checkToken()
    {      
        $check = $this->repository->findBy(["apiToken" => $this->token]);

        if (empty($check)){
        	return false;
        } else {
        	return true;
        }
    }


    public function generateToken()
    {
      	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   		$token = '';
   		$length = 50;

	    for($i=0; $i<$length; $i++){
	        $token .= $chars[rand(0, strlen($chars)-1)];
	    }

	    return $token;  	
    }


    public function checkIfAdmin($token)
    {
    	$check = $this->repository->findBy([
    		"apiToken" => $token,
    		"admin" => 1
    	]);	

    	if(empty($check)){
    		return false;
    	}
    	return true;
    }

}