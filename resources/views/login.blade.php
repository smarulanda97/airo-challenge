@extends('base')

@section('content')
    <section x-data="loginForm()" class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-xl font-semibold mb-4 text-center">Login</h1>
            <p class="my-3 text-xs text-gray-500 text-center">
                Use this user for testing:
                <strong>email:</strong> test@example.com
                <strong>password:</strong> 123456
            </p>
            <form @submit.prevent="submit" class="mx-auto">
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                    <input
                        type="email"
                        x-model="form.email"
                        placeholder="example@gmail.com"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required
                    />
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Your password</label>
                    <input
                        type="password"
                        x-model="form.password"
                        placeholder="**************"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center cursor-pointer"
                >
                    Sign in
                </button>
            </form>
            <template x-if="error">
                <p class="mt-4 text-red-800 text-center" x-text="error"></p>
            </template>
        </div>
    </section>
@endsection

@pushonce('scripts')
    <script>
        function loginForm() {
            return {
                error: null,
                form: {
                    email: '',
                    password: ''
                },
                submit: async function() {
                    this.error = null;

                    try {
                        const response = await axios.post("{{ route('api.login') }}", {
                            email: this.form.email,
                            password: this.form.password,
                        });

                        // In a real project would store the token in a secure cookie
                        // instead of the local storage. Making it more secure and less
                        // vulnerable to XSS

                        localStorage.setItem('token', response.data.token);
                        window.location.href = "{{ route('web.quotation') }}";
                    } catch (e) {
                        this.error = e.response.data.message;
                    }
                }
            }
        }
    </script>
@endpushonce
