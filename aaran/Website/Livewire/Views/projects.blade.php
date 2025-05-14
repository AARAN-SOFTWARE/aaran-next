<div class="text-black bg-gray-200">
    <div class="h-[40vh] text-center flex justify-center text-white items-center bg-blue-500">
        <div class="text-6xl">Products</div>
    </div>
    <div class="my-15 text-4xl text-center">Featured Apps</div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 w-[80%] h-max mx-auto gap-4 p-4 items-stretch">
        @foreach($featured as $featuredApps)
            <x-Ui::web.project.featured-apps
                :icon="$featuredApps->icon"
                :title="$featuredApps->title"
                :description="$featuredApps->description"
            />
        @endforeach
    </div>

    <div class="my-15 text-4xl text-center">Upcoming Apps</div>

    <div class="grid grid-cols-1 sm:grid-cols-2 mx-auto w-[80%] lg:grid-cols-3 gap-4 h-max p-4">
        @foreach($upcoming as $upcomingApps)
            <x-Ui::web.project.upcoming-apps
                :icon="$upcomingApps->icon"
                :title="$upcomingApps->title"
                :description="$upcomingApps->description"
            />
        @endforeach
    </div>
    <x-Ui::web.home-new.footer />
    <x-Ui::web.home-new.copyright/>
</div>
