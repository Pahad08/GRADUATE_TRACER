<tr class="border-b-base-300">
    <td class="whitespace-nowrap">{{ $start_year }}</td>
    <td class="whitespace-nowrap">{{ $end_year }}</td>
    <td>
        <div class="flex justify-center">
            <div class="join join-horizontal">
                <label for="edit-academic-year-modal"
                    wire:click='$parent.updateEditInputs("{{ $academic_year_id }}","{{ $start_year }}")'
                    class="badge badge-sm badge-primary btn join-item"><i class="fa-solid fa-pen"></i> Edit</label>
                <label for="remove-academic-year"
                    x-on:click="$dispatch('remove-academic-year', {id:'{{ encrypt($academic_year_id) }}'})"
                    class="badge badge-sm badge-error btn join-item"><i class="fa-solid fa-trash"></i>
                    Delete</label>
            </div>
        </div>
    </td>
</tr>
