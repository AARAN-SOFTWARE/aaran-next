<?php

namespace Aaran\ExternalPartners\Tally\Livewire\Class;

use Aaran\ExternalPartners\Tally\Services\TallyService;
use Livewire\Component;

class TallyHandshake extends Component
{
    public array $response = [];

    public function mount()
    {
        $this->handshakeWithTally();
    }

    public function handshakeWithTally()
    {
        $xml = <<<XML
            <ENVELOPE>
            <HEADER>
            <TALLYREQUEST>Export</TALLYREQUEST>
            <TYPE>Data</TYPE>
            <ID>Company Info</ID>
            </HEADER>
            <BODY>
            <DESC>
              <STATICVARIABLES>
                <SVCURRENTCOMPANY />
              </STATICVARIABLES>
            </DESC>
            </BODY>
            </ENVELOPE>
            XML;

        $service = new TallyService();
        $this->response = $service->sendRequest($xml);
    }

    public function render()
    {
        return view('tally::tally-handshake');
    }
}
