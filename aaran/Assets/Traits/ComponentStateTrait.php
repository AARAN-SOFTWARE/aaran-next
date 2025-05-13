<?php

namespace Aaran\Assets\Traits;

use Livewire\WithPagination;

trait ComponentStateTrait
{
    use WithPagination;

    protected $queryString = ['page'];

    public mixed $page;

    public bool $showEditModal = false;
    public bool $showFilters = false;
    public bool $showDeleteModal = false;
    public mixed $deleteId = null;
    public bool $sortAsc = true;

    public string $perPage = "50";
    public string $searches = "";
    public string $sortField = 'id';
    public string $activeRecord = "1";

    public ?int $vid = null;

    public function toggleShowFilters(): void
    {
        $this->showFilters = !$this->showFilters;
    }

    public function sortBy(string $field): void
    {
        $this->sortAsc = $this->sortField === $field ? !$this->sortAsc : true;
        $this->sortField = $field;
    }

    public function resetFilters(): void
    {
        $this->activeRecord = '1';
        $this->resetPage();
        $this->showFilters = false;
    }

    public function edit($id): void
    {
        $this->clearFields();
        $this->getObj($id);
        $this->showEditModal = true;
        $this->showFilters = false;
    }

    public function create(): void
    {
        $this->clearFields();
        $this->showEditModal = true;
        $this->showFilters = false;
    }

    public function save(): void
    {
        $this->getSave();
        $this->clearFields();
        $this->showEditModal = false;
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deleteFunction($this->deleteId);
        $this->deleteId = null;
        $this->dispatch('notify', ...['type' => 'error', 'content' => 'Deleted Successfully']);
    }
}
