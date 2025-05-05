<?php

namespace Aaran\ExternalPartners\MasterGst\Livewire\Class;

use Aaran\ExternalPartners\MasterGst\Services\MasterGstAuthService;
use Aaran\ExternalPartners\MasterGst\Services\MasterGstEInvoiceService;
use Livewire\Component;

class Authenticate extends Component
{
    public $email = 'aaranoffice@gmail.com';
    public $authToken;
    public $responseData;

    protected MasterGstAuthService $authService;

    public function boot(MasterGstAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function authenticate()
    {
        try {
            $data = $this->authService->getAccessToken();

            $this->responseData = $data;
            dd($data);
            session()->flash('success', 'Authenticated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Authentication failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('mastergst::authenticate');
    }
}
