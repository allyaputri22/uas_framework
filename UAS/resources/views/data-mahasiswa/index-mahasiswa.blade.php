<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="container mx-auto p-4">
    <div class="overflow-x-auto">
      @if (session('success'))
      <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-700">
        {{ session('success') }}
      </div>
      @elseif (session('error'))
      <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700">
        {{ session('error') }}
      </div>
      @endif

      <form method="GET" action="{{ route('index-mahasiswa') }}" class="mb-4 flex items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mahasiswa..." class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        <button type="submit" class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Cari</button>
    </form>


      <div class="mb-4">
        <a href="{{ route('create-mahasiswa') }}">
          <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
            Add Mahasiswa
          </button>
        </a>

        <a href="{{ route('mahasiswa-export-excel') }}">
          <button class="px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
            Export ke Excel
          </button>
        </a>
      </div>

      <table class="min-w-full border border-collapse border-gray-200 w-full">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">ID</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">NPM</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Nama</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Prodi</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $item)
          <tr class="bg-white">
            <td class="px-4 py-2 border border-gray-200">{{ $item->id }}</td>
            <td class="px-4 py-2 border border-gray-200">{{ $item->npm }}</td>
            <td class="px-4 py-2 border border-gray-200">{{ $item->name }}</td>
            <td class="px-4 py-2 border border-gray-200">{{ $item->prodi }}</td>
            <td class="px-4 py-2 border border-gray-200">
                <a href="{{ route('edit-mahasiswa', $item->id) }}" class="inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Edit
                </a>
                <button class="inline-flex items-center px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="confirmDelete('{{ route('deleted-mahasiswa', $item->id) }}')">
                    Hapus
                </button>
            </td>
           
          @empty
          <p class="mb-4 text-center text-2xl font-bold text-red-608">Data mahasiswa tidak ditemukan</p>
          @endforelse
        </tbody>
      </table>

      {{-- Pagination --}}
      <div class="mt-4 bg-white p-4 rounded shadow">
        {{$data->appends(['search' => request('search')])->links()}}
      </div>

      <script>
        function confirmDelete(deleteUrl) {
          console.log(deleteUrl);
          if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;

            let csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            let methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
          }
        }
      </script>
    </div>
</x-app-layout>