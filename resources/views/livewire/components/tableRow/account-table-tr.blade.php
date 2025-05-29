<tr class="border-b-base-300">
    <td class="whitespace-nowrap">{{ $username }}</td>
    <td class="whitespace-nowrap">{{ $inst_name }}</td>
    <td>
        <div class="flex justify-center">
            <div class="join join-horizontal">
                <label for="edit-account-modal"
                    wire:click='$parent.updateEditInputs("{{ $user_id }}","{{ $username }}")'
                    class="badge badge-sm badge-primary btn join-item"><i class="fa-solid fa-pen"></i> Edit</label>

                <label for="remove-account" x-on:click="$dispatch('remove-account', {id:'{{ encrypt($user_id) }}'})"
                    class="badge badge-sm badge-error btn join-item"><i class="fa-solid fa-trash"></i> Delete</label>
            </div>
        </div>
    </td>
</tr>
