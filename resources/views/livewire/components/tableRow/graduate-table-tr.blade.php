<tr @class(["border-b-base-300"])>
    <td class="whitespace-nowrap">{{ $graduate->f_name }}</td>
    <td class="whitespace-nowrap">{{ $graduate->l_name }}</td>
    <td class="whitespace-nowrap">{{ $graduate->permanent_address }}</td>
    <td class="whitespace-nowrap">{{ $graduate->email_address }}</td>
    <td class="whitespace-nowrap">{{ $graduate->contact_number }}</td>
    <td class="whitespace-nowrap">{{ $graduate->civil_status }}</td>
    <td class="whitespace-nowrap">{{ $graduate->sex }}</td>
    <td class="whitespace-nowrap">{{ $graduate->birthdate }}</td>
    <td class="whitespace-nowrap">{{ $graduate->region }}</td>
    <td class="whitespace-nowrap">{{ $graduate->province }}</td>
    <td class="whitespace-nowrap">{{ $graduate->location_of_residence }}</td>
    <td>
        <div class="join join-horizontal">
            @if ($graduate->trashed())
                <label for="restore-graduate"
                    x-on:click="$dispatch('restore-graduate', {id:'{{ encrypt($graduate->graduate_id) }}'})"
                    class="badge badge-sm badge-success btn join-item"><i class="fa-solid fa-rotate-left"></i>
                    Restore</label>
            @else
                @php
                    $link = auth()->user()->inst_id === null ? "view_graduate" : "graduate";
                @endphp
                <a wire:navigate href="{{ url($link, ["encrypt_id" => encrypt($graduate->graduate_id)]) }}"
                    class="badge badge-sm badge-secondary btn join-item"><i class="fa-solid fa-eye"></i> View</a>
            @endif
            @if (auth()->user()->inst_id === null && !$graduate->trashed())
                <label for="remove-graduate"
                    x-on:click="$dispatch('remove-graduate', {id:'{{ encrypt($graduate->graduate_id) }}'})"
                    class="badge badge-sm badge-error btn join-item"><i class="fa-solid fa-trash"></i> Delete</label>
            @endif
        </div>
    </td>
</tr>
