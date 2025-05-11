<tr @class(["border-b-neutral-content", "bg-base-200" => $num % 2 !== 0])>
    <td class="whitespace-nowrap">{{ $account->username }}</td>
    <td class="whitespace-nowrap">{{ $hei_name }}</td>
    <td>
        <div class="flex justify-center">
            <div class="join join-horizontal">
                @if ($account->trashed())
                    <label for="restore-account"
                        x-on:click="$dispatch('restore-account', {id:'{{ encrypt($account->user_id) }}'})"
                        class="badge badge-sm badge-success btn join-item">Restore <i
                            class="fa-solid fa-rotate-left"></i></label>
                @else
                    <label for="edit-account-modal"
                        wire:click='$parent.updateEditInputs("{{ $account->user_id }}","{{ $account->username }}")'
                        class="badge badge-sm badge-primary btn join-item"><i class="fa-solid fa-pen"></i> Edit</label>
                @endif
                <label for="remove-account"
                    x-on:click="$dispatch('remove-account', {id:'{{ encrypt($account->user_id) }}'})"
                    class="badge badge-sm badge-error btn join-item"><i class="fa-solid fa-trash"></i> Delete</label>
            </div>
        </div>
    </td>
</tr>
