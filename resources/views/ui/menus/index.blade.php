<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">

        <?php
        for ($i = 1; $i <= 4; $i++) {
        ?>
            <div class="position-relative shadow-lg p-3 mb-5 bg-body rounded" style="margin-bottom:50px">
                <?php
                $menus = App\Models\Menu::with('category')->where('category_id', $i)->get();
                $category = App\Models\Category::where('id', $i)->first();
                ?>

                <h1 class="text-center position-absolute top-50 start-50 translate-middle"style="font-size:30px;color:green">
                    {{$category->name}}</h1>
            </div>
            <div class="grid lg:grid-cols-4 gap-y-6">
                <?php
                foreach ($menus as $menu) {
                ?>
                    <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg" style="margin-bottom:50px">
                        <img class="w-full h-48" src="{{asset('images/'.$menu->image)}}" alt="Image" />
                        <div class="px-6 py-4">
                            <h4 class="mb-3 text-xl font-semibold tracking-tight text-green-600 uppercase">
                                {{ $menu->name }}
                            </h4>
                            <p class="leading-normal text-gray-700">{{ $menu->description }}.</p>
                        </div>
                        <div class="flex items-center justify-between p-4">
                            <span class="text-xl text-green-600">${{ $menu->price }}</span>
                        </div>
                    </div>
                <?php
                }

                ?>
            </div>
        <?php
        }

        ?>
    </div>
</x-guest-layout>