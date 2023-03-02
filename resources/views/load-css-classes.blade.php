<x-app-layout>
  {{-- 
    This is just here so the auto compiler always includes 
    these classes, that might be called via the db, so they 
    need to be included in our css. 
  --}}
  <div class="alert-info text-info-content" />
  <div class="alert-success text-success-content" />
  <div class="alert-warning text-warning-content" />
  <div class="alert-error text-error-content" />

  <div class="bg-primary text-primary-content" />
  <div class="bg-secondary text-secondary-content" />
  <div class="bg-accent text-accent-content" />
  <div class="bg-neutral text-neutral-content" />


</x-app-layout>
