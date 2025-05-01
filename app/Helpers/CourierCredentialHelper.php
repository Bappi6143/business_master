<?php 

namespace App\Helpers;

use App\Models\DeliveryPartner;

class CourierCredentialHelper
{
    /**
     * Get Steadfast Credentials
     * 
     * @return array
     */
    public static function getSteadfastCredentials(): array
    {
        $steadfastPartner = DeliveryPartner::where('slug', 'steadfast')->first();

        if ($steadfastPartner && $steadfastPartner->credentials) {
            $raw = $steadfastPartner->credentials;

            if (is_string($raw)) {
                $credentials = json_decode($raw, true);
            } elseif (is_array($raw)) {
                $credentials = $raw;
            } else {
                $credentials = [];
            }

            return [
                'api_key'    => $credentials['api_key'] ?? '',
                'secret_key' => $credentials['secret_key'] ?? '',
            ];
        }

        return [
            'api_key'    => '',
            'secret_key' => '',
        ];
    }

    /**
     * Get RedX Credentials
     * 
     * @return array
     */
    public static function getRedxCredentials()
    {
        // Fetch RedX partner credentials from the database
        $redxPartner = DeliveryPartner::where('slug', 'redx')->first();

        if ($redxPartner && $redxPartner->credentials) {
            // Check if credentials are already an array, if not, decode it
            $credentials = is_array($redxPartner->credentials) ? $redxPartner->credentials : json_decode($redxPartner->credentials, true);

            return [
                'api_token' => $credentials['jwt_token'] ?? '',
            ];
        }

        return [];
    }
}
 