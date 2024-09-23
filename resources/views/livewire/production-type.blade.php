<ul class="flex gap-x-6">
    @foreach($productionTypes as $productionType)
    <li class="flex flex-col gap-y-4 p-6 rounded-lg bg-cGrey items-center justify-center transition ease-in-out animate-fade-in hover:shadow-lg">
        <img class="" src="{{ asset($productionType->img) }}" alt="">
        <h5 class="font-inter text-xl">{{ $productionType->name }}</h5>
    </li>
    @endforeach
</ul>