<div class="rounded-none px-3">
    <div class="card lg:w-250 md:w-230 border-1 border-base-300 mx-auto my-5 max-w-full bg-white">
        <div class="card-body rounded-lg shadow-md">
            <div class="grid grid-cols-1">
                <p class="font-medium">Please list down all
                    professional or
                    work-related training program(s) including advance studies you have attended after
                    college.</p>
                <div class="grid grid-cols-1">
                    @foreach ($this->trainings as $key => $row)
                        <div x-data="{ trainings_errors: {} }" x-on:trainings-error.window="trainings_errors=$event.detail[0];"
                            class="{{ $loop->first ? "mt-2" : "" }} grid w-full grid-cols-1 items-end gap-y-2 md:grid-cols-4"
                            wire:key="{{ "trainings-" . $key }}">

                            <div class="col-span-1">
                                @if ($loop->first)
                                    <label
                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                        Title of Training
                                    </label>
                                @endif
                                <input type="text" wire:model="trainings.{{ $key }}.training_name"
                                    :class="(errors['tracer-components.studies-information'] && errors[
                                        'tracer-components.studies-information'][
                                        'trainings.{{ $key }}.training_name'
                                    ]) || trainings_errors[
                                            'trainings.{{ $key }}.training_name'] ?
                                        'input-error' : ''"
                                    class="input {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none">
                            </div>

                            <div class="col-span-1">
                                @if ($loop->first)
                                    <label
                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                        Duration and Credits Earned
                                    </label>
                                @endif
                                <input type="text"
                                    :class="(errors['tracer-components.studies-information'] && errors[
                                        'tracer-components.studies-information'][
                                        'trainings.{{ $key }}.duration_and_credits_earned'
                                    ]) ||
                                    trainings_errors['trainings.{{ $key }}.duration_and_credits_earned'] ?
                                        'input-error' : ''"
                                    wire:model="trainings.{{ $key }}.duration_and_credits_earned"
                                    class="input {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none md:border-x-0">
                            </div>

                            <div class="col-span-1">
                                @if ($loop->first)
                                    <label
                                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">
                                        Name of Training Institution
                                    </label>
                                @endif
                                <input type="text" wire:model="trainings.{{ $key }}.training_institution"
                                    :class="(errors['tracer-components.studies-information'] && errors[
                                        'tracer-components.studies-information'][
                                        'trainings.{{ $key }}.training_institution'
                                    ]) || trainings_errors[
                                            'trainings.{{ $key }}.training_institution'] ?
                                        'input-error' : ''"
                                    class="input {{ !$loop->first ? "mt-2" : "" }} w-full bg-white md:rounded-none">
                            </div>

                            <div>
                                @if ($loop->first)
                                    <button class="btn btn-primary mt-2 w-full md:rounded-none" type="button"
                                        wire:click="addTrainingRow" wire:loading.attr="disabled">
                                        <span wire:loading wire:target="addTrainingRow"
                                            class="loading loading-spinner"></span>
                                        <i class="fa-solid fa-plus text-white" wire:target="addTrainingRow"
                                            wire:loading.remove></i>
                                    </button>
                                @else
                                    <button wire:loading.attr="disabled"
                                        class="btn btn-primary mt-2 w-full rounded-none" type="button"
                                        wire:click="removeTrainingRow({{ $key }})">
                                        <span wire:loading wire:target="removeTrainingRow({{ $key }})"
                                            class="loading loading-spinner"></span>
                                        <i class="fa-solid fa-trash text-white"
                                            wire:target="removeTrainingRow({{ $key }})"
                                            wire:loading.remove></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="divider"></div>

                <div class="mt-2">
                    <label
                        class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">What
                        made you pursue advance
                        studies? </label>
                    <div class="md:grid-cols-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="checkbox" value="For promotion"
                                wire:model="reasons_for_study.checkboxes">
                            <span class="ml-2">For promotion</span>
                        </label>

                        <label class="mt-3 flex items-center">
                            <input type="checkbox" class="checkbox" value="For professional development"
                                wire:model="reasons_for_study.checkboxes">
                            <span class="ml-2">For professional development</span>
                        </label>

                        <input type="text" placeholder="Others, please specify" wire:model="reasons_for_study.input"
                            class="input mt-3 w-full bg-white md:col-span-2">
                    </div>

                    <template
                        x-if="errors['tracer-components.studies-information'] && errors['tracer-components.studies-information']['reasons_for_study.input']">
                        <div class="mt-1">
                            <p class="text-error"
                                x-text="errors['tracer-components.studies-information']['reasons_for_study.input']"></p>
                        </div>
                    </template>

                    <template
                        x-if="errors['tracer-components.studies-information'] && errors['tracer-components.studies-information']['reasons_for_study.checkboxes']">
                        <div class="mt-1">
                            <p class="text-error"
                                x-text="errors['tracer-components.studies-information']['reasons_for_study.checkboxes']">
                            </p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
