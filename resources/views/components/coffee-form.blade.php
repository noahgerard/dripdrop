@props(['coffee' => null, 'showImage' => true, 'mode' => 'create'])
@php
    if ($mode == 'create') {
        $method = 'POST';
        $action = route('coffee.create');
    } else {
        $method = 'PATCH';
        $action = route('coffee.edit');
    }
@endphp

<div class="flex flex-col gap-4 bg-white sm:rounded-2xl sm:shadow-lg px-8 sm:px-4 py-4 w-full sm:max-w-xl">
    <h2 class="pb-2 text-2xl font-bold">
        {{ $mode === 'edit' ? 'Edit Coffee Log' : 'Custom Coffee Logger' }}
    </h2>

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

    <form method="POST" action="{{ $action }}"
        @if ($showImage && $mode === 'create') enctype="multipart/form-data" @endif class="flex flex-col gap-2"
        x-data="coffeeForm()" x-init="init()" @submit.prevent="handleSubmit">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif
        @if ($coffee)
            <input type="hidden" name="id" value="{{ $coffee->id }}">
        @endif
        <input class="hidden" name="custom" value="yes">
        <input type="hidden" name="consumed_at" x-ref="consumed_at">

        <label for="title">Title</label>
        <input id="title" name="title" placeholder="E.g. Monday Morning Brew" maxlength=100
            class="p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200"
            value="{{ old('title', $coffee->title ?? '') }}" required />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />

        <label for="desc" class="mt-4">What's brewing?</label>
        <textarea id="desc" name="desc" placeholder="Share your coffee thoughts, recipe, or mood..." maxlength=1000
            class="p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 resize-none min-h-[120px]"
            required>{{ old('desc', $coffee->desc ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('desc')" class="mt-2" />

        <label for="coffee_type" class="mt-4">Coffee Type</label>
        <x-select id="coffee_type" name="coffee_type" :options="config('app.coffee.types')"
            class="block w-full p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 transition bg-white"
            value="{{ old('coffee_type', $coffee->type ?? '') }}" required />
        <x-input-error :messages="$errors->get('type')" class="mt-2" />

        <div class="flex gap-4">
            <div class="flex-1">
                <label for="consumed_at_date" class="mt-4">Date</label>
                <input id="consumed_at_date" name="consumed_at_date" type="date" x-ref="consumed_at_date"
                    class="mt-1 block w-full p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 transition bg-white"
                    value="{{ $mode === 'create' ? '' : old('consumed_at_date', $coffee && $coffee->consumed_at ? $coffee->consumed_at->format('Y-m-d') : '') }}"
                    required />
                <x-input-error :messages="$errors->get('consumed_at_date')" class="mt-2" />
            </div>
            <div class="flex-1">
                <label for="consumed_at_time" class="mt-4">Time</label>
                <input id="consumed_at_time" name="consumed_at_time" type="time" x-ref="consumed_at_time"
                    class="mt-1 block w-full p-3 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 transition bg-white"
                    value="{{ $mode === 'create' ? '' : old('consumed_at_time', $coffee && $coffee->consumed_at ? $coffee->consumed_at->format('H:i') : '') }}"
                    required />
                <x-input-error :messages="$errors->get('consumed_at_time')" class="mt-2" />
            </div>
        </div>

        @if ($showImage && $mode === 'create')
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
        @endif

        <div class="flex mt-4">
            <button type="submit"
                class="w-full bg-blue-700 transition rounded-md px-4 py-2 flex justify-center items-center gap-2 text-white font-semibold"
                x-bind:disabled="submitting || compressing">
                <template x-if="submitting">
                    <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </template>
                <template x-if="compressing">
                    <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                    </svg>
                </template>
                <x-lucide-coffee class="w-5 h-5" x-show="!submitting && !compressing" />
                <span x-show="!submitting && !compressing">{{ $coffee ? 'Save Changes' : 'Post' }}</span>
            </button>
        </div>
    </form>
</div>
<script>
    function coffeeForm() {
        return {
            previewUrl: null,
            submitting: false,
            compressing: false,
            consumed_at: (new Date()).toISOString(),
            async handleFileChange(event) {
                const file = event.target.files[0];
                if (file) {
                    this.compressing = true;
                    const options = {
                        maxSizeMB: 0.5,
                        maxWidthOrHeight: 1024,
                        useWebWorker: true
                    };
                    let compressedBlob = null;
                    let lastError = null;
                    for (let attempt = 0; attempt < 5; attempt++) {
                        try {
                            compressedBlob = await imageCompression(file, options);
                            lastError = null;
                            break;
                        } catch (error) {
                            lastError = error;
                        }
                    }
                    if (compressedBlob) {
                        let compressedFile = new File([compressedBlob], file.name, {
                            type: compressedBlob.type
                        });
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewUrl = e.target.result;
                        };
                        reader.readAsDataURL(compressedFile);
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        event.target.files = dataTransfer.files;
                    } else {
                        alert('Image compression failed after 5 attempts: ' + lastError.message);
                        this.previewUrl = null;
                        this.$refs.coffee_image.value = '';
                    }
                    this.compressing = false;
                } else {
                    this.previewUrl = null;
                }
            },
            removeFile() {
                this.previewUrl = null;
                this.$refs.coffee_image.value = '';
            },
            handleSubmit(e) {
                this.submitting = true;

                // Check refs before accessing
                if (!this.$refs.consumed_at_date || !this.$refs.consumed_at_time || !this.$refs.consumed_at) {
                    console.warn('Missing one or more refs: consumed_at_date, consumed_at_time, consumed_at');
                    this.submitting = false;
                    return;
                }

                let date = this.$refs.consumed_at_date.value;
                let time = this.$refs.consumed_at_time.value;

                const utcISO = (new Date(`${date}T${time}`)).toISOString();

                this.$refs.consumed_at.value = utcISO;

                e.target.submit();
            },
            init() {
                if ('{{ $mode }}' === 'create') {
                    // Set local date/time on create
                    const now = new Date();
                    const date = now.toISOString().slice(0, 10);
                    const time = now.toTimeString().slice(0, 5);
                    if (this.$refs.consumed_at_date) this.$refs.consumed_at_date.value = date;
                    if (this.$refs.consumed_at_time) this.$refs.consumed_at_time.value = time;
                } else if ('{{ $mode }}' === 'edit') {
                    let iso = '{{ $coffee && $coffee->consumed_at ? $coffee->consumed_at->format('c') : '' }}';
                    // Parse as UTC by appending 'Z' if not present
                    if (iso && !iso.endsWith('Z') && !iso.match(/[+-]\d{2}:?\d{2}$/)) {
                        iso += 'Z';
                    }
                    if (iso) {
                        const local = new Date(iso);
                        const date = local.toISOString().slice(0, 10);
                        const time = local.toTimeString().slice(0, 5);
                        if (this.$refs.consumed_at_date) this.$refs.consumed_at_date.value = date;
                        if (this.$refs.consumed_at_time) this.$refs.consumed_at_time.value = time;
                    }
                }

                // Local time rendering for .local-coffee-time
                document.querySelectorAll('.local-coffee-time').forEach(function(el) {
                    const iso = el.getAttribute('data-iso');
                    if (iso) {
                        const d = new Date(iso);
                        if (!isNaN(d)) {
                            el.textContent = d.toLocaleString([], {
                                dateStyle: 'medium',
                                timeStyle: 'short'
                            });
                        }
                    }
                });
            }
        }
    }
</script>
