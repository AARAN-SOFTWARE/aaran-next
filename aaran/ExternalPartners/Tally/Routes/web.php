<?php

use Aaran\ExternalPartners\Tally\Livewire\Class;
use Illuminate\Support\Facades\Route;


Route::get('/tally', Class\TallyHandshake::class)->name('tally');

