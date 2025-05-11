<tr @class(["border-b-neutral-content", "bg-base-200" => $num % 2 !== 0])>
    <td class="whitespace-nowrap">{{ $hei->hei_name }}</td>
    <td>
        <div class="flex justify-center">
            <div class="join join-horizontal">
                @if ($hei->trashed())
                    <label for="restore-hei" x-on:click="$dispatch('restore-hei', {id:'{{ encrypt($hei->hei_id) }}'})"
                        class="badge badge-sm badge-success btn join-item">Restore <i
                            class="fa-solid fa-rotate-left"></i></label>
                @else
                    <label for="edit-hei-modal"
                        wire:click='$parent.updateEditInputs("{{ $hei->hei_id }}","{{ $hei->hei_name }}")'
                        class="badge badge-sm badge-primary btn join-item"><i class="fa-solid fa-pen"></i> Edit</label>
                @endif
                <label for="remove-hei" x-on:click="$dispatch('remove-hei', {id:'{{ encrypt($hei->hei_id) }}'})"
                    class="badge badge-sm badge-error btn join-item"><i class="fa-solid fa-trash"></i> Delete</label>
            </div>
        </div>
    </td>
</tr>
