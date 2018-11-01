<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\Provider;
use App\User;
class SocialAuthController extends Controller
{
	/**
	* Redirect the user to the provider authentication page.
	*
	* @return \Illuminate\Http\Response
	*/
	public function redirectToProvider($provider)
	{
	  	return Socialite::driver($provider)->redirect();
	}

	/**
	* Obtain the user information from GitHub.
	*
	* @return \Illuminate\Http\Response
	*/
	public function handleProviderCallback($provider)
	{

	    $user = Socialite::driver($provider)->user();
	    
	    // All Providers
		// $user->getId();
		// $user->getNickname();
		// $user->getName();
		// $user->getEmail();
		// $user->getAvatar();

	    $userProvider = Provider::where('provider_id' , $user->getId())->first();

	    if($userProvider){
	    	$existUser = User::find($userProvider->user_id);
	    }else{
	    	$existUser = User::where('email' , $user->getEmail())->first();
	    	
	    	if(!$existUser){
	    		$existUser = new User();
	    		$existUser->username = $user->getName();
	    		$existUser->email = $user->getEmail();
	    		$existUser->password = Hash::make($user->getId());
	    		$existUser->save();
	    	}

	    	$userProvider = new Provider();
	    	$userProvider->provider_id = $user->getId();
	    	$userProvider->provider = $provider;
	    	$userProvider->user_id = $existUser->id;
	    	$userProvider->save();
	    }

	    auth()->login($existUser);
	    return redirect('/');
	}
}
