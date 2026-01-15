@extends('layouts.admin')

@section('content')

<div id="success-msg" class="text-green-800 h-5 font-bold"></div>


<div class="flex justify-between items-center py-4">
  <div class="max-w-sm w-full space-y-3">
    <input type="text" id="search" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 
    dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Rechercher">
  </div>

  <button type="button" id="openModal" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white 
  hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
    aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-slide-down-animation-modal"
    data-hs-overlay="#hs-slide-down-animation-modal">
    {{ __('note.views.add_note') }}
  </button>
</div>


<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="overflow-hidden border border-gray-200 dark:border-neutral-700 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
          <thead class="bg-gray-50 dark:bg-neutral-800">
            <tr>
              <th scope="col"
                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"> Image
              </th>
              <th scope="col"
                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"> Nom
              </th>
              <th scope="col"
                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"> Contenu
              </th>
              <th scope="col"
                class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"> Categories
              </th>
            </tr>
          </thead>
          <tbody id="notes-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
            @include('admin.notes._table_body')
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@include('admin.notes._modal')