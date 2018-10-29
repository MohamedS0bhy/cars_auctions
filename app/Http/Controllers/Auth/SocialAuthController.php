<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
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
      dd($user);
      // $user->token;
  }
}
