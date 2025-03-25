<div class="rounded-none px-3" x-data="{ isEmployed: '' }">
    <div class="card lg:w-250 md:w-230 border-1 border-base-300 mx-auto my-5 max-w-full bg-white">
        <div class="card-body rounded-lg shadow-md">
            <div class="grid grid-cols-1">
                <div>
                    <label class="text-neutral mb-2 block text-sm font-semibold">Are you presently employed?</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="employed" x-model="isEmployed" class="radio" value="yes">
                            <span class="ml-2">Yes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="employed" x-model="isEmployed" class="radio" value="no">
                            <span class="ml-2">No</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="employed" class="radio" x-model="isEmployed"
                                value="never employed">
                            <span class="ml-2">Never Employed</span>
                        </label>
                    </div>
                </div>

                <div x-show="isEmployed !== 'yes' && isEmployed !== ''" x-transition>
                    <div class="divider"></div>

                    <label class="text-neutral mb-2 block text-sm font-semibold">
                        Please state reason(s) why you are not yet employed.</label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="checkbox">
                            <span class="ml-2">Advance or further study</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="checkbox">
                            <span class="ml-2">No job opportunity</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="checkbox">
                            <span class="ml-2">Family concern and decided not to find a job</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="checkbox">
                            <span class="ml-2">Health-related reason(s)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="checkbox">
                            <span class="ml-2">Lack of work experience</span>
                        </label>
                    </div>

                    <label class="mt-3 flex items-center">
                        <input type="text" class="input w-full bg-white"
                            placeholder="Other reason(s), please specify">
                    </label>
                </div>

                <div x-data="{ isFirstJob: '', isRelated: '' }" x-show="isEmployed === 'yes' && isEmployed !== ''" x-transition>
                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">Present Employment Status</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="employment_status" class="radio"
                                    value="Regular or Permanent">
                                <span class="ml-2">Regular or Permanent</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="employment_status" class="radio" value="Contractual">
                                <span class="ml-2">Contractual</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="employment_status" class="radio" value="Temporary">
                                <span class="ml-2">Temporary</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="employment_status" class="radio" value="Self-employed">
                                <span class="ml-2">Self-employed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="employment_status" class="radio" value="Casual">
                                <span class="ml-2">Casual</span>
                            </label>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">Present occupation(Use the
                            following Phil. Standard Occupational Classification (PSOC), 1992 classification) </label>
                        <select name="" id="" class="select w-full bg-white">
                            <option selected disabled value="">Present occupation</option>
                            @foreach ($occupations as $occupation)
                                <option value="{{ $occupation }}">{{ $occupation }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <label
                            class="text-neutral mb-2 block text-sm font-semibold after:text-red-500 after:content-['*']">Name
                            of Company or Organization including address </label>
                        <input type="text"
                            class="input @error("form.name_of_company") input-error @enderror w-full bg-white">
                    </div>

                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">Major line of business of the
                            company
                            you
                            are presently employed in.</label>
                        <select class="select w-full bg-white">
                            <option>Agriculture, Hunting and Forestry</option>
                            <option>Fishing</option>
                            <option>Mining and Quarrying</option>
                            <option>Manufacturing</option>
                            <option>Electricity, Gas and Water Supply</option>
                            <option>Construction</option>
                            <option>Wholesale and Retail Trade, repair of motor vehicles, motorcycles and
                                personal and household goods</option>
                            <option>Hotels and Restaurants</option>
                            <option>Transport Storage and Communication</option>
                            <option>Financial Intermediation</option>
                            <option>Real Estate, Renting and Business Activities</option>
                            <option>Public Administration and Defense; Compulsory Social Security</option>
                            <option>Education</option>
                            <option>Health and Social Work</option>
                            <option>Other Community, Social and Personal Service Activities</option>
                            <option>Private Households with Employed Persons</option>
                            <option>Extra-territorial Organizations and Bodies</option>
                        </select>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">Place of work</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="place_of_work" class="radio" value="Local">
                                <span class="ml-2">Local</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="place_of_work" class="radio" value="Abroad">
                                <span class="ml-2">Abroad</span>
                            </label>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">Is this your first job after
                            college?</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="first_job" x-model="isFirstJob" class="radio"
                                    value="yes">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="first_job" x-model="isFirstJob" class="radio"
                                    value="no">
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>

                    <div x-show="isFirstJob === 'yes' && isFirstJob !== ''" x-transition>
                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">What are your reason(s) for
                                staying on
                                the job?</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Salaries and benefits</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Career challenge</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Related to special skill</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Related to course or program of study</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Proximity to residence</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Peer influence</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Family influence</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Other reason(s), please specify</span>
                                </label>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">Is your first job related to
                                the
                                course
                                you took up in college?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="related_job" x-model="isRelated" class="radio"
                                        value="yes">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="related_job" x-model="isRelated" class="radio"
                                        value="no">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <div class="divider" x-show="isRelated === 'yes' && isRelated !== ''" x-transition></div>

                        <div x-show="isRelated === 'yes' && isRelated !== ''" x-transition>
                            <label class="text-neutral mb-2 block text-sm font-semibold">What were your reasons for
                                accepting
                                the
                                job?</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Salaries & benefits</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Career challenge</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Related to special skills</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Proximity to residence</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Other reason(s), please specify</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="divider" x-show="isFirstJob === 'no' && isFirstJob !== ''" x-transition></div>

                    <div x-show="isFirstJob === 'no' && isFirstJob !== ''" x-transition>
                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">What were your reason(s) for
                                changing
                                job?</label>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Salaries & benefits</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Career challenge</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Related to special skills</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Proximity to residence</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="checkbox">
                                    <span class="ml-2">Other reason(s), please specify</span>
                                </label>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div>
                            <label class="text-neutral mb-2 block text-sm font-semibold">How long did you stay in your
                                first
                                job?</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="job_duration" class="radio"
                                        value="Less than a month">
                                    <span class="ml-2">Less than a month</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="job_duration" class="radio" value="1 to 6 months">
                                    <span class="ml-2">1 to 6 months</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="job_duration" class="radio" value="7 to 11 months">
                                    <span class="ml-2">7 to 11 months</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="job_duration" class="radio"
                                        value="1 year to less than 2 years">
                                    <span class="ml-2">1 year to less than 2 years</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="job_duration" class="radio"
                                        value="2 years to less than 3 years">
                                    <span class="ml-2">2 years to less than 3 years</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="job_duration" class="radio"
                                        value="3 years to less than 4 years">
                                    <span class="ml-2">3 years to less than 4 years</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="job_duration" class="radio"
                                        value="Others, please specify">
                                    <span class="ml-2">Others, please specify</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">How did you find your first
                            job?</label>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">Response to an advertisement</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">As walk-in applicant</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">Recommended by someone</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">Information from friends</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">Arranged by school’s job placement officer</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">Family business</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">Job Fair or Public Employment Service Office (PESO)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="checkbox">
                                <span class="ml-2">Others, please specify</span>
                            </label>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">How long did it take you to land
                            your
                            first job?</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="job_search_duration" class="radio"
                                    value="Less than a month">
                                <span class="ml-2">Less than a month</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="job_search_duration" class="radio"
                                    value="1 to 6 months">
                                <span class="ml-2">1 to 6 months</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="job_search_duration" class="radio"
                                    value="7 to 11 months">
                                <span class="ml-2">7 to 11 months</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="job_search_duration" class="radio"
                                    value="1 year to less than 2 years">
                                <span class="ml-2">1 year to less than 2 years</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="job_search_duration" class="radio"
                                    value="2 years to less than 3 years">
                                <span class="ml-2">2 years to less than 3 years</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="job_search_duration" class="radio"
                                    value="3 years to less than 4 years">
                                <span class="ml-2">3 years to less than 4 years</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="job_search_duration" class="radio"
                                    value="Others, please specify">
                                <span class="ml-2">Others, please specify</span>
                            </label>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <label class="text-neutral mb-2 block text-sm font-semibold">Job Level Position</label>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-neutral mb-2 block text-sm font-semibold">First Job</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="first_job_level" class="radio"
                                            value="Rank or Clerical">
                                        <span class="ml-2">Rank or Clerical</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="first_job_level" class="radio"
                                            value="Professional, Technical or Supervisory">
                                        <span class="ml-2">Professional, Technical or Supervisory</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="first_job_level" class="radio"
                                            value="Managerial or Executive">
                                        <span class="ml-2">Managerial or Executive</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="text-neutral mb-2 block text-sm font-semibold">Current or Present
                                    Job</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="current_job_level" class="radio"
                                            value="Rank or Clerical">
                                        <span class="ml-2">Rank or Clerical</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="current_job_level" class="radio"
                                            value="Professional, Technical or Supervisory">
                                        <span class="ml-2">Professional, Technical or Supervisory</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="current_job_level" class="radio"
                                            value="Managerial or Executive">
                                        <span class="ml-2">Managerial or Executive</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>

                <div>
                    <label class="text-neutral block text-sm font-semibold after:text-red-500 after:content-['*']">
                        List down suggestions to further improve your course curriculum
                    </label>
                    @foreach ($form->suggestions as $key => $row)
                        <div class="{{ !$loop->first ? "mt-2" : "" }} grid grid-cols-3 items-end gap-y-2"
                            wire:key="{{ "suggestion-" . $key }}">
                            <div class="col-span-2">
                                <input type="text" wire:model="form.suggestions.{{ $key }}"
                                    class="input {{ !$loop->first ? "mt-2" : "" }} {{ $errors->has("form.suggestions.$key") ? "input-error" : "focus:border-gray-300 focus:outline-none" }} w-full bg-white md:rounded-none">
                            </div>

                            <div class="col-span-1">
                                @if ($loop->first)
                                    <button wire:click='addSuggestionInput' wire:loading.attr="disabled"
                                        class="btn btn-primary mt-2 md:rounded-none" type="button">
                                        <span wire:loading wire:target="addSuggestionInput"
                                            class="loading loading-spinner"></span>
                                        <i wire:target="addSuggestionInput" wire:loading.remove
                                            class="fa-solid fa-plus text-white"></i>
                                    </button>
                                @else
                                    <button wire:click='deleteSuggestionInput({{ $key }})'
                                        wire:loading.attr="disabled" class="btn btn-primary mt-2 md:rounded-none"
                                        type="button">
                                        <span wire:loading wire:target="deleteSuggestionInput({{ $key }})"
                                            class="loading loading-spinner"></span>
                                        <i wire:target="deleteSuggestionInput({{ $key }})" wire:loading.remove
                                            class="fa-solid fa-trash text-white"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-2 flex justify-end">
                    <button class="btn btn-primary" x-on:click="$dispatch('form-submitted')" wire:click="save"
                        wire:loading.attr="disabled"><span wire:target="save" wire:loading.remove>Submit</span>
                        <span wire:loading wire:target="save" class="loading loading-spinner"></span><span
                            wire:loading wire:target="save">Submitting</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
