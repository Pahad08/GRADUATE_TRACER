<tr @class(["border-b-neutral-content", "bg-base-200" => $num % 2 !== 0])>
    <td class="whitespace-nowrap">{{ $graduate->f_name }}</td>
    <td class="whitespace-nowrap">{{ $graduate->l_name }}</td>
    <td class="whitespace-nowrap">{{ $graduate->permanent_address }}</td>
    <td class="whitespace-nowrap">{{ $graduate->email_address }}</td>
    <td class="whitespace-nowrap">{{ $graduate->contact_number }}</td>
    <td class="whitespace-nowrap">{{ $graduate->civil_status }}</td>
    <td class="whitespace-nowrap">{{ $graduate->sex }}</td>
    <td class="whitespace-nowrap">{{ $graduate->birthdate }}</td>
    <td class="whitespace-nowrap">{{ $graduate->region->region_name }}</td>
    <td class="whitespace-nowrap">{{ $graduate->province->province_name }}</td>
    <td class="whitespace-nowrap">{{ $graduate->location_of_residence }}</td>
    <td>
        <div class="join join-horizontal">
            @if ($graduate->trashed())
                <label for="restore-graduate"
                    x-on:click="$dispatch('restore-graduate', {id:'{{ encrypt($graduate->graduate_id) }}'})"
                    class="badge badge-sm badge-success btn join-item">Restore <i
                        class="fa-solid fa-rotate-left"></i></label>
            @else
                <a wire:navigate href="{{ url("view_graduate", ["encrypt_id" => encrypt($graduate->graduate_id)]) }}"
                    class="badge badge-sm badge-secondary btn join-item">View <i class="fa-solid fa-eye"></i></a>
            @endif
            <label for="remove-graduate"
                x-on:click="$dispatch('remove-graduate', {id:'{{ encrypt($graduate->graduate_id) }}'})"
                class="badge badge-sm badge-error btn join-item">Delete <i class="fa-solid fa-trash"></i></label>
        </div>
    </td>
</tr>
