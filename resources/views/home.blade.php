<x-app-layout>
    <main class="h-full py-20 flex flex-col">
        <div class="flex-1 flex justify-center">
            <div>
                <h1 class="font-bold text-5xl">Drip<span class="text-blue-700">Drop</span></h1>
                <h3>The DSC Coffee Tracker</h3>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row md:min-h-[15rem] mt-[10rem] transition-all">
            <x-slogan-card icon_name="lucide-bean" word="Bean." title="It starts with the source."
                description="Every cup begins with a choice — the bean you select reflects your taste, your energy, your identity. Discover what fuels you. Who are you becoming through your daily habits?"
                :image="asset('images/bean.png')" />

            <x-slogan-card icon_name="lucide-coffee" word="Brew." title="It takes intention."
                description="You don't just drink coffee — you craft it. From rushed mornings to slow rituals, your brew reflects your pace. How are you creating space in your day for what matters?"
                :image="asset('images/brew.png')" />

            <x-slogan-card icon_name="lucide-activity" word="Brag." title="It ends with the flex."
                description="You've logged the bean. You've nailed the brew. Now it's time to brag. Whether it's your fifth cup or the cleanest pour-over, every sip is a stat. Who's winning today?"
                :image="asset('images/brag.png')" />

        </div>
    </main>

    <style>
    </style>
</x-app-layout>
