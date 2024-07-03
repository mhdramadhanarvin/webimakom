@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-slate-100 text-gray-900 text-sm rounded-lg border-slate-300 focus:ring-purple-700 focus:border-blue-500 block w-full p-2.5 placeholder-zinc-400']) !!}>
