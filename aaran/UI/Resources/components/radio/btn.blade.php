@props([
    'value' => null,
])
<div class="flex items-center mb-4">
    <input {{$attributes}}  type="radio" value="{{$value}}" name="default-radio"
           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
    <label  class="ms-2 text-sm font-medium text-gray-900 ">{{$slot}}</label>
</div>

