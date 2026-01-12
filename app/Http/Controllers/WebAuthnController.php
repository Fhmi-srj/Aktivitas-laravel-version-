<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WebAuthnCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class WebAuthnController extends Controller
{
    /**
     * Generate options for registering a new credential
     */
    public function registerOptions(Request $request)
    {
        $user = Auth::user();
        
        // Generate a random challenge
        $challenge = random_bytes(32);
        Session::put('webauthn_challenge', base64_encode($challenge));
        
        return response()->json([
            'status' => 'success',
            'publicKey' => [
                'challenge' => $this->base64UrlEncode($challenge),
                'rp' => [
                    'name' => config('app.name'),
                    'id' => parse_url(config('app.url'), PHP_URL_HOST),
                ],
                'user' => [
                    'id' => $this->base64UrlEncode($user->id . ''),
                    'name' => $user->email ?? $user->username,
                    'displayName' => $user->name,
                ],
                'pubKeyCredParams' => [
                    ['type' => 'public-key', 'alg' => -7], // ES256
                    ['type' => 'public-key', 'alg' => -257], // RS256
                ],
                'authenticatorSelection' => [
                    'authenticatorAttachment' => 'platform', // platform = built-in (fingerprint/face)
                    'userVerification' => 'required',
                ],
                'timeout' => 60000,
                'attestation' => 'none',
            ],
        ]);
    }

    /**
     * Verify and store the new credential
     */
    public function registerVerify(Request $request)
    {
        $user = Auth::user();
        
        try {
            $credentialId = $request->input('id');
            $clientDataJSON = $request->input('response.clientDataJSON');
            $attestationObject = $request->input('response.attestationObject');
            
            // Decode client data
            $clientData = json_decode(base64_decode($this->base64UrlDecode($clientDataJSON)), true);
            
            // Verify challenge
            $storedChallenge = Session::get('webauthn_challenge');
            $receivedChallenge = $this->base64UrlDecode($clientData['challenge']);
            
            if (base64_encode($receivedChallenge) !== $storedChallenge) {
                return response()->json(['status' => 'error', 'message' => 'Challenge verification failed'], 400);
            }
            
            // Decode attestation object (simplified - in production, use proper CBOR parsing)
            $attestation = base64_decode($this->base64UrlDecode($attestationObject));
            
            // Extract public key (simplified)
            // In production, use proper CBOR decoding library
            $publicKey = base64_encode($attestation);
            
            // Get device name from user agent
            $deviceName = $this->getDeviceName($request->header('User-Agent'));
            
            // Store credential
            WebAuthnCredential::create([
                'user_id' => $user->id,
                'credential_id' => $credentialId,
                'public_key' => $publicKey,
                'sign_count' => 0,
                'device_name' => $deviceName,
            ]);
            
            // Enable biometric for user
            $user->update(['biometric_enabled' => true]);
            
            Session::forget('webauthn_challenge');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Biometric berhasil didaftarkan!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendaftarkan biometric: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate options for login
     */
    public function loginOptions(Request $request)
    {
        $username = $request->input('username');
        
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->first();
        
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan'], 404);
        }
        
        $credentials = $user->webAuthnCredentials ?? WebAuthnCredential::where('user_id', $user->id)->get();
        
        if ($credentials->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Tidak ada biometric terdaftar'], 404);
        }
        
        // Generate challenge
        $challenge = random_bytes(32);
        Session::put('webauthn_challenge', base64_encode($challenge));
        Session::put('webauthn_user_id', $user->id);
        
        $allowCredentials = $credentials->map(function ($cred) {
            return [
                'type' => 'public-key',
                'id' => $cred->credential_id,
            ];
        })->toArray();
        
        return response()->json([
            'status' => 'success',
            'publicKey' => [
                'challenge' => $this->base64UrlEncode($challenge),
                'rpId' => parse_url(config('app.url'), PHP_URL_HOST),
                'allowCredentials' => $allowCredentials,
                'userVerification' => 'required',
                'timeout' => 60000,
            ],
        ]);
    }

    /**
     * Verify login credential
     */
    public function loginVerify(Request $request)
    {
        try {
            $credentialId = $request->input('id');
            $clientDataJSON = $request->input('response.clientDataJSON');
            $authenticatorData = $request->input('response.authenticatorData');
            $signature = $request->input('response.signature');
            
            // Get stored challenge and user
            $storedChallenge = Session::get('webauthn_challenge');
            $userId = Session::get('webauthn_user_id');
            
            if (!$storedChallenge || !$userId) {
                return response()->json(['status' => 'error', 'message' => 'Session expired'], 400);
            }
            
            // Find credential
            $credential = WebAuthnCredential::where('credential_id', $credentialId)
                ->where('user_id', $userId)
                ->first();
            
            if (!$credential) {
                return response()->json(['status' => 'error', 'message' => 'Credential tidak ditemukan'], 404);
            }
            
            // Verify challenge
            $clientData = json_decode(base64_decode($this->base64UrlDecode($clientDataJSON)), true);
            $receivedChallenge = $this->base64UrlDecode($clientData['challenge']);
            
            if (base64_encode($receivedChallenge) !== $storedChallenge) {
                return response()->json(['status' => 'error', 'message' => 'Challenge verification failed'], 400);
            }
            
            // Update sign count
            $credential->increment('sign_count');
            
            // Login user
            $user = User::find($userId);
            Auth::login($user, true);
            
            Session::forget(['webauthn_challenge', 'webauthn_user_id']);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil!',
                'redirect' => route('user.beranda'),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dismiss biometric reminder
     */
    public function dismissReminder(Request $request)
    {
        $user = Auth::user();
        $user->update(['biometric_reminder_dismissed' => true]);
        
        return response()->json(['status' => 'success']);
    }

    /**
     * Check if device supports biometric
     */
    public function checkSupport(Request $request)
    {
        $user = Auth::user();
        
        $hasCredential = WebAuthnCredential::where('user_id', $user->id)->exists();
        
        return response()->json([
            'biometric_enabled' => $user->biometric_enabled,
            'has_credential' => $hasCredential,
            'reminder_dismissed' => $user->biometric_reminder_dismissed,
        ]);
    }

    /**
     * Delete credential
     */
    public function deleteCredential(Request $request, $id)
    {
        $credential = WebAuthnCredential::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $credential->delete();
        
        // If no more credentials, disable biometric
        $remaining = WebAuthnCredential::where('user_id', Auth::id())->count();
        if ($remaining === 0) {
            Auth::user()->update(['biometric_enabled' => false]);
        }
        
        return response()->json(['status' => 'success', 'message' => 'Device berhasil dihapus']);
    }

    // Helper functions
    private function base64UrlEncode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    private function getDeviceName($userAgent): string
    {
        if (stripos($userAgent, 'iPhone') !== false) return 'iPhone';
        if (stripos($userAgent, 'iPad') !== false) return 'iPad';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Mac') !== false) return 'Mac';
        return 'Unknown Device';
    }
}
