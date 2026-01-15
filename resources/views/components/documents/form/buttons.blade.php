<x-form.section>
    <x-slot name="foot">
        <div class="flex justify-end">
            <x-form.buttons cancel-route="{{ $cancelRoute }}" save-loading="! send_to && form.loading" />


        </div>
    </x-slot>
</x-form.section>
