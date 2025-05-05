<?php

namespace Aaran\ExternalPartners\MasterGst\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\Transport;
use Aaran\BMS\Billing\Master\Models\Company;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Aaran\ExternalPartners\MasterGst\Services\MasterGstAuthService;
use Aaran\ExternalPartners\MasterGst\Services\MasterGstEInvoiceService;
use Livewire\Component;

class Authenticate extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public $email = 'aaranoffice@gmail.com';
    public $authToken;
    public $responseData;

    protected MasterGstEInvoiceService $authService;

    public function boot(MasterGstEInvoiceService $authService): void
    {
        $this->authService = $authService;
    }

    public function authenticate()
    {
        try {
            $payload = $this->buildEinvoicePayload();
            $response =  $this->authService->generateEinvoice($payload);

            dd($response);
            session()->flash('success', 'Authenticated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Authentication failed: ' . $e->getMessage());
        }
    }


    public function buildEinvoicePayload(): array
    {
        $connection = $this->getTenantConnection();

        $company = Company::on($connection)->find(session()->get('company_id'));
        $contact = Contact::on($connection)->find('1');
        $contactDetail = ContactAddress::on($connection)->where('contact_id', '1')->first();
        $documentDate = date('d/m/Y', strtotime(now()));
        $transport = Transport::on($connection)->find('1');

        return [
            "Version" => "1.1",
            "TranDtls" => [
                "TaxSch" => "GST",
                "SupTyp" => "B2B",
            ],
            "DocDtls" => [
                "Typ" => "INV",
                "No" => "sk/12",
                "Dt" => (string) ($documentDate),
            ],
            "SellerDtls" => [
                "Gstin" => "29AABCT1332L000",
                "LglNm" => "ABC company pvt ltd",
                "TrdNm" => "NIC Industries",
                "Addr1" => "5th block, kuvempu layout",
                "Addr2" => "kuvempu layout",
                "Loc" => "GANDHINAGAR",
                "Pin" => 560001,
                "Stcd" => "29",
                "Ph" => "9000000000",
                "Em" => "abc@gmail.com",
            ],
            "BuyerDtls" => [
                "Gstin" => "29AWGPV7107B1Z1",
                "LglNm" => "XYZ company pvt ltd",
                "TrdNm" => "XYZ Industries",
                "Pos" => "37",
                "Addr1" => "7th block, kuvempu layout",
                "Addr2" => "kuvempu layout",
                "Loc" => "GANDHINAGAR",
                "Pin" => 560004,
                "Stcd" => "29",
                "Ph" => "9000000000",
                "Em" => "abc@gmail.com",
            ],
            "DispDtls" => [
                "Nm" => "ABC company pvt ltd",
                "Addr1" => "7th block, kuvempu layout",
                "Addr2" => "kuvempu layout",
                "Loc" => "Banagalore",
                "Pin" => 518360,
                "Stcd" => "37",
            ],
            "ShipDtls" => [
                "Gstin" => "29AWGPV7107B1Z1",
                "LglNm" => "CBE company pvt ltd",
                "TrdNm" => "kuvempu layout",
                "Addr1" => "7th block, kuvempu layout",
                "Addr2" => "kuvempu layout",
                "Loc" => "Banagalore",
                "Pin" => 518360,
                "Stcd" => "37",
            ],
            "ValDtls" => [
                "AssVal" => 9978.84,
                "CgstVal" => 0,
                "SgstVal" => 0,
                "IgstVal" => 1197.46,
                "CesVal" => 508.94,
                "StCesVal" => 1202.46,
                "Discount" => 10,
                "OthChrg" => 20,
                "RndOffAmt" => 0.3,
                "TotInvVal" => 12908,
                "TotInvValFc" => 12897.7,
            ],
            "EwbDtls" => [
                "Transid" => "12AWGPV7107B1Z1",
                "Transname" => "XYZ EXPORTS",
                "Distance" => 100,
                "Transdocno" => "sk/10",
                "TransdocDt" => date('d/m/Y', strtotime(now())),
                "Vehno" => "ka123456",
                "Vehtype" => "R",
                "TransMode" => "1",
            ]
        ];
    }



    public function render()
    {
        return view('mastergst::authenticate');
    }
}
