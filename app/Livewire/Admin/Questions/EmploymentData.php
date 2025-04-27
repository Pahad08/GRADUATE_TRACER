<?php

namespace App\Livewire\Admin\Questions;

use App\Models\QuestionVisibility;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EmploymentData extends Component
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
                'section_name' => 'EMPLOYMENT_DATA',
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
                    ->where('section_name', 'EMPLOYMENT_DATA')
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
            'ED-is_employed' => ['label' => 'Is presently employed?', 'question_order' => '1'],
            'ED-reason_for_not_employed' => ['label' => 'Reason why you are not yet employed', 'question_order' => '2'],
            'ED-present_employment_status' => ['label' => 'Present Employment Status', 'question_order' => '3'],
            'ED-present_occupation' => ['label' => 'Occupation', 'question_order' => '4'],
            'ED-company_name' => ['label' => 'Company name', 'question_order' => '5'],
            'ED-line_of_busines' => ['label' => 'Major line of business of the company', 'question_order' => '6'],
            'ED-place_of_work' => ['label' => 'Place of work', 'question_order' => '7'],
            'ED-is_first_job' => ['label' => 'Is first job?', 'question_order' => '8'],
            'ED-job_retention_reason' => ['label' => 'Reason for staying on the job?', 'question_order' => '9'],
            'ED-is_related_to_course' => ['label' => 'Is related to the course you took up in college?', 'question_order' => '10'],
            'ED-job_acceptance_reason' => ['label' => 'What were your reasons for accepting the job?', 'question_order' => '11'],
            'ED-job_change_reason' => ['label' => 'What were your reasons for accepting the job?', 'question_order' => '12'],
            'ED-first_job_search_method' => ['label' => 'How did you find your first job?', 'question_order' => '13'],
            'ED-first_job_search_duration' => ['label' => 'How long did it take you to land your first job?', 'question_order' => '14'],
            'ED-first_job_position' => ['label' => 'First Job Position', 'question_order' => '15'],
            'ED-current_position' => ['label' => 'Current or Present Job', 'question_order' => '16'],
            'ED-initial_gross' => ['label' => 'First job initial gross after college', 'question_order' => '17'],
            'ED-curriculum_is_relevant' => ['label' => 'Was the curriculum relevant to first job?', 'question_order' => '18'],
            'ED-skill_in_college' => ['label' => 'What competencies learned in college that are very useful in first job?', 'question_order' => '19'],
            'ED-suggestions' => ['label' => 'Suggestions', 'question_order' => '20'],
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
        $questions = QuestionVisibility::where('section_name', 'EMPLOYMENT_DATA')->get();

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
        return view('livewire.admin.questions.employment-data');
    }
}