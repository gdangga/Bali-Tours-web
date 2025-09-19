<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100">
                        <span class="sr-only">Buka sidebar</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path></svg>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="flex ml-2 md:mr-24">
                        <img src="{{ asset('Logo PBT Transparantw.png') }}" class="h-8 mr-3" alt="Logo PBT" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-gray-800">Admin PBT</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=F97316&background=FFEDD5" alt="user photo">
                    </button>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900">{{ Auth::user()->name }}</span>
                            <span class="block text-sm font-medium text-gray-500 truncate">{{ Auth::user()->email }}</span>
                        </div>
                        <ul class="py-1" aria-labelledby="user-menu-button">
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">
                <li><a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-orange-100"><span class="flex-1 ml-3 whitespace-nowrap">Dashboard</span></a></li>
                <li><a href="{{ route('admin.packages.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-orange-100"><span class="flex-1 ml-3 whitespace-nowrap">Paket Tour</span></a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-orange-100"><span class="flex-1 ml-3 whitespace-nowrap">Kategori Paket</span></a></li>
                <li><a href="{{ route('admin.cars.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-orange-100"><span class="flex-1 ml-3 whitespace-nowrap">Mobil</span></a></li>
                <li><a href="{{ route('admin.bookings.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-orange-100"><span class="flex-1 ml-3 whitespace-nowrap">Manajemen Booking</span></a></li>
                <li><a href="{{ route('admin.addons.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-orange-100"><span class="flex-1 ml-3 whitespace-nowrap">Addons</span></a></li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="p-8 border-2 border-gray-200 border-dashed rounded-lg mt-14 bg-white shadow">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">@yield('title')</h1>
            @yield('content')
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' });
        </script>
    @endif

    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
    <script>
        document.querySelectorAll('.ckeditor').forEach(editor => {
            ClassicEditor
                .create(editor)
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>