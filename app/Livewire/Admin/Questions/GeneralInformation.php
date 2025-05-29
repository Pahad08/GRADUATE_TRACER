<?php

namespace App\Livewire\Admin\Questions;

use App\Models\QuestionVisibility;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class GeneralInformation extends Component
{
    public $labels;

    public function removeQuestion($key)
    {
        QuestionVisibility::where('question_key', $key)->delete();
        unset($this->labels[$key]);
        $this->dispatch('question-removed', 'Question removed!');
    }

    //toggle visibilty of the question
    public function setLabelVisibility($key)
    {

        if (!Auth::check()) {
            abort(403);
        }

        $visibility = !$this->labels[$key]['is_visible'];
        QuestionVisibility::updateOrCreate(
            ['question_key' => $key],
            [
                'section_name' => 'GENERAL_INFORMATION',
                'is_visible' => $visibility,
                'question_order' => $this->labels[$key]['question_order'],
            ]
        );

        $message_identifier = $this->labels[$key]['is_visible'] ? 'hidden' : 'visible';
        $message = 'The ' . $this->labels[$key]['label'] . ' is now ' . $message_identifier;

        $this->dispatch('label-visibility-changed', $message);

        $this->labels[$key]['is_visible'] = $visibility;
    }

    public function updateOrder($ids)
    {
        $hasChanges = false;

        foreach ($ids as $id) {
            $currentOrder = $this->labels[$id['value']]['question_order'] ?? null;

            if ($currentOrder != $id['order']) {
                QuestionVisibility::where('question_key', $id['value'])
                    ->where('section_name', 'GENERAL_INFORMATION')
                    ->update(['question_order' => $id['order']]);

                $this->labels[$id['value']]['question_order'] = $id['order'];
                $hasChanges = true;
            }
        }

        if ($hasChanges) {
            $this->dispatch('order-changed', 'Order is updated.');
        }
    }

    //initialize labels
    public function loadLabels()
    {
        // Default fields of question
        $defaultFields = [
            'GI-f_name' => ['label' => 'First Name', 'question_order' => '1'],
            'GI-l_name' => ['label' => 'Last Name', 'question_order' => '2'],
            'GI-name_extension' => ['label' => 'Name Extension', 'question_order' => '3'],
            'GI-permanent_address' => ['label' => 'Permanent Address', 'question_order' => '4'],
            'GI-email' => ['label' => 'E-mail Address', 'question_order' => '5'],
            'GI-contact_number' => ['label' => 'Contact Number', 'question_order' => '6'],
            'GI-sex' => ['label' => 'Sex', 'question_order' => '7'],
            'GI-civil_status' => ['label' => 'Civil Status', 'question_order' => '8'],
            'GI-birthdate' => ['label' => 'Birthday', 'question_order' => '9'],
            'GI-region_of_origin' => ['label' => 'Region of Origin', 'question_order' => '10'],
            'GI-province' => ['label' => 'Province', 'question_order' => '11'],
            'GI-location_of_residence' => ['label' => 'Location of Residence', 'question_order' => '12'],
        ];

        // Initialize the visibility of question to false
        foreach ($defaultFields as $key => $label) {
            $this->labels[$key] = [
                'label' => $label['label'],
                'is_visible' => false,
                'question_order' => $label['question_order'],
                'custom_question' => false
            ];
        }

        // Override the visibility of question if it exist in the database
        $questions = QuestionVisibility::where('section_name', 'GENERAL_INFORMATION')->get();

        foreach ($questions as $question) {
            if (isset($this->labels[$question->question_key])) {
                $this->labels[$question->question_key]['is_visible'] = $question->is_visible;
                $this->labels[$question->question_key]['question_order'] = $question->question_order;
            }

            if (!isset($this->labels[$question->question_key])) {

                $label = $question->question->label;

                $this->labels[$question->question_key] = [
                    'label' => ucfirst($label),
                    'is_visible' => $question->is_visible,
                    'question_order' => $question->question_order,
                    'custom_question' => true
                ];
            }
        }

        uasort($this->labels, function ($a, $b) {
            return $a['question_order'] <=> $b['question_order'];
        });
    }

    #[On('question-created')]
    public function refreshLabels()
    {
        $this->loadLabels();
    }

    #[On('question-removed')]
    public function labelRemoved($key)
    {
        unset($this->labels[$key]);
    }

    public function render()
    {
        $this->loadLabels();

        return view('livewire.admin.questions.general-information');
    }
}