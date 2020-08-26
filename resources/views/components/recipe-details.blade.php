<div class="RecipeDetails">

    <div class="author">
        Published by {{ $recipe->user->name }}
    </div>
    <ul class="BulletList">
        <li>
            @icon('badge')
            {{ $recipe->rating }}
        </li>
        <li>
            @icon('time')
            {{ $recipe->cook_time }} mins
        </li>
        <li>
            @icon('food')
            Serves {{ $recipe->serving_size }}
        </li>
    </ul>
    <p class="text">
        {{ $recipe->description }}
    </p>
    <ul class="tags">
        <li>Vegetarian</li>
        <li>Budget-friendly</li>
        <li>Easy</li>
    </ul>

</div>
