<ul class="flex gap-x-6">
    @foreach($apparelTypes as $apparelType)
    <li class="flex flex-col gap-y-4 p-6 rounded-lg bg-cGrey items-center justify-center transition ease-in-out animate-fade-in delay-200 hover:shadow-lg hover:animate-float">
        <img class="" src="{{ asset($apparelType->img) }}" alt="">
        <h5 class="font-inter text-xl">{{ $apparelType->name }}</h5>
    </li>
    @endforeach
</ul>