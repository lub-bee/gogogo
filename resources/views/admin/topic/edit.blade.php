<x-admin-layout>

    <div class="flex justify-between">
        <div>
            {{$topic->name}}
        </div>
        <div>
            Last modification : {{$topic->updated_at}}
        </div>
        <div>
            Author : {{$topic->user_id}}
        </div>
    </div>
    <div>
        {{$topic->description_en}}
    </div>
    <div>
        {{$topic->description_ja}}
    </div>


</x-admin-layout>
