<?php

namespace App\Livewire\TracerComponents;

use App\Models\CustomQuestion;
use App\Models\EmploymentDetails;
use App\Models\Graduate;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class TrackingForm extends Component
{
    public $civil_status_selection = ['single', 'married', 'separated', 'widow or widower', 'single parent'];
    public $childComponents = [
        'tracer-components.general-information' => [
            'icon' => 'fa-user',
            'title' => 'General Information',
        ],
        'tracer-components.educational-background' => [
            'icon' => 'fa-user-graduate',
            'title' => 'Educational Background',
        ],
        'tracer-components.studies-information' => [
            'icon' => 'fa-certificate',
            'title' => 'Training/Advance Studies',
        ],
        'tracer-components.employment-data' => [
            'icon' => 'fa-user-tie',
            'title' => 'Employment Data',
        ]
    ];
    protected $eventCompletion = 0;
    protected $totalEvents = 4;
    protected $validated_data = [];

    #[On('validated-general-information')]
    public function general_information_validated($general_information)
    {
        $this->validated_data['general_information'] = $general_information;
        $this->checkCompletion();
    }

    #[On('validated-education-background')]
    public function educational_background_validated($educational_background)
    {
        $this->validated_data['educational_background'] = $educational_background;
        $this->checkCompletion();
    }

    #[On('validated-studies-information')]
    public function studies_information_validated($studies_information)
    {
        $this->validated_data['studies_information'] = $studies_information;
        $this->checkCompletion();
    }

    #[On('validated-employment-data')]
    public function employment_data_validated($employment_data)
    {
        $this->validated_data['employment_data'] = $employment_data;
        $this->checkCompletion();
    }

    //check if all of the events are finished
    private function checkCompletion()
    {
        $this->eventCompletion++;

        if ($this->eventCompletion === $this->totalEvents) {
            $this->insertGraduates();
        }
    }

    //loop the data and get the value from checkbox and input
    protected function extractInputsAndCheckboxes($array, $data_key, $type = null, $key = 'type')
    {
        $new_data = [];
        foreach ($array as $data) {
            if (is_array($data) && !empty($data)) {
                //loop again if the value is an array or checkbox
                foreach ($data as $item) {
                    if (empty($item)) {
                        continue;
                    }
                    $new_data[] = [$data_key => $item, $key => $type];
                }
            } elseif (!empty($data)) {
                // Add non-array values to the new array directly
                $new_data[] = [$data_key => $data, $key => $type];
            }
        }

        return $new_data;
    }

    protected function createResponse($key, $value, $new_graduate)
    {
        $label = str_replace('_', ' ', $key);
        $custom_question = CustomQuestion::where('label', $label)->first();

        if (is_array($value)) {
            foreach ($value as $item) {
                $data_to_insert = [
                    'graduate_id' => $new_graduate->graduate_id,
                    'response_value' => (string) $item
                ];

                $custom_question->response()->create($data_to_insert);
            }
        } else {
            $data_to_insert = [
                'graduate_id' => $new_graduate->graduate_id,
                'response_value' => $value
            ];

            $custom_question->response()->create($data_to_insert);
        }
    }

    protected function checkEducationalAttainment($educational_background)
    {;
        $is_empty = empty(array_filter([
            $educational_background['degree_id'],
            $educational_background['university_id'],
            $educational_background['year_graduated']
        ]));

        return $is_empty;
    }

    private function insertGraduates()
    {

        DB::transaction(function () {
            //reason types to insert in the database
            $reason_types = [
                'pursue_study_reason',
                'unemployment_reason',
                'job_retention_reason',
                'job_acceptance_reason',
                'job_change_reason',
                'suggestion'
            ];
            $general_information = $this->validated_data['general_information'];

            $educational_background = $this->validated_data['educational_background'];
            $reason_for_undergraduates = $this->extractInputsAndCheckboxes($educational_background['reasons_for_undergraduate'], 'reason', 'undergraduate', 'degree_level');
            $reason_for_graduates = $this->extractInputsAndCheckboxes($educational_background['reasons_for_graduate'], 'reason', 'graduate', 'degree_level');
            // dd($educational_background);
            $studies_information = $this->validated_data['studies_information'];
            $reason_for_study = $this->extractInputsAndCheckboxes($studies_information['reasons_for_study'], 'reason', $reason_types[0]);

            $employment_data = $this->validated_data['employment_data'];

            //remove index 0 from the array
            if (count($educational_background['professional_examination']) > 1) {
                array_shift($educational_background['professional_examination']);
            }
            if (count($studies_information['trainings']) > 1) {
                array_shift($studies_information['trainings']);
            }

            if (count($employment_data['suggestions']) > 1) {
                array_shift($employment_data['suggestions']);
            }

            $graduates = [
                'f_name' => $general_information['f_name'],
                'l_name' => $general_information['l_name'],
                'permanent_address' => $general_information['permanent_address'],
                'email_address' => $general_information['email_address'],
                'contact_number' => $general_information['contact_number'],
                'sex' => $general_information['sex'],
                'civil_status' => $general_information['civil_status'],
                'birthdate' => $general_information['birthdate'],
                'region_id' => $general_information['region'],
                'province_id' => $general_information['province'],
                'location_of_residence' => $general_information['location_of_residence'],
            ];

            //create graduate
            $new_graduate = Graduate::create($graduates);

            //add custom question response
            foreach ($general_information['custom_questions'] as $key => $value) {
                $this->createResponse($key, $value, $new_graduate);
            }

            foreach ($educational_background['custom_questions'] as $key => $value) {
                $this->createResponse($key, $value, $new_graduate);
            }

            foreach ($studies_information['custom_questions'] as $key => $value) {
                $this->createResponse($key, $value, $new_graduate);
            }

            foreach ($employment_data['custom_questions'] as $key => $value) {
                $this->createResponse($key, $value, $new_graduate);
            }

            //add the educational background of the graduate
            foreach ($educational_background['educational_attainment'] as $key => $value) {
                $educational_background_to_add = [];
                $educational_background_to_add['degree_id'] = $value['degree_id'];
                $educational_background_to_add['university_id'] = $value['university_id'];
                $educational_background_to_add['year_graduated'] = $value['year_graduated'];

                if (!$this->checkEducationalAttainment($educational_background_to_add)) {
                    $new_educational_background = $new_graduate->educationalBackground()->create($educational_background_to_add);
                    $honors = [];
                    foreach ($value['honor'] as $key => $honor) {
                        if (empty($honor)) {
                            continue;
                        }
                        $honors[] = ['honor' => $honor];
                    }
                    $new_educational_background->honor()->createMany($honors);
                }
            }

            //add educational examinations of the graduate
            $new_graduate->professionalExamination()->createMany($educational_background['professional_examination']);

            //add the reasons for course of the graduate
            if (!empty($reason_for_undergraduates)) {
                $new_graduate->reasonForCourse()->createMany($reason_for_undergraduates);
            }

            if (!empty($reason_for_graduates)) {
                $new_graduate->reasonForCourse()->createMany($reason_for_graduates);
            }

            //add the trainings of the graduate
            $new_graduate->training()->createMany($studies_information['trainings']);

            //add the reason for pursuing the study of the graduate
            $new_graduate->reason()->createMany($reason_for_study);

            //add the employment status of the graduate
            $employment_status = $new_graduate->employmentStatus()->create(['is_employed' => $employment_data['is_employed']]);

            if ($employment_data['is_employed'] !== 'yes') {
                //add the unemployment reason of the graduate if unemployed
                $reason_for_unemployment = $this->extractInputsAndCheckboxes($employment_data['unemployment_reason'], 'reason', $reason_types[1]);
                $new_graduate->reason()->createMany($reason_for_unemployment);
            } else {
                $job_detail_types = [
                    'college_skill',
                    'first_job_search_method',
                    'first_job_search_duration',
                    'first_job_duration',
                    'first_job_salary_range'
                ];

                $employment_details = [
                    'present_employment_status' => $employment_data['present_employment_status'],
                    'occupation' => $employment_data['occupation'],
                    "company_name" => $employment_data['company_name'],
                    'industry' => $employment_data['industry'],
                    'work_location' => $employment_data['place_of_work'],
                    "is_first_job" => (int) $employment_data['is_first_job'],
                    'is_related_to_course' => (int)$employment_data['related_to_course'],
                    "is_curriculum_relevant_to_job" => (int) $employment_data['is_curriculum_relevant_to_job'],
                    "first_job_level" => $employment_data['first_job_level'],
                    'current_job_level' => $employment_data['current_job_level'],
                ];
                //add the employment details of the graduate if employed
                $employment_details_model = new EmploymentDetails($employment_details);
                $employment_details = $employment_status->employmentDetails()->save($employment_details_model);

                if ((int)$employment_data['is_first_job']) {
                    //add job retentions
                    $job_retentions = $this->extractInputsAndCheckboxes($employment_data['job_retention'], 'reason', 'job_retention_reason');
                    $new_graduate->reason()->createMany($job_retentions);

                    if ((int)$employment_data['related_to_course']) {
                        //add job acceptance reason
                        $related_to_course_reasons = $this->extractInputsAndCheckboxes($employment_data['job_acceptance'], 'reason', 'job_acceptance_reason');
                        $new_graduate->reason()->createMany($related_to_course_reasons);
                    }
                } else {
                    //add job change
                    $job_change = $this->extractInputsAndCheckboxes($employment_data['job_change'], 'reason', $reason_types[4]);
                    $new_graduate->reason()->createMany($job_change);

                    //add first job duration
                    $employment_details->jobDetails()->create(['description' => $employment_data['first_job_duration'], 'type' => $job_detail_types[3]]);
                }

                //add first job search source or method
                $job_sources = $this->extractInputsAndCheckboxes($employment_data['job_source'], 'description', $job_detail_types[1]);
                $employment_details->jobDetails()->createMany($job_sources);

                //add first job search duration
                $employment_details->jobDetails()->create(['description' => $employment_data['first_job_search_duration'], 'type' => $job_detail_types[2]]);

                //add first job initial salary gross
                $employment_details->jobDetails()->create(['description' => $employment_data['first_job_initial_gross'], 'type' => $job_detail_types[4]]);

                //add skills
                if ((int)$employment_data['is_curriculum_relevant_to_job']) {
                    $skills = $this->extractInputsAndCheckboxes($employment_data['skills'], 'description', $job_detail_types[0]);
                    $employment_details->jobDetails()->createMany($skills);
                }
            }

            if (count($employment_data['suggestions']) > 0) {
                $suggestions = $this->extractInputsAndCheckboxes($employment_data['suggestions'], 'reason', $reason_types[5]);
                $new_graduate->reason()->createMany($suggestions);
            }

            $this->dispatch('graduate-created', message: 'Graduate created successfully.');
        });

        $this->totalEvents = 0;
        $this->eventCompletion = 0;
        $this->validated_data = [];
    }

    #[Title('Graduate Tracer')]
    public function render()
    {
        return view('livewire.index');
    }
}
