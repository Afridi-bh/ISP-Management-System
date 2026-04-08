<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Add New User/Customer</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" class="bg-white shadow rounded p-6 space-y-4">
            @csrf

            <!-- ⭐ Account Type Selection -->
            <div class="bg-blue-50 border border-blue-200 rounded p-4">
                <label class="font-semibold text-gray-700">Account Type *</label>
                <div class="mt-2 space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="account_type" value="user" class="mr-2" checked>
                        <span>User</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="account_type" value="customer" class="mr-2">
                        <span>Customer (Can login to customer portal)</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Password *</label>
                    <input type="password" name="password" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded p-2" required>
            </div>

            <hr class="my-4">

            <h3 class="text-lg font-semibold">Details</h3>

            <div>
                <label class="font-semibold text-gray-700">Address *</label>
                <input type="text" name="address" value="{{ old('address') }}" class="w-full border rounded p-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Date of Birth *</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">PIN</label>
                    <input type="text" name="pin" value="{{ old('pin') }}" class="w-full border rounded p-2">
                </div>
            </div>

            <hr class="my-4">

            <h3 class="text-lg font-semibold">Package & Router</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Package *</label>
                    <select name="package_name" class="w-full border rounded p-2" required>
                        <option value="">Select Package</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ old('package_name') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }} - ৳{{ $package->price }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Router *</label>
                    <select name="router_name" class="w-full border rounded p-2" required>
                        <option value="">Select Router</option>
                        @foreach($routers as $router)
                            <option value="{{ $router->id }}" {{ old('router_name') == $router->id ? 'selected' : '' }}>
                                {{ $router->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Router Password *</label>
                <input type="text" name="router_password" value="{{ old('router_password') }}" class="w-full border rounded p-2" required>
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('users.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</x-app-layout>