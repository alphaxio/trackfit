<?php

namespace App\Services;

use Exception;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;
use SocialAccountsService;

// use Laravel\Socialite\Two\User as ProviderUser;

class SocialUserResolver implements SocialUserResolverInterface
{
    /**
     * Resolve user by provider credentials.
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        $providerUser = null;

        try{
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);

        }catch(Exception $exception) {}

        if($providerUser){
            return (new SocialAccountsService())->findOrCreate($providerUser, $provider);
        }
        return null;
    }




    protected function findOrCreateUser(string $provider, ProviderUser $providerUser): ?Authenticatable
    {
        // todo your logic here
        // $email = $providerUser->getEmail();
    }
}
