<?php

namespace App\Livewire\TracerComponents;

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
    protected function getReasons($array, $data_key)
    {
        $new_data = [];
        foreach ($array as $data) {
            if (is_array($data) && !empty($data)) {
                //loop again if the value is an array or checkbox
                foreach ($data as $item) {
                    $new_data[] = [$data_key => $item];
                }
            } elseif (!empty($data)) {
                // Add non-array values to the new array directly
                $new_data[] = [$data_key => $data];
            }
        }

        return $new_data;
    }

    //get reasons
    protected function getEmploymentReasons($array, $reason_type)
    {
        $new_data = [];
        foreach ($array as $data) {
            if (is_array($data) && !empty($data)) {
                //loop again if the value is an array or checkbox
                foreach ($data as $item) {
                    $new_data[] = ['reason_type' => $reason_type, 'reason' => $item];
                }
            } elseif (!empty($data)) {
                // Add non-array values to the new array directly
                $new_data[] = ['reason_type' => $reason_type, 'reason' => $data];
            }
        }

        return $new_data;
    }

    private function insertGraduates()
    {

        DB::transaction(function () {
            // dump($this->validated_data);

            $general_information = $this->validated_data['general_information'];
            $educational_background = $this->validated_data['educational_background'];
            $reason_for_course = $this->getReasons($educational_background['reasons'], 'reason');

            $studies_information = $this->validated_data['studies_information'];
            $reason_for_study = $this->getReasons($studies_information['reasons_for_study'], 'reason_for_study');

            $employment_data = $this->validated_data['employment_data'];
            //remove index 0 from the array
            array_shift($educational_background['educational_attainment']);
            array_shift($educational_background['professional_examination']);
            array_shift($studies_information['trainings']);

            $graduates = [
                'f_name' => $general_information['f_name'],
                'l_name' => $general_information['l_name'],
                'permanent_address' => $general_information['permanent_address'],
                'email_address' => $general_information['email_address'],
                'contact_number' => $general_information['contact_number'],
                'sex' => $general_information['sex'],
                'civil_status' => $general_information['civil_status'],
                'birthdate' => $general_information['birthdate'],
                'region_id' => $general_information['region_id'],
                'province_id' => $general_information['province_id'],
                'location_of_residence' => $general_information['location_of_residence'],
                'degree_level' => $educational_background['type'],
            ];

            $new_graduate = Graduate::create($graduates);
            $new_graduate->EducationalBackground()->createMany($educational_background['educational_attainment']);
            $new_graduate->ProfessionalExamination()->createMany($educational_background['professional_examination']);
            $new_graduate->ReasonForCourse()->createMany($reason_for_course);
            $new_graduate->Training()->createMany($studies_information['trainings']);
            $new_graduate->ReasonPursueStudies()->createMany($reason_for_study);

            $employment_status = $new_graduate->EmploymentStatus()->create(['is_employed' => $employment_data['is_employed']]);

            if ($employment_data['is_employed'] !== 'yes') {
                $reason_for_unemployment = $this->getEmploymentReasons($employment_data['unemployment_reason'], 'unemployment');
                $employment_status->EmploymentReason()->createMany($reason_for_unemployment);
            } else {
                $employment_details = [
                    'present_employment_status' => $employment_data['present_employment_status'],
                    'occupation' => $employment_data['occupation'],
                    "company_name" => $employment_data['company_name'],
                    'industry' => $employment_data['industry'],
                    "first_job_level" => $employment_data['first_job_level'],
                    'current_job_level' => $employment_data['current_job_level'],
                    "first_job_initial_gross" => $employment_data['first_job_initial_gross'],
                    'work_location' => $employment_data['place_of_work'],
                    "is_first_job" => (int) $employment_data['is_first_job'],
                    'related_to_course' => (int)$employment_data['related_to_course'],
                    "is_curriculum_relevant_to_job" => (int) $employment_data['is_curriculum_relevant_to_job'],
                ];

                $employment_details_model = new EmploymentDetails($employment_details);

                $employment_status->EmploymentDetails()->save($employment_details_model);
            }
        });

        $this->dispatch('set-active-tab', ['active_tab' => 'tracer-components.general-information']);
    }

    #[Title('Graduate Tracer')]
    public function render()
    {
        return view('livewire.index');
    }
}
