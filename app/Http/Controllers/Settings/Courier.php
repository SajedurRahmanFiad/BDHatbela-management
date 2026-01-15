<?php

namespace App\Http\Controllers\Settings;

use App\Abstracts\Http\SettingController;
use App\Http\Requests\Setting\Setting as Request;

class Courier extends SettingController
{
    public function edit()
    {
        return view('settings.courier.edit');
    }

    public function update(Request $request)
    {
        // Call parent update method
        $response = parent::update($request);

        // Update .env file with the new settings
        $this->updateEnvFile();

        return $response;
    }

    private function updateEnvFile()
    {
        // Read current settings
        $baseUrl = setting('courier.steadfast.base_url') ?? '';
        $apiKey = setting('courier.steadfast.api_key') ?? '';
        $secretKey = setting('courier.steadfast.secret_key') ?? '';

        // Read current .env file
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        // Update the values
        $envContent = preg_replace('/STEADFAST_BASE_URL=.*/', 'STEADFAST_BASE_URL="' . $baseUrl . '"', $envContent);
        $envContent = preg_replace('/STEADFAST_API_KEY=.*/', 'STEADFAST_API_KEY="' . $apiKey . '"', $envContent);
        $envContent = preg_replace('/STEADFAST_SECRET_KEY=.*/', 'STEADFAST_SECRET_KEY="' . $secretKey . '"', $envContent);

        // Write back to .env
        file_put_contents($envFile, $envContent);
    }
}