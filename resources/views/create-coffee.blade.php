<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex justify-center items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 bg-white sm:rounded-2xl sm:shadow-lg px-8 sm:px-4 py-4 w-full sm:max-w-xl">
                <h2 class="pb-2 text-2xl font-bold">Custom Coffee Logger</h2>

                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route(name: 'coffee.create') }}" enctype="multipart/form-data"
                    class="flex flex-col gap-2" x-data="{
                        previewUrl: null,
                        handleFileChange(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    this.previewUrl = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            } else {
                                this.previewUrl = null;
                            }
                        },
                        removeFile() {
                            this.previewUrl = null;
                            $refs.coffee_image.value = '';
                        }
                    }">
                    @csrf

                    <input class="hidden" name="custom" value="yes">

                    <label for="title">Title</label>
                    <input id="title" name="title" placeholder="E.g. Monday Morning Brew" maxlength=100
                        class="p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200"
                        required></input>

                    <label for="desc" class="mt-4">What's brewing?</label>
                    <textarea id="desc" name="desc" placeholder="Share your coffee thoughts, recipe, or mood..." maxlength=1000
                        class="p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none min-h-[120px]"></textarea>

                    <label for="coffee_type" class="mt-4">Coffee Type</label>
                    <x-select id="coffee_type" name="coffee_type" :options="config('app.coffee.types')"
                        class="block w-full p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 transition bg-white"
                        required />

                    <label for="coffee_image" class="flex items-center gap-2 mt-4">
                        <x-lucide-image class="w-5 h-5" />
                        <span>Add Photo</span>
                    </label>
                    <input type="file" id="coffee_image" name="coffee_image" accept="image/*"
                        class="p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 bg-white transition file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        x-ref="coffee_image" @change="handleFileChange">
                    <template x-if="previewUrl">
                        <div class="relative mt-2">
                            <img :src="previewUrl" alt="Preview"
                                class="max-h-48 rounded-md border border-gray-200 w-full object-contain" />
                            <button type="button" @click="removeFile"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow">&times;</button>
                        </div>
                    </template>

                    <button type="submit"
                        class="mt-4 hover:cursor-pointer bg-blue-700 hover:bg-blue-800 transition rounded-md px-4 py-2 flex justify-center items-center gap-2 text-white font-semibold">
                        <x-lucide-coffee class="w-5 h-5" /> Post
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
