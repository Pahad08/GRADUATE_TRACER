<?php

namespace App\Livewire\Admin\Questions;

use App\Models\QuestionVisibility;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class EducationalBackground extends Component
{
    public $labels;

    //toggle visibilty of the question
    public function setLabelVisibility(string $key)
    {

        if (!Auth::check()) {
            abort(403);
        }

        $visibility = !$this->labels[$key]['is_visible'];
        QuestionVisibility::updateOrCreate(
            ['question_key' => $key],
            [
                'section_name' => 'EDUCATIONAL_BACKGROUND',
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
                    ->where('section_name', 'EDUCATIONAL_BACKGROUND')
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
            'EB-educational_attainment' => [
                'label' => 'Educational Attainment',
                'question_order' => 1
            ],
            'EB-professional_examination' => [
                'label' => 'Professional Examination',
                'question_order' => 2
            ],
            'EB-reason_for_course' => [
                'label' => 'Reason for taking the course',
                'question_order' => 3
            ],
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
        $questions = QuestionVisibility::where('section_name', 'EDUCATIONAL_BACKGROUND')->get();

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

        return view('livewire.admin.questions.educational-background');
    }
}
