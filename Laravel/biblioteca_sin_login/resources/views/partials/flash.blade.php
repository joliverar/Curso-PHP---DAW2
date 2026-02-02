@if (session('message'))
  <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-green-800">
    {{ session('message') }}
  </div>
@endif

@if ($errors->any())
  <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-red-800">
    <p class="font-semibold">Hay errores en el formulario:</p>
    <ul class="mt-2 list-disc pl-6">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
