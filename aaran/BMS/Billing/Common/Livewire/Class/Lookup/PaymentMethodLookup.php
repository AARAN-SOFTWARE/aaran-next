<?php

namespace Aaran\BMS\Billing\Common\Livewire\Class\Lookup;

use Aaran\Assets\Enums\PaymentMethod;
use Livewire\Attributes\On;
use Livewire\Component;

class PaymentMethodLookup extends Component
{
    public $search = '';
    public $results = [];
    public $highlightIndex = 0;
    public $showDropdown = false;
    public $showCreateModal = false;

    public $initId;

    public function mount($initId = null): void
    {
        $this->initId = $initId;

        if ($initId) {
            $enumCase = PaymentMethod::tryFrom($initId);
            if ($enumCase) {
                $this->search = $enumCase->getName(); // Or name(), depending on your enum
            }
        } else {
            $this->search = '';
        }
    }

    public function updatedSearch(): void
    {
        $this->searchBy();
    }

    public function searchBy(): void
    {
        $searchTerm = strtolower(trim($this->search));

        $filtered = collect(PaymentMethod::cases())
            ->filter(function ($case) use ($searchTerm) {
                return str_contains(strtolower($case->getName()), $searchTerm);
            })
            ->map(function ($case) {
                return [
                    'id' => $case->value,
                    'vname' => $case->getName()
                ];
            });

        $this->results = $filtered->values()->all();
        $this->highlightIndex = 0;
        $this->showDropdown = true;
    }


    public function incrementHighlight(): void
    {
        if ($this->highlightIndex < count($this->results) - 1) {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight(): void
    {
        if ($this->highlightIndex > 0) {
            $this->highlightIndex--;
        }
    }

    public function selectHighlighted(): void
    {
        $selected = $this->results[$this->highlightIndex] ?? null;
        if ($selected) {
            $this->selectItem($selected);
        }
    }

    public function selectItem($obj): void
    {
        if (is_array($obj)) {
            $id = $obj['id'];
            $name = $obj['vname'];
        } elseif (is_object($obj) && isset($obj->id) && isset($obj->vname)) {
            $id = $obj->id;
            $name = $obj->vname;
        } else {
            // assume it's the enum value (int)
            $id = (int) $obj;
            $case = PaymentMethod::tryFrom($id);
            $name = $case?->getName() ?? 'Unknown';
        }

        $this->search = $name;
        $this->results = [];
        $this->showDropdown = false;

        $this->dispatch('refresh-payment-method', $id);
    }


    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    #[On('refresh-payment-method-lookup')]
    public function refreshItem($value): void
    {
        $enumCase = PaymentMethod::tryFrom((int)$value);
        $this->search = $enumCase?->getName() ?? '';
        $this->showCreateModal = false;
    }

    public function render()
    {
        return view('common::lookup.payment-method-lookup');
    }
}
