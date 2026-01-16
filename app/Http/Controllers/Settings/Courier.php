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
        $fields = $request->all();

        // Handle Steadfast settings
        if (isset($fields['steadfast_base_url'])) {
            setting()->set('courier.steadfast.base_url', $fields['steadfast_base_url']);
        }
        if (isset($fields['steadfast_api_key'])) {
            setting()->set('courier.steadfast.api_key', $fields['steadfast_api_key']);
        }
        if (isset($fields['steadfast_secret_key'])) {
            setting()->set('courier.steadfast.secret_key', $fields['steadfast_secret_key']);
        }

        // Handle CarryBee settings
        if (isset($fields['carrybee_base_url'])) {
            setting()->set('courier.carrybee.base_url', $fields['carrybee_base_url']);
        }
        if (isset($fields['carrybee_client_id'])) {
            setting()->set('courier.carrybee.client_id', $fields['carrybee_client_id']);
        }
        if (isset($fields['carrybee_client_secret'])) {
            setting()->set('courier.carrybee.client_secret', $fields['carrybee_client_secret']);
        }
        if (isset($fields['carrybee_client_context'])) {
            setting()->set('courier.carrybee.client_context', $fields['carrybee_client_context']);
        }

        // Save all settings
        setting()->save();

        // Update .env file with the new settings
        $this->updateEnvFile();

        $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

        flash($message)->success();

        return redirect()->back();
    }

    private function updateEnvFile()
    {
        // Read current settings
        $baseUrl = setting('courier.steadfast.base_url') ?? '';
        $apiKey = setting('courier.steadfast.api_key') ?? '';
        $secretKey = setting('courier.steadfast.secret_key') ?? '';

        $carrybeeBaseUrl = setting('courier.carrybee.base_url') ?? '';
        $carrybeeClientId = setting('courier.carrybee.client_id') ?? '';
        $carrybeeClientSecret = setting('courier.carrybee.client_secret') ?? '';
        $carrybeeClientContext = setting('courier.carrybee.client_context') ?? '';

        // Read current .env file
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        // Update the values
        $envContent = preg_replace('/STEADFAST_BASE_URL=.*/', 'STEADFAST_BASE_URL="' . $baseUrl . '"', $envContent);
        $envContent = preg_replace('/STEADFAST_API_KEY=.*/', 'STEADFAST_API_KEY="' . $apiKey . '"', $envContent);
        $envContent = preg_replace('/STEADFAST_SECRET_KEY=.*/', 'STEADFAST_SECRET_KEY="' . $secretKey . '"', $envContent);

        $envContent = preg_replace('/CARRYBEE_BASE_URL=.*/', 'CARRYBEE_BASE_URL="' . $carrybeeBaseUrl . '"', $envContent);
        $envContent = preg_replace('/CARRYBEE_CLIENT_ID=.*/', 'CARRYBEE_CLIENT_ID="' . $carrybeeClientId . '"', $envContent);
        $envContent = preg_replace('/CARRYBEE_CLIENT_SECRET=.*/', 'CARRYBEE_CLIENT_SECRET="' . $carrybeeClientSecret . '"', $envContent);
        $envContent = preg_replace('/CARRYBEE_CLIENT_CONTEXT=.*/', 'CARRYBEE_CLIENT_CONTEXT="' . $carrybeeClientContext . '"', $envContent);

        // Write back to .env
        file_put_contents($envFile, $envContent);
    }
}