<x-app-layout>
    <div class="max-w-xl mx-auto py-12">
        <div x-data="coffeeForm()">
            <x-coffee-form :coffee="$coffee" :showImage="false" mode="edit" />
        </div>
    </div>
</x-app-layout>
