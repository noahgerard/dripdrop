<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex justify-center items-center max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 w-full sm:max-w-xl">
                <x-coffee-form mode="create" :showImage="true" />
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
</x-app-layout>
