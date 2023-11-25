<?php

use App\Models\User;
use App\Models\SocialAccount;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Two\User as ProviderUser;

class SocialAccountsService {

    public function findOrCreate(ProviderUser $providerUser, string $provider)
    {
        $socialAccount = SocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if($socialAccount) {
            return $socialAccount->user;
        } else {
            $user = null;
            if($email = $providerUser->getEmail())
            {
                $user = User::where('email', $email)->first();
            }
            if(! $user) {
                $user = User::create([
                    'names' => $providerUser->getName(),
                    'email' => $providerUser->getEmail()
                ]);
            }
            $role = Role::where('name', 'USER')->firstorFail();
            $user->assignRole($role);

            $user->socialAccounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider
            ]);
            return $user;
        }

    }
}
