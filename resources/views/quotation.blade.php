@extends('base')

@section('content')
    <section x-data="quotationForm()" class="flex justify-center items-center min-h-screen bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-xl font-semibold mb-4 text-center">Trip quotation</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="ages" class="block mb-1 text-sm font-medium text-gray-900">Ages of travelers</label>
                    <input
                        type="text"
                        x-model="form.age"
                        placeholder="25,30"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="currency_id" class="block mb-1 text-sm font-medium text-gray-900">Currency</label>
                    <input
                        type="text"
                        x-model="form.currency_id"
                        placeholder="EUR"
                        maxlength="3"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block mb-1 text-sm font-medium text-gray-900">Start date</label>
                    <input
                        type="date"
                        x-model="form.start_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label for="end_date" class="block mb-1 text-sm font-medium text-gray-900">End date</label>
                    <input
                        type="date"
                        x-model="form.end_date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer"
                >
                    Generate
                </button>
            </form>

            <template x-if="total !== null">
                <div class="mt-6 bg-green-100 p-4 rounded text-green-800">
                    <p>The quotation for your trip has been generated.</p>
                    <p class="pt-3">Quotation ID: <span x-text="id"></span></p>
                    <p>Total: <span x-text="total"></span></p>
                </div>
            </template>

            <template x-if="error">
                <p class="mt-4 text-red-800 text-center" x-text="error"></p>
            </template>
        </div>
    </section>
@endsection

@pushonce('scripts')
    <script>
        function quotationForm() {
            return {
                form: {
                    age: '',
                    currency_id: '',
                    start_date: '',
                    end_date: '',
                },
                id: null,
                total: null,
                error: null,
                init: function () {
                    const token = localStorage.getItem('token');
                    if (!token) {
                        window.location.href = "{{ route('web.login') }}";
                    }
                },
                submit: async function () {
                    this.error = null;
                    this.total = null;

                    try {
                        const token = localStorage.getItem('token');

                        const response = await axios.post("{{ route('api.v1.quotation.store') }}", {
                            age: this.form.age,
                            currency_id: this.form.currency_id,
                            start_date: this.form.start_date,
                            end_date: this.form.end_date,
                        }, {
                            headers: {
                                Authorization: 'Bearer ' + token,
                                Accept: 'application/json',
                            },
                        });

                        if (response.data.total > 0) {
                            this.id = response.data.quotation_id;
                            this.total = `${response.data.total} ${response.data.currency_id}`;
                        } else {
                            this.error = 'Quotation is not available';
                        }
                    } catch (e) {
                        this.error = e.response?.data?.message || 'An error has ocurred while generating the quotation.';
                    }
                }
            }
        }
    </script>
@endpushonce
