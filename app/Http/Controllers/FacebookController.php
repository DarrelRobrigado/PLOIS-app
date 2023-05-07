<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;

class FacebookController extends Controller
{
    public function facebookCallback(Request $request)
{
    // Initialize the Facebook SDK
    $fb = new Facebook([
        'app_id' => env('214285901332902'),
        'app_secret' => env('53d2599a63bb25c51467753ee898cbd0'),
        'default_graph_version' => 'v11.0',
    ]);

    // Get the access token from the Facebook SDK
    try {
        $accessToken = $fb->getAccessTokenFromRedirect();
    } catch (FacebookResponseException $e) {
        // When Graph returns an error
        return redirect('/login')->with('error', 'Facebook Graph returned an error: ' . $e->getMessage());
    } catch (FacebookSDKException $e) {
        // When validation fails or other local issues
        return redirect('/login')->with('error', 'Facebook SDK returned an error: ' . $e->getMessage());
    }

    // Check if access token exists
    if (!isset($accessToken)) {
        return redirect('/login')->with('error', 'Access token not found.');
    }

    // Check if access token is valid
    if (!$accessToken->isLongLived()) {
        // Exchange short-lived access token for long-lived one
        try {
            $accessToken = $fb->getOAuth2Client()->getLongLivedAccessToken($accessToken);
        } catch (FacebookSDKException $e) {
            return redirect('/login')->with('error', 'Error exchanging short-lived access token for long-lived one: ' . $e->getMessage());
        }
    }

    // Set access token on Facebook SDK
    $fb->setDefaultAccessToken($accessToken);

    // Get user info from Facebook API
    try {
        $response = $fb->get('/me?fields=name,email');
        $userNode = $response->getGraphUser();
    } catch (FacebookResponseException $e) {
        return redirect('/login')->with('error', 'Error getting user info from Facebook Graph: ' . $e->getMessage());
    } catch (FacebookSDKException $e) {
        return redirect('/login')->with('error', 'Error getting user info from Facebook SDK: ' . $e->getMessage());
    }

    // Get user data
    $email = $userNode->getEmail();
    $name = $userNode->getName();
    $password = bcrypt(str_random(10)); // Generate a random password

    // Create a new user or find an existing one
    $user = User::where('email', $email)->first();
    if (!$user) {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }

    // Log in the user
    Auth::login($user);

    // Redirect the user to the intended page
    return redirect()->intended('/');
}
}