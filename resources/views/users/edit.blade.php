<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-4 sm:p-8">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600 mb-4 p-3 bg-red-100 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight border-b-2 border-slate-100 pb-4">
                            {{ __('Edit User: ') }} {{ $user->name }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-2">
                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                <i class="fas fa-user-shield mr-1"></i>{{ ucfirst($user->role) }}
                            </span>
                        </p>
                    </div>

                    <form method="post" action="{{ route('users.update', $user->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-user-edit text-blue-600"></i> {{ __('User Information') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Update user account and personal information") }}
                                </p>
                            </div>

                            <!-- Right Column - Form Fields -->
                            <div class="space-y-4">
                                <!-- Name (Read Only) -->
                                <div>
                                    <x-input-label for="name" :value="__('User Name')" />
                                    <x-text-input id="name" name="name" type="text" 
                                                  class="mt-1 block w-full bg-gray-100" 
                                                  value="{{ $user->name }}" 
                                                  readonly />
                                    <p class="text-xs text-gray-500 mt-1">Name cannot be changed</p>
                                </div>

                                <!-- Email (Read Only) -->
                                <div>
                                    <x-input-label for="email" :value="__('Email Address')" />
                                    <x-text-input id="email" name="email" type="email" 
                                                  class="mt-1 block w-full bg-gray-100" 
                                                  value="{{ $user->email }}" 
                                                  readonly />
                                    <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <x-input-label for="phone" :value="__('Phone *')" />
                                    <x-text-input id="phone" name="phone" type="text" 
                                                  class="mt-1 block w-full" 
                                                  value="{{ old('phone', $user->detail->phone ?? '') }}" 
                                                  required />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('New Password')" />
                                    <x-text-input id="password" name="password" type="password" 
                                                  class="mt-1 block w-full" 
                                                  placeholder="Leave blank to keep current password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>

                                <!-- Password Confirmation -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" 
                                                  class="mt-1 block w-full" />
                                </div>

                                <hr class="my-4">

                                <!-- Personal Details -->
                                <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300">Personal Details</h3>

                                <!-- Address -->
                                <div>
                                    <x-input-label for="address" :value="__('Address *')" />
                                    <x-text-input id="address" name="address" type="text" 
                                                  class="mt-1 block w-full" 
                                                  value="{{ old('address', $user->detail->address ?? '') }}" 
                                                  required />
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <x-input-label for="dob" :value="__('Date of Birth *')" />
                                    <x-text-input id="dob" name="dob" type="date" 
                                                  class="mt-1 block w-full" 
                                                  value="{{ old('dob', $user->detail && $user->detail->dob ? \Carbon\Carbon::parse($user->detail->dob)->format('Y-m-d') : '') }}" 
                                                  required />
                                    <x-input-error class="mt-2" :messages="$errors->get('dob')" />
                                </div>

                                <!-- PIN -->
                                <div>
                                    <x-input-label for="pin" :value="__('PIN')" />
                                    <x-text-input id="pin" name="pin" type="text" 
                                                  class="mt-1 block w-full" 
                                                  value="{{ old('pin', $user->detail->pin ?? '') }}" />
                                    <x-input-error class="mt-2" :messages="$errors->get('pin')" />
                                </div>

                                <!-- Package Info (Read Only) -->
                                @if($user->detail)
                                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg border border-blue-200">
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-info-circle mr-1"></i>Package Information
                                    </h4>
                                    <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                        <p><strong>Package:</strong> {{ $user->detail->package_name }}</p>
                                        <p><strong>Router:</strong> {{ $user->detail->router_name }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="px-2 py-1 rounded text-xs {{ $user->detail->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($user->detail->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-lock mr-1"></i>To change package, use the "Change Package" feature
                                    </p>
                                </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-between gap-4 pt-4 border-t">
                                    <a href="{{ route('users.show', $user->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md font-semibold text-xs uppercase transition">
                                        <i class="fas fa-arrow-left mr-2"></i> {{ __('Back') }}
                                    </a>
                                    
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-black rounded-md font-semibold text-xs uppercase transition">
                                        <i class="fas fa-save mr-2"></i> {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>